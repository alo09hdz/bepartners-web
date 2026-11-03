<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $admin  = User::where('email', 'admin@bepartners.mx')->first();
        $lider  = User::where('email', 'lider@bepartners.mx')->first();
        $member = User::where('email', 'integrante@bepartners.mx')->first();

        $data = [
            [
                'name' => 'App móvil BEPARTNERS',
                'description' => 'Aplicación móvil para el seguimiento de actividades y acuerdos del equipo.',
                'status' => 'en_progreso',
                'start' => -30, 'end' => 45,
                'activities' => [
                    ['Diseño de pantallas', 'completada', 100, -10],
                    ['Módulo de inicio de sesión', 'en_progreso', 60, -2],
                    ['Sincronización de datos', 'pendiente', 0, 15],
                ],
            ],
            [
                'name' => 'Panel web de administración',
                'description' => 'Plataforma web para supervisar proyectos, generar reportes y gestionar usuarios.',
                'status' => 'en_progreso',
                'start' => -10, 'end' => 60,
                'activities' => [
                    ['Base de datos y modelos', 'completada', 100, -5],
                    ['CRUD de proyectos', 'en_progreso', 40, 7],
                    ['Reportes en PDF', 'pendiente', 0, 25],
                ],
            ],
            [
                'name' => 'Capacitación al equipo',
                'description' => 'Sesiones de capacitación sobre el uso de la plataforma.',
                'status' => 'planeado',
                'start' => 20, 'end' => 50,
                'activities' => [],
            ],
        ];

        foreach ($data as $item) {
            $project = Project::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'status' => $item['status'],
                'start_date' => now()->addDays($item['start']),
                'end_date' => now()->addDays($item['end']),
                'created_by' => $admin->id,
            ]);

            $project->members()->sync([$lider->id, $member->id]);

            foreach ($item['activities'] as [$title, $status, $progress, $due]) {
                Activity::create([
                    'project_id' => $project->id,
                    'title' => $title,
                    'status' => $status,
                    'progress' => $progress,
                    'assigned_to' => $member->id,
                    'due_date' => now()->addDays($due),
                ]);
            }
        }
    }
}