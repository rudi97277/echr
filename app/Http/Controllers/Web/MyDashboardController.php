<?php

namespace App\Http\Controllers\Web;

use App\DTOs\AttendanceDTO;
use App\Enums\RoleRouteEnum;
use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\EmployeeForm;
use App\Services\AttendanceService;
use App\Services\SalaryService;
use App\Traits\EmployeeInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyDashboardController extends Controller
{
    use EmployeeInfo;

    public function __construct(
        public AttendanceService $attendanceService,
        public SalaryService $salaryService
    ) {
    }

    public function page()
    {
        Carbon::setLocale('id');
        $today = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
        list(
            $thisWeekAttendances,
            $todayAttendance
        ) = $this->attendanceService->getThisWeekAttendance();

        $unpaidAttendance = $this->attendanceService->getUnpaidAttendance();
        $employee = $this->getCurrentMEmployee();

        $form = EmployeeForm::where([
            'employee_id' => $employee->id,
            'is_paid' => 0
        ])
            ->selectRaw('COUNT(*) as total,SUM(amount) as amount')
            ->first();

        $salary = $this->salaryService->getSalary();
        $totalSalary = $salary->total + $form->amount;
        $todaySalary = $todayAttendance ? $totalSalary / 26 : 0;
        $unpaidSalary = (($unpaidAttendance->total * $totalSalary) / 26) - $unpaidAttendance->deduction;

        $todayPenalty = $todayAttendance?->attendancePenalty;

        $role = AppHelper::haveRole($employee->role);

        return view('layouts.worker.my-dashboard', [
            'today' => $today,
            'todayAttendance' => $todayAttendance,
            'thisWeekAttendances' => $thisWeekAttendances,
            'todayPenalty' => $todayPenalty,
            'disabled' => $todayAttendance?->in_at && $todayAttendance?->out_at,
            'todaySalary' => $todaySalary,
            'unpaidAttendance' => $unpaidAttendance,
            'unpaidSalary' => $unpaidSalary,
            'role' => $role,
            'form' => $form,
            'employeeRole' => $employee->role
        ]);
    }


    public function attendance(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'image' => 'required|string'
        ]);

        $dto = new AttendanceDTO(...$request->only('lat', 'long', 'image'));
        $this->attendanceService->storeAttendance($dto);
        return redirect()->back();
    }
}
