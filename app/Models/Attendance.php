<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = ['id'];

    public function attendancePenalty()
    {
        return $this->hasOne(AttendancePenalty::class)->where('is_corrected', 0);
    }

    public function getInImageAttribute($value)
    {
        if ($value == null) return null;
        return config('app.url') . "/$value";
    }

    public function getOutImageAttribute($value)
    {
        if ($value == null) return null;
        return config('app.url') . "/$value";
    }
}
