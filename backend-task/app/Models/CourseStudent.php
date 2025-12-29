<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentStatus;

class CourseStudent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => PaymentStatus::class
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function student() {
        return $this->belongsTo(User::class, 'user_id', );
    }
}
