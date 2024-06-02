<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MEmployee;
use App\Models\MLocation;
use App\Models\MPosition;
use App\Models\MShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function page()
    {
        $mPositions = MPosition::select('id', 'name')->get();
        $mShifts = MShift::select('id', 'name')->get();
        $mLocations = MLocation::select('id', 'name')->get();
        return view('front.worker.register', [
            'positions' => $mPositions,
            'shifts' => $mShifts,
            'locations' => $mLocations
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:m_employees,email",
            "position" => "required|exists:m_positions,id",
            "shift" => "required|exists:m_shifts,id",
            "location" => "required|exists:m_locations,id",
            "password" => "required|string|min:8"
        ], [
            "email.unique" => "Email yang anda masukkan telah digunakan. Harap gunakan email lain.",
            "password.min" => "Harap masukkan kata sandi yang lebih dari atau sama dengan 8 karakter"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mEmployee = MEmployee::create([
            "name" => $request->name,
            "email" => $request->email,
            "m_position_id" => $request->position,
            "m_shift_id" => $request->shift,
            "m_location_id" => $request->location,
            "password" => bcrypt($request->password),
        ]);

        if ($mEmployee)
            return redirect('login')->with('success', 'Pendaftaran anda telah berhasil. Silahkan masuk untuk mulai menggunakan akun anda.');
    }
}
