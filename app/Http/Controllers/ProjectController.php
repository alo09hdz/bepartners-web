<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::query()
            ->withCount('activities')
            ->withAvg('activities', 'progress')
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::where('active', true)->orderBy('name')->get();
        return view('projects.create', compact('users'));
    }

    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->safe()->except('members') + [
            'created_by' => $request->user()->id,
        ]);

        $project->members()->sync($request->input('members', []));

        return redirect()->route('projects.show', $project)
            ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Project $project)
    {
        $project->load(['members', 'creator', 'agreements', 'activities.assignee']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::where('active', true)->orderBy('name')->get();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->safe()->except('members'));
        $project->members()->sync($request->input('members', []));

        return redirect()->route('projects.show', $project)
            ->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Request $request, Project $project)
    {
        abort_unless($request->user()->isAdmin(), 403, 'Solo el administrador puede eliminar proyectos.');

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto eliminado.');
    }
}