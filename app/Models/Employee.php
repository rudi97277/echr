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

    public function salaries()
    {
        return $this->hasMany(EmployeeSalary::class);
    }

    public function forms()
    {
        return $this->hasMany(EmployeeForm::class);
    }
}
