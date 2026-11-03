@extends('layouts.app')

@section('title', $project->name)
@section('heading', $project->name)

@section('content')
    @php $pct = $project->progress; @endphp

    <div class="grid gap-6 xl:grid-cols-3">
        {{-- Información principal --}}
        <div class="card xl:col-span-2">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <x-status-badge :status="$project->status" />
                    <p class="mt-4 max-w-2xl text-sm leading-relaxed text-slate-600">
                        {{ $project->description ?: 'Sin descripción.' }}
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('projects.edit', $project) }}" class="btn-primary">Editar</a>
                    <a href="{{ route('projects.index') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Volver</a>
                </div>
            </div>

            <div class="mt-8">
                <div class="mb-2 flex justify-between text-sm">
                    <span class="font-medium text-slate-600">Avance general</span>
                    <span class="font-bold text-brand">{{ $pct }}%</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full" style="width: {{ $pct }}%; background-image: linear-gradient(90deg,#1573F7,#5F3AD7)"></div>
                </div>
            </div>

            <dl class="mt-8 grid gap-6 border-t border-slate-100 pt-6 sm:grid-cols-3">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Inicio</dt>
                    <dd class="mt-1 text-sm font-medium">{{ $project->start_date?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Fin</dt>
                    <dd class="mt-1 text-sm font-medium">{{ $project->end_date?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Creado por</dt>
                    <dd class="mt-1 text-sm font-medium">{{ $project->creator?->name ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Integrantes --}}
        <div class="card">
            <h2 class="mb-4 text-lg font-bold text-brand-dark">Integrantes</h2>
            @forelse ($project->members as $member)
                <div class="flex items-center gap-3 border-b border-slate-100 py-3 last:border-0">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold text-white"
                         style="background-image: linear-gradient(135deg,#1573F7,#5F3AD7)">
                        {{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ $member->name }}</p>
                        <p class="text-xs capitalize text-slate-500">{{ $member->role }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Sin integrantes asignados.</p>
            @endforelse
        </div>
    </div>

    {{-- Actividades --}}
    <div class="card mt-6">
        <h2 class="mb-4 text-lg font-bold text-brand-dark">Actividades ({{ $project->activities->count() }})</h2>
        @forelse ($project->activities as $activity)
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 py-3 last:border-0">
                <div>
                    <p class="text-sm font-semibold">{{ $activity->title }}</p>
                    <p class="text-xs text-slate-500">
                        {{ $activity->assignee?->name ?? 'Sin responsable' }}
                        · Compromiso: {{ $activity->due_date?->format('d/m/Y') ?? 'sin fecha' }}
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs font-semibold text-slate-600">{{ $activity->progress }}%</span>
                    <x-status-badge :status="$activity->status" />
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500">Este proyecto aún no tiene actividades.</p>
        @endforelse
    </div>

    {{-- Acuerdos --}}
    <div class="card mt-6">
        <h2 class="mb-4 text-lg font-bold text-brand-dark">Acuerdos ({{ $project->agreements->count() }})</h2>
        @forelse ($project->agreements as $agreement)
            <div class="border-b border-slate-100 py-3 last:border-0">
                <p class="text-sm">{{ $agreement->description }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $agreement->agreement_date->format('d/m/Y') }}</p>
            </div>
        @empty
            <p class="text-sm text-slate-500">Aún no hay acuerdos registrados.</p>
        @endforelse
    </div>
@endsection