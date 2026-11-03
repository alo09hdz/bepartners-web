@php
    $p = $project ?? null;
    $selected = old('members', $p ? $p->members->pluck('id')->all() : []);
@endphp

<div class="card space-y-6">
    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Nombre del proyecto *</label>
        <input type="text" name="name" value="{{ old('name', $p?->name) }}" class="input" placeholder="Ej. App móvil BEPARTNERS">
        @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Descripción</label>
        <textarea name="description" rows="4" class="input" placeholder="Describe el objetivo del proyecto">{{ old('description', $p?->description) }}</textarea>
        @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-6 sm:grid-cols-3">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Fecha de inicio</label>
            <input type="date" name="start_date" value="{{ old('start_date', $p?->start_date?->format('Y-m-d')) }}" class="input">
            @error('start_date') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Fecha de fin</label>
            <input type="date" name="end_date" value="{{ old('end_date', $p?->end_date?->format('Y-m-d')) }}" class="input">
            @error('end_date') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Estado *</label>
            <select name="status" class="input">
                @foreach (\App\Models\Project::STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected(old('status', $p?->status ?? 'planeado') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            @error('status') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Integrantes del proyecto</label>
        <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($users as $user)
                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm transition hover:border-brand/40 hover:bg-slate-50">
                    <input type="checkbox" name="members[]" value="{{ $user->id }}" @checked(in_array($user->id, $selected))
                           class="rounded border-slate-300 text-brand focus:ring-brand">
                    <span>
                        <span class="block font-medium text-brand-dark">{{ $user->name }}</span>
                        <span class="block text-xs capitalize text-slate-500">{{ $user->role }}</span>
                    </span>
                </label>
            @endforeach
        </div>
        @error('members') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
        <a href="{{ route('projects.index') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Cancelar</a>
        <button type="submit" class="btn-primary">{{ $p ? 'Guardar cambios' : 'Crear proyecto' }}</button>
    </div>
</div>