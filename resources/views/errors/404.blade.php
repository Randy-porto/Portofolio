@extends('layouts.app')
@section('title', 'Karya belum ditemukan — '.config('portfolio.name'))
@section('content')
<section class="container error-page"><div class="eyebrow">404 / A LITTLE DETOUR</div><h1>Cerita ini<br><span class="serif lime">belum ada.</span></h1><p>Halaman yang Anda cari tidak ditemukan. Masih ada karya lain untuk dijelajahi.</p><a class="button button-lime" href="{{ route('home') }}#karya">Kembali ke karya <x-icon /></a></section>
@endsection
