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
    <div class="container detail-image-wrap detail-visual-wrap {{ $project['category'] === 'film' ? 'detail-visual-wrap--portrait' : '' }}" id="visual">
        <div class="detail-visual" data-format="{{ $project['category'] === 'film' ? 'portrait' : 'square' }}"><x-project-visual :project="$project" :visual="$selectedVisual" loading="eager" /></div>
        <span class="detail-image-note">{{ $project['demo'] ? 'CONCEPT STUDY' : 'SELECTED WORK' }} / {{ config('portfolio.name') }}</span>
    </div>
    @if(!empty($project['visuals']))
        <nav class="container detail-visual-picker" aria-label="Pilih gambar {{ $project['subtitle'] }}">
            @foreach($project['visuals'] as $visual)
                <a href="{{ route('projects.show', ['slug' => $project['slug'], 'gambar' => $loop->iteration]) }}#visual" @if($selectedVisualIndex === $loop->index) aria-current="true" @endif>
                    <span class="detail-visual-thumb"><x-project-visual :project="$project" :visual="$visual" /></span>
                    <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ $visual['caption'] }}</span>
                </a>
            @endforeach
        </nav>
        <p class="container detail-visual-caption" aria-live="polite">{{ str_pad($selectedVisualIndex + 1, 2, '0', STR_PAD_LEFT) }} / {{ $selectedVisual['caption'] }}</p>
    @endif
    <div class="project-story light-section section-pad">
        <div class="container story-grid"><div><div class="eyebrow dark-muted">THE STORY BEHIND</div><h2>Lebih dari<br><span class="serif">sebuah visual.</span></h2></div><div><p class="story-intro">{{ $project['description'] }}</p><h3>Pendekatan kreatif</h3><p>{{ $project['approach'] }}</p><h3>{{ $project['demo'] ? 'Ruang lingkup konsep' : 'Ruang lingkup proyek' }}</h3><ul class="deliverables">@foreach($project['deliverables'] as $deliverable)<li><x-icon name="check" size="18" />{{ $deliverable }}</li>@endforeach</ul>@if($project['demo'])<div class="detail-demo-note"><strong>Tentang karya ini</strong><p>Ini adalah konsep demo untuk menunjukkan arah visual portofolio. Visual dibuat dengan AI sebagai ilustrasi demo, bukan dokumentasi proyek atau klien nyata. @if($project['category'] === 'film')Video aftermovie asli belum ditambahkan.@endif</p></div>@endif</div></div>
    </div>
    <div class="container next-project"><div class="eyebrow">EXPLORE ANOTHER STORY</div><a href="{{ route('projects.show', $nextProject['slug']) }}"><span>{{ $nextProject['subtitle'] }}</span><x-icon size="45" /></a><div class="next-project-bottom"><span>KARYA BERIKUTNYA</span><a class="text-link" href="{{ route('home') }}#kontak">Punya ide serupa? Mari ngobrol ↗</a></div></div>
</article>
@endsection
