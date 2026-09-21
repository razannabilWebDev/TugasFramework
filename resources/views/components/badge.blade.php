@props(['status'])

@php
    // Logika pemilihan warna menggunakan if-elseif
    $colorClass = '';
    
    if ($status === 'Aman') {
        $colorClass = 'bg-green-100 text-green-800 border-green-200';
    } elseif ($status === 'Menipis') {
        $colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
    } elseif ($status === 'Habis') {
        $colorClass = 'bg-red-100 text-red-800 border-red-200';
    } else {
        $colorClass = 'bg-gray-100 text-gray-800 border-gray-200'; // Default / Fallback
    }
@endphp

<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
    {{ $status }}
</span>