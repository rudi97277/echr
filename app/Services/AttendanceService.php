<?php

namespace App\Services;

use App\DTOs\AttendanceDTO;
use App\Models\Attendance;
use App\Models\AttendancePenalty;
use App\Models\Shift;
use App\Traits\EmployeeInfo;
use Carbon\Carbon;

class AttendanceService
{

    use EmployeeInfo;
    public function __construct(public UploadService $uploadService)
    {
    }

    public function getThisWeekAttendance()
    {
        $employeeId = $this->getCurrentEmployeeId();
        $thisWeekAttendances = Attendance::where('employee_id', $employeeId)
            ->selectRaw("
                id,
                date,
                DATE_FORMAT(in_at,'%H:%i') as in_at, 
                DATE_FORMAT(out_at,'%H:%i') as out_at
                ")
            ->orderBy('in_at', 'desc')
            ->with('attendancePenalty')
            ->whereRaw('WEEK(date) = WEEK(CURDATE())')->get();

        $todayAttendance = $thisWeekAttendances->where('date', date('Y-m-d'))->first();
        Carbon::setLocale('id');
        $thisWeekAttendances = $thisWeekAttendances->map(function ($attendance) {
            $date = Carbon::parse($attendance->date);
            $formattedDate = $date->isoFormat('D MMMM YYYY');
            $attendance->date = $formattedDate;
            return $attendance;
        });

        return array($thisWeekAttendances, $todayAttendance);
    }

    public function getUnpaidAttendance()
    {
        $employeeId = $this->getCurrentEmployeeId();

        $subPenalty = AttendancePenalty::where('is_corrected', 0);
        return Attendance::where([
            'employee_id' => $employeeId,
            'is_paid' => false
        ])
            ->leftJoinSub($subPenalty, 'sub_penalty', fn ($join) => $join->on('sub_penalty.attendance_id', 'attendances.id'))
            ->selectRaw("
                COUNT(*) as total, 
                IFNULL(SUM(sub_penalty.amount),0) as deduction,
                IFNULL(SUM(sub_penalty.in_minutes),0) as in_minutes
            ")
            ->first();
    }

    public function storeAttendance(AttendanceDTO $dto)
    {
        $path = $this->uploadService->uploadReturnPath($dto->image, 'attendances');
        $now = Carbon::now();
        $employee = $this->getCurrentMEmployee();
        $shift = Shift::where('id', $employee->shift_id)->first();

        $attendance = Attendance::where('employee_id', $employee->id)->whereDate('date', now())->first();
        if (!$attendance) {

            $clockIn = Carbon::parse("{$now->format('Y-m-d')} $shift->clock_in");

            $diffInMinutes = $clockIn->diffInMinutes($now, false);
            if ($diffInMinutes < -30)
                return redirect()->back()->withErrors(['
            attendance' => "Absensi terlalu cepat. Absensi dapat dimulai 30 menit sebelum {$clockIn->format('H:i')}!"]);
            $attendance = Attendance::create([
                'employee_id' => $employee->id,
                'date' => $now,
                'in_at' => $now,
                'in_image' => $path,
                'in_lat' => $dto->lat ?? 0,
                'in_long' => $dto->long ?? 0
            ]);

            if ($diffInMinutes > 0)
                $attendance->attendancePenalty()->create([
                    'in_minutes' => $diffInMinutes,
                    'amount' => $diffInMinutes * $shift->penalty_per_minutes,
                ]);
        } else {

            $clockOut = Carbon::parse("{$now->format('Y-m-d')} $shift->clock_out");
            $diffInMinutes = $clockOut->diffInMinutes($now, false);
            if ($diffInMinutes < 0)
                return redirect()->back()->withErrors(['
            attendance' => "Absensi terlau cepat. Absensi keluar setelah jam {$clockOut->format('H:i')}"]);

            $attendance->update([
                'out_at' => $now,
                'out_image' => $path,
                'out_lat' => $dto->lat ?? 0,
                'out_long' => $dto->long ?? 0
            ]);
        }

        return true;
    }

    public function getAttendanceByDateRange($start, $end)
    {
        $employeeId = $this->getCurrentEmployeeId();
        $start = Carbon::createFromFormat("d/m/Y", $start)->format('Y-m-d');
        $end =  Carbon::createFromFormat("d/m/Y", $end)->format('Y-m-d');

        Carbon::setLocale('id');
        return Attendance::where('employee_id', $employeeId)
            ->where('date', '>=', $start)
            ->where('date', '<=', $end)
            ->leftJoin('attendance_penalties as ap', 'ap.attendance_id', 'attendances.id')
            ->orderBy('date', 'desc')
            ->selectRaw("
                date,
                DATE_FORMAT(in_at,'%H:%i') as in_at, 
                DATE_FORMAT(out_at,'%H:%i') as out_at,
                IFNULL(ap.amount,0) as deduction,
                IFNULL(ap.in_minutes,0) as in_minutes
            ")
            ->get()->map(function ($attendance) {
                $date = Carbon::parse($attendance->date);
                $formattedDate = $date->isoFormat('dddd, D MMMM YYYY');
                $attendance->date = $formattedDate;
                return $attendance;
            });
    }
}
