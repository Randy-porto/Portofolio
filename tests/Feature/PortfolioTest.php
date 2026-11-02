<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_all_four_disciplines_and_honest_demo_labels(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('Merekam cerita.', false)
            ->assertSee('FOTO WISUDA')
            ->assertSee('AFTERMOVIE')
            ->assertSee('KONTEN KREATIF')
            ->assertSee('WEB DEVELOPMENT')
            ->assertSee('KONSEP DEMO')
            ->assertSee('name="_token"', false);
    }

    public function test_each_project_has_a_working_detail_page(): void
    {
        foreach (config('portfolio.projects') as $project) {
            $this->get('/karya/'.$project['slug'])->assertOk()
                ->assertSee($project['subtitle'])
                ->assertSee($project['description'])
                ->assertSee('konsep demo');
        }
    }

    public function test_category_filter_works_on_server_without_javascript(): void
    {
        $response = $this->get('/?kategori=fotografi')->assertOk()->assertViewHas('category', 'fotografi');
        $html = $response->getContent();
        $this->assertMatchesRegularExpression('/data-category="fotografi"\s*>/', $html);
        $this->assertMatchesRegularExpression('/data-category="film"\s+hidden/', $html);
        $this->get('/?kategori=invalid')->assertOk()->assertViewHas('category', 'semua');
        $this->get('/?kategori[]=fotografi')->assertOk()->assertViewHas('category', 'semua');
    }

    public function test_all_works_are_grouped_in_requested_order_and_filter_hides_other_collections(): void
    {
        $this->get('/')->assertOk()->assertSeeInOrder([
            'data-project-group="fotografi"',
            'data-project-group="film"',
            'data-project-group="development"',
            'data-project-group="konten"',
        ], false);

        $html = $this->get('/?kategori=film')->assertOk()->getContent();
        $dom = new \DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $xpath = new \DOMXPath($dom);

        $this->assertSame(1, $xpath->query('//section[@data-project-group and not(@hidden)]')->length);
        $this->assertSame('film', $xpath->query('//section[@data-project-group and not(@hidden)]')->item(0)->getAttribute('data-project-group'));
        $this->assertSame(0, $xpath->query('//section[@data-project-group="fotografi"]//article[@data-category!="fotografi"]')->length);
    }

    public function test_unknown_project_has_a_real_not_found_response(): void
    {
        $this->get('/karya/does-not-exist')->assertNotFound()->assertSee('Cerita ini');
    }

    public function test_valid_contact_message_is_stored_and_acknowledged(): void
    {
        $this->post('/kontak', $this->validMessage())
            ->assertRedirect(route('home').'#kontak')
            ->assertSessionHas('contact_success');

        $this->assertDatabaseHas('inquiries', $this->validMessage());
        $this->assertDatabaseCount('inquiries', 1);
    }

    public function test_invalid_contact_data_never_reaches_database(): void
    {
        $this->from('/')->post('/kontak', ['name' => '', 'email' => 'invalid', 'service' => 'unsupported', 'message' => 'short'])
            ->assertRedirect('/')
            ->assertSessionHasErrors(['name', 'email', 'service', 'message'], null, 'contact');

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_honeypot_blocks_bot_submissions(): void
    {
        $this->post('/kontak', [...$this->validMessage(), 'website' => 'https://spam.example'])
            ->assertRedirect(route('home').'#kontak');
        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_contact_endpoint_has_rate_limit(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/kontak', $this->validMessage())->assertRedirect();
        }
        $this->post('/kontak', $this->validMessage())->assertStatus(429)->assertSee('sedikit jeda');
        $this->assertDatabaseCount('inquiries', 5);
    }

    public function test_oversized_message_is_rejected(): void
    {
        $this->post('/kontak', [...$this->validMessage(), 'message' => str_repeat('a', 5001)])
            ->assertSessionHasErrors('message', null, 'contact');
        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_inbox_is_only_accessible_through_local_artisan_command(): void
    {
        $this->get('/inquiries')->assertNotFound();
        $this->get('/admin')->assertNotFound();
        $this->artisan('portfolio:messages')->expectsOutput('Belum ada pesan masuk.')->assertSuccessful();

        $message = Inquiry::create($this->validMessage());
        $this->artisan('portfolio:messages', ['--id' => $message->id])->assertSuccessful();
        $this->artisan('portfolio:messages', ['--id' => 9999])->expectsOutput('Pesan tidak ditemukan.')->assertFailed();
    }

    public function test_contact_values_are_escaped_when_redisplayed(): void
    {
        $response = $this->from('/')->followingRedirects()->post('/kontak', [
            ...$this->validMessage(),
            'name' => '<script>alert(1)</script>',
            'message' => 'short',
        ]);

        $response->assertOk()->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    private function validMessage(): array
    {
        return [
            'name' => 'Pengunjung Demo',
            'email' => 'visitor@example.com',
            'service' => 'Fotografi',
            'message' => 'Saya ingin mendiskusikan rencana sesi foto wisuda.',
        ];
    }
}
