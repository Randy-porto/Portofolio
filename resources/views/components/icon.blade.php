@props(['name' => 'arrow', 'size' => 20])
<svg {{ $attributes }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('arrow')<path d="M5 19 19 5M5 5h14v14"/>@break
        @case('right')<path d="M4 12h16m-6-6 6 6-6 6"/>@break
        @case('down')<path d="M12 4v16m-6-6 6 6 6-6"/>@break
        @case('camera')<path d="M4 7h4l2-3h4l2 3h4v13H4z"/><circle cx="12" cy="13" r="4"/>@break
        @case('film')<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 4v16M17 4v16M3 9h4m-4 6h4m10-6h4m-4 6h4"/>@break
        @case('code')<path d="m8 7-5 5 5 5m8-10 5 5-5 5m-3-14-2 18"/>@break
        @case('spark')<path d="m12 3 2.5 6.5L21 12l-6.5 2.5L12 21l-2.5-6.5L3 12l6.5-2.5z"/>@break
        @case('mail')<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 6 9 7 9-7"/>@break
        @case('check')<path d="m5 12 4 4L19 6"/>@break
        @case('menu')<path d="M4 8h16M4 16h16"/>@break
        @case('close')<path d="m6 6 12 12M6 18 18 6"/>@break
        @case('globe')<circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/>@break
        @case('sun')<circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2M5 5l1 1m12 12 1 1M5 19l1-1M18 6l1-1"/>@break
    @endswitch
</svg>
