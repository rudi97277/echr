<?php

namespace App\Services;

use App\Models\EmployeeSalary;
use App\Traits\EmployeeInfo;

class SalaryService
{
    use EmployeeInfo;
    public function getSalary()
    {
        $employeeId = $this->getCurrentEmployeeId();
        return EmployeeSalary::selectRaw("SUM(amount) as total")
            ->where('employee_id', $employeeId)
            ->first();
    }
}
