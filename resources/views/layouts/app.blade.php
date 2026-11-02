<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#151613">
    <title>@yield('title', config('portfolio.name').' — Creative & Code')</title>
    <meta name="description" content="@yield('description', 'Portofolio '.config('portfolio.name').': fotografi wisuda, aftermovie, konten kreatif, dan web development dengan Laravel.')">
    <meta property="og:title" content="@yield('title', config('portfolio.name').' — Creative & Code')">
    <meta property="og:description" content="Visual yang berkesan. Pengalaman digital yang berarti. Jelajahi portofolio kreatif dan development.">
    <meta property="og:type" content="website">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preload" href="{{ asset('fonts/PlusJakartaSans.ttf') }}" as="font" type="font/ttf" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
    <script src="{{ asset('js/portfolio.js') }}" defer></script>
    <script src="{{ asset('js/gallery.js') }}" defer></script>
</head>
<body>
    <a class="skip-link" href="#main">Langsung ke konten</a>
    <header class="site-header">
        <div class="container header-inner">
            <a class="wordmark" href="{{ route('home') }}" aria-label="{{ config('portfolio.name') }} — Beranda">{{ strtolower(config('portfolio.name')) }}<span>®</span><span class="wordmark-dot">.</span></a>
            <nav class="desktop-nav" aria-label="Navigasi utama">
                <a href="{{ route('home') }}#karya" data-nav="karya">Karya<span class="nav-count">{{ str_pad(count(config('portfolio.projects')), 2, '0', STR_PAD_LEFT) }}</span></a>
                <a href="{{ route('home') }}#tentang" data-nav="tentang">Tentang</a>
                <a href="{{ route('home') }}#layanan" data-nav="layanan">Layanan</a>
            </nav>
            <a class="header-cta" href="{{ route('home') }}#kontak">Mari berkolaborasi <x-icon size="16" /></a>
            <button class="menu-toggle" type="button" aria-controls="mobile-nav" aria-expanded="false" aria-label="Buka navigasi"><x-icon name="menu" size="24" /></button>
        </div>
        <nav id="mobile-nav" class="mobile-nav" aria-label="Navigasi seluler" hidden>
            <a href="{{ route('home') }}#karya">Karya</a>
            <a href="{{ route('home') }}#tentang">Tentang</a>
            <a href="{{ route('home') }}#layanan">Layanan</a>
            <a href="{{ route('home') }}#kontak">Mari berkolaborasi ↗</a>
        </nav>
    </header>
    <main id="main">@yield('content')</main>
    <footer class="site-footer">
        <div class="container footer-top">
            <a class="wordmark" href="{{ route('home') }}">{{ strtolower(config('portfolio.name')) }}<span>®</span><span class="wordmark-dot">.</span></a>
            <p>Different disciplines. One creative mind.</p>
            <a class="back-top" href="#main">Kembali ke atas <x-icon size="16" /></a>
        </div>
        <div class="container footer-bottom">
            <span>© {{ date('Y') }} {{ config('portfolio.name') }}. Dibuat dengan rasa.</span>
            <span>Creative vision. Thoughtful code. <span class="tiny-star">✳</span></span>
        </div>
    </footer>
</body>
</html>
