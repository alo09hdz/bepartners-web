@extends('layouts.app')

@section('title', 'Proyectos')
@section('heading', 'Proyectos')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="flex flex-1 flex-col gap-3 sm:max-w-xl sm:flex-row">
            <input type="text" name="search" value="{{ request('search') }}" class="input" placeholder="Buscar proyecto...">
            <select name="status" class="input sm:w-52" onchange="this.form.submit()">
                <option value="">Todos los estados</option>
                @foreach (\App\Models\Project::STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('projects.create') }}" class="btn-primary">+ Nuevo proyecto</a>
    </div>

    <div class="card !p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50/70 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Proyecto</th>
                        <th class="px-6 py-4 font-semibold">Estado</th>
                        <th class="px-6 py-4 font-semibold">Fechas</th>
                        <th class="px-6 py-4 font-semibold">Avance</th>
                        <th class="px-6 py-4 font-semibold">Actividades</th>
                        <th class="px-6 py-4 text-right font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($projects as $project)
                        @php $pct = (int) round($project->activities_avg_progress ?? 0); @endphp
                        <tr class="transition hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <a href="{{ route('projects.show', $project) }}" class="font-semibold text-brand-dark hover:text-brand">{{ $project->name }}</a>
                            </td>
                            <td class="px-6 py-4"><x-status-badge :status="$project->status" /></td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $project->start_date?->format('d/m/Y') ?? '—' }} → {{ $project->end_date?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-2 w-24 overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full" style="width: {{ $pct }}%; background-image: linear-gradient(90deg,#1573F7,#5F3AD7)"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-600">{{ $pct }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $project->activities_count }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3 text-sm font-medium">
                                    <a href="{{ route('projects.show', $project) }}" class="text-brand hover:underline">Ver</a>
                                    <a href="{{ route('projects.edit', $project) }}" class="text-brand-purple hover:underline">Editar</a>
                                    @if (auth()->user()->isAdmin())
                                        <form method="POST" action="{{ route('projects.destroy', $project) }}"
                                              onsubmit="return confirm('¿Eliminar el proyecto «{{ $project->name }}»? Se borrarán también sus actividades y acuerdos.')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">No se encontraron proyectos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $projects->links() }}</div>
@endsection