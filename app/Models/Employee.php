<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $guarded = ['id'];
    protected $hidden = ['password'];

    public function shift()
    {
        return $this->hasOne(Shift::class);
    }
}
