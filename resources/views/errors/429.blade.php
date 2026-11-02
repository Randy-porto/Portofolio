@extends('layouts.app')
@section('title', 'Tunggu sebentar — '.config('portfolio.name'))
@section('content')
<section class="container error-page"><div class="eyebrow">ONE MOMENT, PLEASE</div><h1>Mari beri<br><span class="serif lime">sedikit jeda.</span></h1><p>Terlalu banyak pesan dalam waktu singkat. Tunggu satu menit sebelum mencoba kembali.</p><a class="button button-lime" href="{{ route('home') }}#kontak">Kembali ke formulir <x-icon /></a></section>
@endsection
