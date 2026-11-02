<?php

use App\Models\Inquiry;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('portfolio:messages {--id= : Lihat satu pesan lengkap} {--limit=20 : Maksimal jumlah pesan}', function () {
    $clean = fn ($value) => preg_replace('/[\x00-\x1F\x7F]|\x1B\[[0-?]*[ -\/]*[@-~]/u', ' ', $value);

    if ($id = $this->option('id')) {
        $inquiry = Inquiry::find($id);
        if (! $inquiry) {
            $this->error('Pesan tidak ditemukan.');

            return 1;
        }
        $this->table(['Kolom', 'Isi'], collect($inquiry->only(['id', 'name', 'email', 'service', 'message', 'created_at']))->map(fn ($value, $key) => [$key, $clean((string) $value)])->all());

        return 0;
    }

    $limit = max(1, min(100, (int) $this->option('limit')));
    $messages = Inquiry::latest('id')->limit($limit)->get();
    if ($messages->isEmpty()) {
        $this->info('Belum ada pesan masuk.');

        return 0;
    }
    $this->table(['ID', 'Nama', 'Email', 'Layanan', 'Tanggal'], $messages->map(fn ($message) => [
        $message->id,
        $clean($message->name),
        $clean($message->email),
        $clean($message->service),
        $message->created_at->format('d/m/Y H:i'),
    ])->all());
    $this->info('Lihat isi lengkap: php artisan portfolio:messages --id=ID');

    return 0;
})->purpose('Baca pesan portofolio secara lokal; tidak tersedia melalui web');
