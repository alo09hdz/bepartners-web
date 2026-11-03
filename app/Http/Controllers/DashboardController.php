<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'active' => Project::where('status', 'en_progreso')->count(),
            'pending' => Activity::where('status', '!=', 'completada')->count(),
            'overdue' => Activity::overdue()->count(),
        ];

        $projects = Project::withAvg('activities', 'progress')->latest()->take(5)->get();
        $overdue = Activity::overdue()->with(['project', 'assignee'])->orderBy('due_date')->take(6)->get();

        return view('dashboard', compact('stats', 'projects', 'overdue'));
    }
}