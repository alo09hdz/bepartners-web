<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $casts = ['due_date' => 'date'];

    public function project() { return $this->belongsTo(Project::class); }
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function agreements() { return $this->hasMany(Agreement::class); }

    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'completada')
                     ->whereNotNull('due_date')
                     ->whereDate('due_date', '<', now());
    }
}