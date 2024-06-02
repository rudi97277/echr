<?php

namespace App\Http\Controllers\Web;

use App\DTOs\AttendanceDTO;
use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use App\Traits\MEmployeeInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyDashboard extends Controller
{
    use MEmployeeInfo;

    public function __construct(public AttendanceService $attendanceService)
    {
    }

    public function page()
    {
        Carbon::setLocale('id');
        $today = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
        list($thisWeekAttendances, $todayAttendance) = $this->attendanceService->getThisWeekAttendance();
        $todayPenalty = $todayAttendance?->attendancePenalty;
        return view('front.worker.my-dashboard', [
            'today' => $today,
            'todayAttendance' => $todayAttendance,
            'thisWeekAttendances' => $thisWeekAttendances,
            'todayPenalty' => $todayPenalty,
            'disabled' => $todayAttendance?->in_at && $todayAttendance?->out_at
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
