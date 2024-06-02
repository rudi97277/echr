<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait MEmployeeInfo
{
    public function getCurrentMEmployee()
    {
        return Auth::user();
    }

    public function getCurrentMEmployeeId()
    {
        return $this->getCurrentMEmployee()?->id;
    }
}
