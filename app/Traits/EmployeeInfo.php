<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait EmployeeInfo
{
    public function getCurrentMEmployee()
    {
        return Auth::user();
    }

    public function getCurrentEmployeeId()
    {
        return $this->getCurrentMEmployee()?->id;
    }
}
