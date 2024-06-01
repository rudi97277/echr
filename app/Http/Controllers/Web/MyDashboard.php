<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyDashboard extends Controller
{
    public function page()
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
        return view('front.my-dashboard', ['today' => $today, 'attendances' => $attendances, 'attendance' => $attendance]);
    }


    public function attendance(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'image' => 'required|string'
        ]);

        $attendance = Attendance::where('m_employee_id', 1)->whereDate('date', now())->first();
        if (!$attendance) {
            Attendance::create([
                'm_employee_id' => 1,
                'date' => now(),
                'clock_in' => now(),
                'lat' => $request->lat ?? 0,
                'long' => $request->long ?? 0
            ]);
        } else {
            $attendance->update([
                'clock_out' => now(),
            ]);
        }

        $image = $request->input('image');
        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
        $imageName = 'image_' . time() . '.jpg';
        file_put_contents(public_path('' . $imageName), $decodedImage);
        return redirect()->back();
    }
}
