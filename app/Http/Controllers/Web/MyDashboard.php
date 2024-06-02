<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\UploadService;
use App\Traits\MEmployeeInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyDashboard extends Controller
{
    use MEmployeeInfo;
    public function page()
    {
        $mEmloyeeId = $this->getCurrentMEmployeeId();
        $attendances = Attendance::where('m_employee_id', $mEmloyeeId)
            ->selectRaw("
                id,
                date,
                DATE_FORMAT(in_at,'%H:%i') as in_at, 
                DATE_FORMAT(out_at,'%H:%i') as out_at")
            ->orderBy('in_at', 'desc')
            ->whereRaw('WEEK(in_at) = WEEK(CURDATE())')->get();

        $attendance = $attendances->where('date', date('Y-m-d'))->first();
        Carbon::setLocale('id');
        $attendances = $attendances->map(function ($item) {
            $date = Carbon::parse($item->date);
            $formattedDate = $date->isoFormat('D MMMM YYYY');
            $item->date = $formattedDate;
            return $item;
        });

        $today = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
        return view('front.worker.my-dashboard', [
            'today' => $today,
            'attendances' => $attendances,
            'attendance' => $attendance,
            'disabled' => $attendance?->in_at && $attendance?->out_at
        ]);
    }


    public function attendance(Request $request, UploadService $uploadService)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'image' => 'required|string'
        ]);

        $path = $uploadService->uploadReturnPath($request->image, 'attendances');
        $mEmloyeeId = $this->getCurrentMEmployeeId();

        $attendance = Attendance::where('m_employee_id', $mEmloyeeId)->whereDate('date', now())->first();
        if (!$attendance) {
            Attendance::create([
                'm_employee_id' => $mEmloyeeId,
                'date' => now(),
                'in_at' => now(),
                'in_image' => $path,
                'in_lat' => $request->lat ?? 0,
                'in_long' => $request->long ?? 0
            ]);
        } else {
            $attendance->update([
                'out_at' => now(),
                'out_image' => $path,
                'out_lat' => $request->lat ?? 0,
                'out_long' => $request->long ?? 0
            ]);
        }

        return redirect()->back();
    }
}
