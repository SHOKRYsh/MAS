<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    protected $fillable = [
        'user_id',
        'subject_id',
        'month',
        'year',
        'status', // Paid or Pending
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'status' => 'boolean', // 1 = Paid, 0 = Pending
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
