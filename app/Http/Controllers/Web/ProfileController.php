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
        $position = Position::select('id', 'name')->get();
        $shift = Shift::select('id', 'name')->get();
        $location = Location::selectRaw("id, CONCAT(name,' - ',address) as name")->get();

        return view('layouts.worker.profile', [
            'positions' => $position,
            'shifts' => $shift,
            'locations' => $location,
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
            "shift_id" => $request->shift,
            "location_id" => $request->location,
            "password" => $request->password ? bcrypt($request->password) : null,
        ], fn ($item) => !is_null($item));

        $employee = Employee::where('id', $employeeId)->update($data);

        if ($employee)
            return redirect('login')->with('success', 'Update profile berhasil.');
    }
}
