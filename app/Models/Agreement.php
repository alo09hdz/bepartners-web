<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $guarded = [];

    protected $casts = ['agreement_date' => 'date'];

    public function project() { return $this->belongsTo(Project::class); }
    public function activity() { return $this->belongsTo(Activity::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}