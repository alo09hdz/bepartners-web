@props(['status'])

@php
    $styles = [
        'planeado'    => 'bg-slate-100 text-slate-600',
        'pendiente'   => 'bg-slate-100 text-slate-600',
        'en_progreso' => 'bg-blue-50 text-brand',
        'en_pausa'    => 'bg-amber-50 text-amber-700',
        'completado'  => 'bg-green-50 text-green-700',
        'completada'  => 'bg-green-50 text-green-700',
    ];
    $label = ucfirst(str_replace('_', ' ', $status));
@endphp

<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $styles[$status] ?? 'bg-slate-100 text-slate-600' }}">
    {{ $label }}
</span>