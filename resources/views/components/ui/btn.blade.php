@props([
    'variant' => 'primary', // primary, secondary, ghost
    'size' => 'md', // md, sm, xs
    'href' => null,
    'type' => 'button',
])
@php
    $base = 'btn';
    $v = match($variant) {
        'secondary' => 'btn-secondary',
        'ghost' => 'btn-ghost',
        default => 'btn-primary',
    };
    $s = match($size) {
        'sm' => 'btn-sm',
        'xs' => 'btn-xs',
        default => '',
    };
    $classes = trim("$base $v $s ".($attributes->get('class')));
@endphp
@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
@endif
