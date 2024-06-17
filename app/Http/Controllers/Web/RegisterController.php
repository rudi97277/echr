<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Position;
use App\Models\PositionSalary;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function page()
    {
        $position = Position::select('id', 'name')->get();
        $shift = Shift::select('id', 'name')->get();
        $location = Location::selectRaw("id, CONCAT(name,' - ',address) as name")->get();
        return view('layouts.worker.register', [
            'positions' => $position,
            'shifts' => $shift,
            'locations' => $location
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:employees,email",
            "position" => "required|exists:positions,id",
            "shift" => "required|exists:shifts,id",
            "location" => "required|exists:locations,id",
            "password" => "required|string|min:8"
        ], [
            "email.unique" => "Email yang anda masukkan telah digunakan. Harap gunakan email lain.",
            "password.min" => "Harap masukkan kata sandi yang lebih dari atau sama dengan 8 karakter"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employee = Employee::create([
            "name" => $request->name,
            "email" => $request->email,
            "position_id" => $request->position,
            "shift_id" => $request->shift,
            "location_id" => $request->location,
            "password" => bcrypt($request->password),
        ]);

        if ($employee) {
            $positionSalaries = PositionSalary::where('position_id', $request->position)->get();
            $salaries = [];
            foreach ($positionSalaries as $salary) {
                $salaries[] = [
                    'employee_id' => $employee->id,
                    'salary_code' => $salary->salary_code,
                    'amount' => $salary->amount,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            if (count($salaries) > 0)
                $employee->salaries()->insert($salaries);

            return redirect('login')->with('success', 'Pendaftaran anda telah berhasil. Silahkan masuk untuk mulai menggunakan akun anda.');
        }

        return redirect()->back()->withErrors(['employee' => 'Pendaftaran anda gagal'])->withInput();
    }
}
