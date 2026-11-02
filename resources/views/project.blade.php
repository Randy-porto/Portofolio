@extends('layouts.app')
@section('title', $project['subtitle'].' — '.config('portfolio.name'))
@section('description', $project['description'])

@section('content')
<article>
    <div class="container project-heading section-pad">
        <a class="project-back text-link" href="{{ route('home') }}#karya">← Kembali ke karya</a>
        <div class="eyebrow"><span class="status-dot"></span> {{ $project['label'] }} / {{ $project['year'] }}</div>
        <h1>{{ $project['subtitle'] }}<span class="lime">.</span></h1>
        <p class="project-lead serif">{{ $project['title'] }}</p>
        <div class="project-metadata"><div><span>PERAN</span><p>{{ $project['role'] }}</p></div><div><span>TOOLS & EXPERTISE</span><p>{{ implode(' · ', $project['tools']) }}</p></div><div><span>STATUS</span><p>{{ $project['demo'] ? 'Eksplorasi / konsep demo' : 'Proyek terpilih' }}</p></div></div>
    </div>
    <div class="container detail-image-wrap"><img class="detail-image {{ $project['category'] }}" src="{{ asset($project['image']) }}" alt="{{ $project['alt'] }}" width="1200" height="800"><span class="detail-image-note">{{ $project['demo'] ? 'CONCEPT STUDY' : 'SELECTED WORK' }} / {{ config('portfolio.name') }}</span></div>
    <div class="project-story light-section section-pad">
        <div class="container story-grid"><div><div class="eyebrow dark-muted">THE STORY BEHIND</div><h2>Lebih dari<br><span class="serif">sebuah visual.</span></h2></div><div><p class="story-intro">{{ $project['description'] }}</p><h3>Pendekatan kreatif</h3><p>{{ $project['approach'] }}</p><h3>{{ $project['demo'] ? 'Ruang lingkup konsep' : 'Ruang lingkup proyek' }}</h3><ul class="deliverables">@foreach($project['deliverables'] as $deliverable)<li><x-icon name="check" size="18" />{{ $deliverable }}</li>@endforeach</ul>@if($project['demo'])<div class="detail-demo-note"><strong>Tentang karya ini</strong><p>Ini adalah konsep demo untuk menunjukkan arah visual portofolio. Gambar merupakan ilustrasi dan bukan dokumentasi proyek atau klien nyata. @if($project['category'] === 'film')Video aftermovie asli belum ditambahkan.@endif</p></div>@endif</div></div>
    </div>
    <div class="container next-project"><div class="eyebrow">EXPLORE ANOTHER STORY</div><a href="{{ route('projects.show', $nextProject['slug']) }}"><span>{{ $nextProject['subtitle'] }}</span><x-icon size="45" /></a><div class="next-project-bottom"><span>KARYA BERIKUTNYA</span><a class="text-link" href="{{ route('home') }}#kontak">Punya ide serupa? Mari ngobrol ↗</a></div></div>
</article>
@endsection
