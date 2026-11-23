@props(['tipo' => 'success'])

@php
    $clases = $tipo == 'success'
        ? 'bg-green-100 text-green-800 border-green-300'
        : 'bg-red-100 text-red-800 border-red-300';
@endphp

<div class="{{ $clases }} border px-4 py-3 rounded-lg mb-4">
    {{ $slot }}
</div>