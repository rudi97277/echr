<?php

namespace App\Services;

use App\DTOs\AttendanceDTO;
use App\Models\Attendance;
use App\Models\MShift;
use App\Traits\MEmployeeInfo;
use Carbon\Carbon;

class AttendanceService
{

    use MEmployeeInfo;
    public function __construct(public UploadService $uploadService)
    {
    }

    public function getThisWeekAttendance()
    {
        $mEmloyeeId = $this->getCurrentMEmployeeId();
        $thisWeekAttendances = Attendance::where('m_employee_id', $mEmloyeeId)
            ->selectRaw("
                id,
                date,
                DATE_FORMAT(in_at,'%H:%i') as in_at, 
                DATE_FORMAT(out_at,'%H:%i') as out_at
                ")
            ->orderBy('in_at', 'desc')
            ->with('attendancePenalty')
            ->whereRaw('WEEK(in_at) = WEEK(CURDATE())')->get();

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

    public function storeAttendance(AttendanceDTO $dto)
    {
        $path = $this->uploadService->uploadReturnPath($dto->image, 'attendances');
        $now = Carbon::now();
        $mEmloyee = $this->getCurrentMEmployee();
        $shift = MShift::where('id', $mEmloyee->m_shift_id)->first();

        $attendance = Attendance::where('m_employee_id', $mEmloyee->id)->whereDate('date', now())->first();
        if (!$attendance) {

            $clockIn = Carbon::parse("{$now->format('Y-m-d')} $shift->clock_in");
            $diffInMinutes = $clockIn->diffInMinutes($now, false);
            $attendance = Attendance::create([
                'm_employee_id' => $mEmloyee->id,
                'date' => $now,
                'in_at' => $now,
                'in_image' => $path,
                'in_lat' => $dto->lat ?? 0,
                'in_long' => $dto->long ?? 0
            ]);

            if ($diffInMinutes > 0)
                $attendance->attendancePenalty()->create([
                    'in_minutes' => $diffInMinutes,
                    'amount' => $diffInMinutes * 500,
                ]);
        } else {
            $attendance->update([
                'out_at' => $now,
                'out_image' => $path,
                'out_lat' => $dto->lat ?? 0,
                'out_long' => $dto->long ?? 0
            ]);
        }

        return true;
    }
}
