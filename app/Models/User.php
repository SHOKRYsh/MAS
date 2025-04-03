<?php

namespace App\Models;

use App\Http\Traits\ArchiveTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;
    use HasApiTokens,ArchiveTrait;


    protected $fillable = [
        'name',
        'parent_phone',
        'stage_id',
        'grade_id',
        'subject_id',
        'year',
    ];

    protected $casts = [
        'year' => 'string',
    ];

    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function payments()
    {
        return $this->hasMany(UserPayment::class, 'user_id');
    }

    public function hasPaidForCourse($subjectId, $month, $year)
    {
        return $this->payments()
            ->where('subject_id', $subjectId)
            ->where('month', $month)
            ->where('year', $year)
            ->where('status', 1)
            ->exists();
    }
    public function rating()
    {
        return $this->hasOne(Rate::class, 'user_id');
    }
}
