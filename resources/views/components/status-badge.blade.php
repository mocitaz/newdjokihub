@props(['status', 'size' => 'sm'])

@php
    $colors = [
        'available' => 'bg-blue-100 text-blue-800 border-blue-200',
        'in_progress' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'completed' => 'bg-green-100 text-green-800 border-green-200',
        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
        'pending' => 'bg-gray-100 text-gray-800 border-gray-200',
    ];

    $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
    
    $sizes = [
        'xs' => 'px-2 py-0.5 text-[10px]',
        'sm' => 'px-2.5 py-0.5 text-xs',
        'md' => 'px-3 py-1 text-sm',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['sm'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center font-bold uppercase tracking-wide rounded-full border $colorClass $sizeClass"]) }}>
    {{ str_replace('_', ' ', $status) }}
</span>
