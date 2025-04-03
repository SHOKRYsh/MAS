<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Modules\Student\Database\Factories\SubjectFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
    ];

    public function students()
    {
        return $this->hasMany(User::class, 'subject_id');
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'subject_id');
    }

    public function payments()
    {
        return $this->hasMany(UserPayment::class, 'subject_id');
    }
}
