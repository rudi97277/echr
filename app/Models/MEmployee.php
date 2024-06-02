<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MEmployee extends Authenticatable
{
    protected $guarded = ['id'];
    protected $hidden = ['password'];
}
