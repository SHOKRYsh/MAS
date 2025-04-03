<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name', 'stage_id'];

    public function students()
    {
        return $this->hasMany(User::class);
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
