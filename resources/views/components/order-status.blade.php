@props(['order'])

@php
    $colors = [
        'pendente'   => 'bg-yellow-100 text-yellow-700 border-yellow-200',
        'confirmado' => 'bg-blue-100 text-blue-700 border-blue-200',
        'em_preparo' => 'bg-orange-100 text-orange-700 border-orange-200',
        'enviado'    => 'bg-purple-100 text-purple-700 border-purple-200',
        'entregue'   => 'bg-green-100 text-green-700 border-green-200',
        'cancelado'  => 'bg-red-100 text-red-700 border-red-200',
    ];
    $class = $colors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
@endphp

<span {{ $attributes->merge(['class' => "inline-block text-xs font-semibold px-2.5 py-1 rounded-full border $class"]) }}>
    {{ $order->status_label }}
</span>
