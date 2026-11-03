<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    protected $guarded = [];

    protected $casts = ['changes' => 'array'];

    public function user() { return $this->belongsTo(User::class); }
}