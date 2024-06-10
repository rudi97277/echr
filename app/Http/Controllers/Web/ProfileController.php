<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Position;
use App\Models\Shift;
use App\Traits\EmployeeInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class ProfileController extends Controller
{
    use EmployeeInfo;
    public function page()
    {
        $employee = $this->getCurrentMEmployee();
        $mPositions = Position::select('id', 'name')->get();
        $mShifts = Shift::select('id', 'name')->get();
        $mLocations = Location::select('id', 'name')->get();

        return view('layouts.worker.profile', [
            'positions' => $mPositions,
            'shifts' => $mShifts,
            'locations' => $mLocations,
            'employee' => $employee
        ]);
    }

    public function update(Request $request)
    {
        $employeeId = $this->getCurrentEmployeeId();
        $validator = Validator::make($request->all(), [
            "name" => "nullable|string",
            "email" => "nullable|email|unique:employees,email,$employeeId,id",
            "position" => "nullable|exists:positions,id",
            "shift" => "nullable|exists:shifts,id",
            "location" => "nullable|exists:locations,id",
            "password" => "nullable|string|min:8"
        ], [
            "email.unique" => "Email yang anda masukkan telah digunakan. Harap gunakan email lain.",
            "password.min" => "Harap masukkan kata sandi yang lebih dari atau sama dengan 8 karakter"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array_filter([
            ...$request->only('name', 'email'),
            "position_id" => $request->position,
            "shift_id" => $request->shift_id,
            "location_id" => $request->location_id,
            "password" => $request->password ? bcrypt($request->password) : null,
        ], fn ($item) => !is_null($item));

        $employee = Employee::where('id', $employeeId)->update($data);

        if ($employee)
            return redirect('login')->with('success', 'Pendaftaran anda telah berhasil. Silahkan masuk untuk mulai menggunakan akun anda.');
    }
}
