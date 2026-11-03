@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    {{-- Tarjetas de resumen --}}
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @php
            $cards = [
                ['Proyectos totales', $stats['projects'], 'text-brand-dark'],
                ['En progreso', $stats['active'], 'text-brand'],
                ['Actividades pendientes', $stats['pending'], 'text-brand-purple'],
                ['Atrasadas', $stats['overdue'], 'text-red-600'],
            ];
        @endphp
        @foreach ($cards as [$label, $value, $color])
            <div class="card">
                <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                <p class="mt-2 text-4xl font-bold {{ $color }}">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        {{-- Avance de proyectos --}}
        <div class="card">
            <h2 class="mb-5 text-lg font-bold text-brand-dark">Avance de proyectos</h2>
            @forelse ($projects as $project)
                @php $pct = (int) round($project->activities_avg_progress ?? 0); @endphp
                <div class="mb-5 last:mb-0">
                    <div class="mb-1.5 flex justify-between text-sm">
                        <span class="font-medium">{{ $project->name }}</span>
                        <span class="font-semibold text-brand">{{ $pct }}%</span>
                    </div>
                    <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full" style="width: {{ $pct }}%; background-image: linear-gradient(90deg,#1573F7,#5F3AD7)"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Aún no hay proyectos registrados.</p>
            @endforelse
        </div>

        {{-- Atrasadas --}}
        <div class="card">
            <h2 class="mb-5 text-lg font-bold text-brand-dark">Actividades atrasadas</h2>
            @forelse ($overdue as $activity)
                <div class="flex items-center justify-between border-b border-slate-100 py-3 last:border-0">
                    <div>
                        <p class="text-sm font-semibold">{{ $activity->title }}</p>
                        <p class="text-xs text-slate-500">{{ $activity->project->name }} · {{ $activity->assignee?->name ?? 'Sin responsable' }}</p>
                    </div>
                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">
                        {{ $activity->due_date->format('d/m/Y') }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-slate-500">Todo al día, no hay actividades atrasadas. 🎉</p>
            @endforelse
        </div>
    </div>
@endsection