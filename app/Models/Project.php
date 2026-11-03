<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $guarded = [];

    public const STATUSES = [
        'planeado'    => 'Planeado',
        'en_progreso' => 'En progreso',
        'en_pausa'    => 'En pausa',
        'completado'  => 'Completado',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function agreements(): HasMany
    {
        return $this->hasMany(Agreement::class);
    }

    public function getProgressAttribute(): int
    {
        return (int) round($this->activities()->avg('progress') ?? 0);
    }
}