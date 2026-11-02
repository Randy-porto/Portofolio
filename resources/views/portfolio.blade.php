@extends('layouts.app')

@section('content')
<section class="hero container" aria-labelledby="hero-title">
    <div class="hero-copy">
        <div class="eyebrow"><span class="status-dot"></span> CREATIVE MIND. HUMAN TOUCH.</div>
        <h1 id="hero-title">Merekam cerita.<br>Membangun<br><span class="serif lime">pengalaman.</span><span class="hero-asterisk" aria-hidden="true">✳</span></h1>
        <p class="hero-description">Halo, saya <strong>{{ config('portfolio.name') }}</strong>. {{ config('portfolio.intro') }}</p>
        <div class="hero-actions">
            <a class="button button-lime" href="#karya">Jelajahi karya <x-icon size="19" /></a>
            <a class="text-link" href="#tentang">Sedikit tentang saya <span>↗</span></a>
        </div>
        <div class="hero-note"><span class="note-line"></span> Di balik setiap karya, selalu ada cerita.</div>
    </div>
    <div class="hero-visual">
        <div class="visual-topline"><span>THE WORLD THROUGH MY LENS</span><span>01 / 04</span></div>
        <div class="hero-image-wrap">
            <img class="hero-image" src="{{ asset('images/photography.jpg') }}" width="1900" height="1501" alt="Kamera dan lensa di atas peta, ilustrasi eksplorasi dunia fotografi" fetchpriority="high">
            <span class="image-corner top-left"></span><span class="image-corner bottom-right"></span>
            <span class="hero-image-label"><span class="status-dot"></span> ALWAYS EXPLORING</span>
            <div class="hero-image-caption"><span>Little moments.<br><em>Lasting stories.</em></span><x-icon name="camera" size="26" /></div>
        </div>
        <div class="creative-sticker" aria-hidden="true"><span>VISUAL & DIGITAL</span><span class="sticker-star">✳</span><span>MADE WITH FEELING</span></div>
        <div class="visual-bottomline"><span>Photography, films & thoughtful code.</span><a href="#karya" aria-label="Gulir ke karya"><x-icon name="down" size="20" /></a></div>
    </div>
</section>

<div class="discipline-bar" aria-label="Bidang keahlian">
    <div class="container disciplines"><span>FOTOGRAFI</span><span class="separator-star">✳</span><span>FILMMAKING</span><span class="separator-star">✳</span><span>KONTEN KREATIF</span><span class="separator-star">✳</span><span>WEB DEVELOPMENT</span><span class="separator-star">✳</span></div>
</div>

<section class="work-section light-section section-pad" id="karya" aria-labelledby="work-title">
    <div class="container">
        <div class="section-heading">
            <div><div class="eyebrow dark-muted">01 / SELECTED WORK</div><h2 id="work-title">Ide menjadi <span class="serif">karya.</span><span class="lime-square" aria-hidden="true">↗</span></h2></div>
            <p>Beragam medium, satu tujuan.<br>Menciptakan sesuatu yang bermakna.</p>
        </div>
        <div class="work-toolbar">
            <nav class="filters" aria-label="Filter kategori karya">
                @foreach(config('portfolio.categories') as $key => $label)
                    <a class="filter {{ $category === $key ? 'active' : '' }}" href="{{ route('home', $key === 'semua' ? [] : ['kategori' => $key]) }}#karya" data-filter="{{ $key }}" @if($category === $key) aria-current="true" @endif>{{ $label }}@if($key === 'semua')<span>{{ str_pad(count($projects), 2, '0', STR_PAD_LEFT) }}</span>@endif</a>
                @endforeach
            </nav>
            <span class="work-count" aria-live="polite" id="work-count">{{ $category === 'semua' ? count($projects) : collect($projects)->where('category', $category)->count() }} karya</span>
        </div>
        <div class="project-galleries">
            @foreach(config('portfolio.gallery') as $key => $gallery)
                @php($groupProjects = collect($projects)->where('category', $key))
                @continue($groupProjects->isEmpty())
                <section class="gallery-group" data-project-group="{{ $key }}" aria-labelledby="gallery-title-{{ $key }}" @if($category !== 'semua' && $category !== $key) hidden @endif>
                    <div class="gallery-heading">
                        <div class="gallery-intro">
                            <div class="gallery-title-row"><span class="gallery-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><h3 id="gallery-title-{{ $key }}">{{ config('portfolio.categories.'.$key) }}</h3><span class="gallery-total">{{ $groupProjects->count() }} karya</span></div>
                            <p>{{ $gallery['description'] }}</p>
                        </div>
                        <div class="gallery-navigation" data-gallery-controls hidden>
                            <button class="gallery-prev" type="button" data-gallery-direction="-1" aria-controls="gallery-track-{{ $key }}" aria-label="Geser {{ config('portfolio.categories.'.$key) }} ke kiri" disabled><x-icon name="right" size="18" /></button>
                            <button type="button" data-gallery-direction="1" aria-controls="gallery-track-{{ $key }}" aria-label="Geser {{ config('portfolio.categories.'.$key) }} ke kanan" disabled><x-icon name="right" size="18" /></button>
                        </div>
                    </div>
                    <div class="gallery-track" id="gallery-track-{{ $key }}" data-gallery-track role="region" tabindex="0" aria-labelledby="gallery-title-{{ $key }}" aria-describedby="gallery-hint-{{ $key }}">
                        @foreach($groupProjects as $project)
                            <article class="project-card" data-format="{{ $gallery['format'] }}" data-category="{{ $project['category'] }}" @if($category !== 'semua' && $category !== $project['category']) hidden @endif>
                                <a class="project-image-link {{ $project['category'] }}" href="{{ route('projects.show', $project['slug']) }}" aria-label="Lihat {{ $project['subtitle'] }}">
                                    <img class="{{ str_ends_with($project['image'], '.svg') ? 'illustration' : '' }}" src="{{ asset($project['image']) }}" alt="{{ $project['alt'] }}" width="{{ $gallery['format'] === 'portrait' ? 450 : 600 }}" height="{{ $gallery['format'] === 'portrait' ? 800 : 600 }}" loading="lazy">
                                    <span class="project-type">{{ $project['label'] }}</span>
                                    @if($project['demo'])<span class="project-demo">KONSEP DEMO</span>@endif
                                    <span class="project-open"><x-icon size="22" /></span>
                                    @if($project['category'] === 'film')<span class="film-caption">{{ $project['demo'] ? 'A FILM CONCEPT' : 'A FILM' }} BY {{ strtoupper(config('portfolio.name')) }}</span>@endif
                                </a>
                                <div class="project-caption"><div><a href="{{ route('projects.show', $project['slug']) }}"><h4>{{ $project['subtitle'] }}</h4></a><p>{{ $project['title'] }}</p></div><span>{{ $project['year'] }}</span></div>
                            </article>
                        @endforeach
                    </div>
                    <p class="gallery-hint" id="gallery-hint-{{ $key }}"><span data-gallery-scroll-hint hidden>Geser ke samping untuk melihat karya lainnya <x-icon name="right" size="14" /></span><span data-gallery-static-hint>{{ $groupProjects->count() }} karya dalam koleksi ini</span><span class="gallery-format">{{ $gallery['format'] === 'portrait' ? '9:16 / PORTRAIT' : '1:1 / SQUARE' }}</span></p>
                </section>
            @endforeach
        </div>
        @if(collect($projects)->contains('demo', true))<p class="demo-note"><span>↳</span> Galeri ini berisi konsep demo sebagai gambaran gaya karya. Proyek dan dokumentasi asli akan ditambahkan.</p>@endif
    </div>
</section>

<section class="about-section section-pad" id="tentang" aria-labelledby="about-title">
    <div class="container about-grid">
        <div class="about-art" aria-hidden="true">
            <div class="about-art-top"><span>A LITTLE ABOUT ME</span><x-icon name="spark" size="22" /></div>
            <div class="about-monogram">{{ mb_substr(config('portfolio.name'), 0, 1) }}<span>.</span></div>
            <div class="about-art-bottom"><span>Curiosity is<br>my creative fuel.</span><div class="coordinate-lines"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div></div>
            <span class="about-art-tag">THE PERSON BEHIND THE WORK</span>
        </div>
        <div class="about-copy">
            <div class="eyebrow">02 / BEYOND THE WORK</div>
            <h2 id="about-title">Satu perspektif.<br><span class="serif lime">Banyak kemungkinan.</span></h2>
            <p>Saya {{ config('portfolio.name') }}, kreator visual sekaligus IT developer. Bagi saya, kreativitas tidak berhenti di satu medium. Kadang ia hadir lewat sebuah foto. Kadang lewat video, konten, atau baris kode.</p>
            <p>Saya senang menemukan titik temu antara estetika dan fungsi. Membuat hal-hal yang tidak hanya terlihat baik, tetapi juga terasa tepat.</p>
            <h3 class="experience-label">BIDANG YANG SAYA TEKUNI</h3>
            <div class="experience-row"><span>01</span><div><h4>Visual storytelling</h4><p>Konten kreatif · Foto wisuda · Aftermovie</p></div><x-icon name="camera" size="22" /></div>
            <div class="experience-row"><span>02</span><div><h4>Digital craftsmanship</h4><p>Web development · Laravel · Antarmuka web</p></div><x-icon name="code" size="22" /></div>
            <a class="text-link lime" href="#kontak">Kenalan lebih dekat <x-icon size="17" /></a>
        </div>
    </div>
</section>

<section class="services-section section-pad" id="layanan" aria-labelledby="services-title">
    <div class="container">
        <div class="section-heading"><div><div class="eyebrow">03 / WHAT I CAN DO</div><h2 id="services-title">Mari ciptakan<br><span class="serif lime">sesuatu yang berarti.</span></h2></div><p>Dari konsep hingga eksekusi.<br>Saya siap menjadi bagian dari cerita Anda.</p></div>
        <div class="services-grid">
            @foreach(config('portfolio.services') as $service)
                <article class="service-card"><div class="service-top"><x-icon :name="$service['icon']" size="29" /><span>{{ $service['number'] }}</span></div><h3>{{ $service['name'] }}</h3><p>{{ $service['description'] }}</p><div class="service-tags">@foreach($service['tags'] as $tag)<span>{{ $tag }}</span>@endforeach</div><a href="#kontak" data-service="{{ $service['name'] }}" aria-label="Diskusikan proyek {{ $service['name'] }}"><x-icon size="22" /></a></article>
            @endforeach
        </div>
        <div class="toolbox"><span>MY EVERYDAY TOOLBOX</span><div><span>Lightroom</span><span>Premiere Pro</span><span>Figma</span><span class="tool-laravel">Laravel</span><span>VS Code</span><span>Laragon</span></div></div>
    </div>
</section>

<section class="contact-section light-section section-pad" id="kontak" aria-labelledby="contact-title">
    <div class="container contact-grid">
        <div class="contact-copy"><div class="eyebrow dark-muted">04 / LET'S MAKE IT HAPPEN</div><h2 id="contact-title">Punya ide?<br><span class="serif">Mari wujudkan.</span><span class="contact-star" aria-hidden="true">✳</span></h2><p>Sebuah cerita yang ingin diabadikan?<br>Brand yang ingin tumbuh? Atau website baru?<br>Saya ingin mendengarnya.</p>
            @if(config('portfolio.email'))<a class="contact-email" href="mailto:{{ config('portfolio.email') }}">{{ config('portfolio.email') }} <x-icon size="21" /></a>@endif
            @if(config('portfolio.whatsapp'))<a class="text-link" href="https://wa.me/{{ preg_replace('/\D/', '', config('portfolio.whatsapp')) }}" target="_blank" rel="noopener noreferrer">Ngobrol lewat WhatsApp <x-icon size="17" /></a>@endif
            <div class="social-links">@if(config('portfolio.instagram'))<a href="{{ config('portfolio.instagram') }}" target="_blank" rel="noopener noreferrer">Instagram ↗</a>@endif @if(config('portfolio.github'))<a href="{{ config('portfolio.github') }}" target="_blank" rel="noopener noreferrer">GitHub ↗</a>@endif</div>
            <div class="contact-signature">Good things start with a conversation.</div>
        </div>
        <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
            @csrf
            @if(session('contact_success'))<div class="form-success" role="status" data-contact-result><x-icon name="check" /><span>{{ session('contact_success') }}</span></div>@endif
            @if($errors->contact->any())<div class="form-error-summary" role="alert" data-contact-result>Pesan belum terkirim. Periksa isian di bawah ini.</div>@endif
            <div class="form-row"><div class="field"><label for="name">Nama Anda <span>*</span></label><input id="name" name="name" type="text" placeholder="Siapa nama Anda?" value="{{ old('name') }}" autocomplete="name" maxlength="100" required @error('name', 'contact') aria-invalid="true" aria-describedby="name-error" @enderror>@error('name', 'contact')<span class="field-error" id="name-error">{{ $message }}</span>@enderror</div><div class="field"><label for="email">Email <span>*</span></label><input id="email" name="email" type="email" placeholder="halo@email.com" value="{{ old('email') }}" autocomplete="email" maxlength="254" required @error('email', 'contact') aria-invalid="true" aria-describedby="email-error" @enderror>@error('email', 'contact')<span class="field-error" id="email-error">{{ $message }}</span>@enderror</div></div>
            <div class="field"><label for="service">Apa yang ingin Anda buat? <span>*</span></label><select id="service" name="service" required @error('service', 'contact') aria-invalid="true" aria-describedby="service-error" @enderror><option value="" disabled @selected(!old('service'))>Pilih jenis proyek</option>@foreach(['Fotografi', 'Film & video', 'Konten kreatif', 'Web development', 'Kolaborasi lainnya'] as $service)<option @selected(old('service') === $service)>{{ $service }}</option>@endforeach</select>@error('service', 'contact')<span class="field-error" id="service-error">{{ $message }}</span>@enderror</div>
            <div class="field"><label for="message">Ceritakan ide Anda <span>*</span></label><textarea id="message" name="message" rows="4" placeholder="Tentang proyek, kebutuhan, atau sekadar menyapa…" minlength="10" maxlength="5000" required @error('message', 'contact') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>@error('message', 'contact')<span class="field-error" id="message-error">{{ $message }}</span>@enderror</div>
            <div class="honeypot" aria-hidden="true"><label for="website">Kosongkan kolom ini</label><input id="website" name="website" tabindex="-1" autocomplete="off"></div>
            <div class="form-bottom"><span>Data Anda hanya digunakan<br>untuk kebutuhan komunikasi proyek.</span><button class="button button-dark" type="submit">Kirim pesan <x-icon size="18" /></button></div>
        </form>
    </div>
</section>
@endsection
