@props(['project', 'visual' => null, 'loading' => 'lazy'])
@php
    $image = $visual['image'] ?? $project['image'];
    $alt = $visual['alt'] ?? $project['alt'];
    $tile = $visual['tile'] ?? null;
@endphp
<span {{ $attributes->class(['project-visual', 'project-visual--atlas' => $tile !== null]) }}>
    @if($tile !== null)
        <img class="project-atlas atlas-tile-{{ $tile }}" src="{{ asset($image) }}" alt="{{ $alt }}" width="1536" height="1024" loading="{{ $loading }}">
    @else
        <img class="{{ str_ends_with($image, '.svg') ? 'illustration' : '' }}" src="{{ asset($image) }}" alt="{{ $alt }}" width="600" height="600" loading="{{ $loading }}">
    @endif
</span>
