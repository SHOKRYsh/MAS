<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'stage_id');
    }
    public function grades()
    {
        return $this->hasMany(Grade::class, 'stage_id');
    }
    public function prices()
{
    return $this->hasMany(Price::class, 'stage_id');
}
}
