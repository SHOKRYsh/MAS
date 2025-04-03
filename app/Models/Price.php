<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'subject_id',
        'stage_id',
        'price',
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
