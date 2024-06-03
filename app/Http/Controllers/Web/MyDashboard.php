<?php

namespace App\Http\Controllers\Web;

use App\DTOs\AttendanceDTO;
use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use App\Services\SalaryService;
use App\Traits\EmployeeInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyDashboard extends Controller
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

        $salary = $this->salaryService->getSalary();
        $todaySalary = $todayAttendance ? $salary->total / 26 : 0;

        $todayPenalty = $todayAttendance?->attendancePenalty;


        return view('front.worker.my-dashboard', [
            'today' => $today,
            'todayAttendance' => $todayAttendance,
            'thisWeekAttendances' => $thisWeekAttendances,
            'todayPenalty' => $todayPenalty,
            'disabled' => $todayAttendance?->in_at && $todayAttendance?->out_at,
            'todaySalary' => $todaySalary
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
