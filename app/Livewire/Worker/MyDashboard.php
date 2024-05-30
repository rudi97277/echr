<?php

namespace App\Livewire\Worker;

use App\Models\Attendance;
use Carbon\Carbon;
use Livewire\Component;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MyDashboard extends Component
{
    public $lat = 0;
    public $long = 0;
    protected $listeners = ['updateLocation'];

    public function render()
    {
        $attendances = Attendance::where('m_employee_id', 1)
            ->selectRaw("
                id,
                date,
                DATE_FORMAT(clock_in,'%H:%i') as clock_in, 
                DATE_FORMAT(clock_out,'%H:%i') as clock_out")
            ->orderBy('clock_in', 'desc')
            ->whereRaw('WEEK(clock_in) = WEEK(CURDATE())')->get();

        $attendance = $attendances->where('date', date('Y-m-d'))->first();
        Carbon::setLocale('id');
        $attendances = $attendances->map(function ($item) {
            $date = Carbon::parse($item->date);
            $formattedDate = $date->isoFormat('D MMMM YYYY');
            $item->date = $formattedDate;
            return $item;
        });
        $today = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
        return view('livewire.worker.my-dashboard', ['today' => $today, 'attendances' => $attendances, 'attendance' => $attendance,]);
    }

    public function updateLocation($lat, $long)
    {
        $this->lat = $lat;
        $this->long = $long;
    }

    public function updateAttendance()
    {
        $attendance = Attendance::where('m_employee_id', 1)->whereDate('date', now())->first();
        if (!$attendance) {
            Attendance::create([
                'm_employee_id' => 1,
                'date' => now(),
                'clock_in' => now(),
                'lat' => $this->lat ?? 0,
                'long' => $this->long ?? 0
            ]);
        } else {
            $attendance->update([
                'clock_out' => now(),
            ]);
        }
    }
}
