<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\AttendancePenalty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class AttendanceController extends Controller
{
    public function page(Request $request, string $obfuscatedId)
    {
        $headers = [
            "Tanggal",
            "Jam Masuk",
            "Gambar",
            "Status",
            "Jam Keluar",
            "Gambar",
        ];

        $now = Carbon::now();
        $month = $request->month ?? $now->format('m');
        $year = $request->year ?? $now->year;

        $employee_id = AppHelper::unObfuscate($obfuscatedId);
        $attendances = Attendance::where('employee_id', $employee_id)
            ->selectRaw(
                "id,
                date,
            DATE_FORMAT(in_at,'%H:%i') as in_at,
            in_image,
            DATE_FORMAT(out_at,'%H:%i') as out_at,
            out_image"
            )
            ->with('attendancePenalty:attendance_id,in_minutes,amount,is_corrected')
            ->orderBy('date', 'desc')
            ->whereRaw("DATE_FORMAT(date,'%m%Y') = '$month$year'")
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.attendance', [
            'attendances' => AttendanceResource::collection($attendances->items()),
            'pagination' => AppHelper::paginationData($attendances),
            'headers' => $headers,
            'sMonth' => $month,
            'sYear' => $year,
        ]);
    }

    public function corection(Request $request, string $obfuscatedId)
    {
        $attendanceId = AppHelper::unObfuscate($obfuscatedId);

        AttendancePenalty::where('attendance_id', $attendanceId)->update(['is_corrected' => 1]);

        return redirect()->back()->with(['success' => 'Penalti absensi berhasil di koreksi!']);
    }
}
