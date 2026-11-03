<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];

    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function members() { return $this->belongsToMany(User::class); }
    public function activities() { return $this->hasMany(Activity::class); }
    public function agreements() { return $this->hasMany(Agreement::class); }

    // Avance general = promedio del progreso de sus actividades
    public function getProgressAttribute(): int
    {
        return (int) round($this->activities()->avg('progress') ?? 0);
    }
}