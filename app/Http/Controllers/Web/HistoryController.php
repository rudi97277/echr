<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function __construct(
        public AttendanceService $attendanceService
    ) {
    }
    public function page(Request $request)
    {
        $start = $request->input('start_date', Carbon::now()->subDays(7)->format('d/m/Y'));
        $end = $request->input('end_date', date('d/m/Y'));

        $attendances = $this->attendanceService->getAttendanceByDateRange($start, $end);
        return view('front.worker.history', [
            'start' => $start,
            'end' => $end,
            'attendances' => $attendances
        ]);
    }
}
