<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(PayslipDetail::class);
    }
}
