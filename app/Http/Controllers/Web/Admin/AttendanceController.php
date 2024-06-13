<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function page(Request $request, string $obfuscatedId)
    {
        $headers = [
            "Tanggal",
            "Jam Masuk",
            "Terlambat",
            "",
            "Jam Keluar",
            "",
        ];

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
            ->with('attendancePenalty:attendance_id,in_minutes,amount')
            ->orderBy('date', 'desc')
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.attendance', [
            'attendances' => AttendanceResource::collection($attendances),
            'pagination' => AppHelper::paginationData($attendances),
            'headers' => $headers
        ]);
    }
}
