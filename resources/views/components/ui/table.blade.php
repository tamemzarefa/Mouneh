@props([
    'headers' => [], // array of ['label' => '...', 'class' => 'optional']
    'zebra' => true,
    'sticky' => false,
])
@php
    $tableClass = 'table'.($zebra ? ' table-zebra' : '');
@endphp
<div {{ $attributes->merge(['class' => 'overflow-x-auto theme-surface rounded-box shadow']) }}>
    <table class="{{ $tableClass }}">
        @if(!empty($headers))
        <thead class="{{ $sticky ? 'sticky top-0 z-10' : '' }}">
            <tr>
                @foreach($headers as $th)
                    <th class="{{ is_array($th) ? ($th['class'] ?? '') : '' }}">{{ is_array($th) ? ($th['label'] ?? '') : $th }}</th>
                @endforeach
            </tr>
        </thead>
        @endif
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
