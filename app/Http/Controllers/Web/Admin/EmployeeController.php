<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\RoleEnum;
use App\Enums\SalaryEnum;
use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeSalaryResource;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Location;
use App\Models\Position;
use App\Models\Salary;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $headers = [
            'Nama',
            'Email',
            'Shift',
            'Jabatan',
            'Lokasi'
        ];

        $employees = Employee::select('employees.id', 'employees.name', 'email', 's.name as shift', 'p.name as position', 'l.name as location')
            ->join('shifts as s', 's.id', 'employees.shift_id')
            ->join('positions as p', 'p.id', 'employees.position_id')
            ->join('locations as l', 'l.id', 'employees.location_id')
            ->when(
                $request->keyword,
                fn ($query) => $query
                    ->where('employees.name', 'LIKE', "%$request->keyword%")
                    ->orWhere('email', 'LIKE', "%$request->keyword%")
                    ->orWhere('s.name', 'LIKE', "%$request->keyword%")
                    ->orWhere('p.name', 'LIKE', "%$request->keyword%")
                    ->orWhere('l.name', 'LIKE', "%$request->keyword%")
            )
            ->orderBy('employees.id', 'desc')
            ->paginate($request->input('page_size', 10))->appends(request()->query());

        return view('layouts.admin.employee', [
            'headers' => $headers,
            'employees' => $employees,
            'pagination' => AppHelper::paginationData($employees)
        ]);
    }



    public function show(string $obfuscatedId)
    {
        $id = AppHelper::unObfuscate($obfuscatedId);
        $employee =  Employee::where('id', $id)->with([
            'salaries' => fn ($query) => $query->join('salaries as s', 's.code', 'employee_salaries.salary_code')
                ->select('s.name', 's.code', 'amount', 'employee_id', 'employee_salaries.id')
                ->orderBy('amount', 'desc')
        ])->first();
        $mPositions = Position::select('id', 'name')->get();
        $mShifts = Shift::select('id', 'name')->get();
        $mLocations = Location::select('id', 'name')->get();
        $salaries = $employee->salaries;
        $listSalary = Salary::select('code', 'name')->whereNotIn('code', $salaries->pluck('code'))->where('type', SalaryEnum::ADDITION)->get();
        $roles = RoleEnum::getAllConstants();

        return view('layouts.admin.employee-edit', [
            'employee' => $employee,
            'salaries' => EmployeeSalaryResource::collection($salaries),
            'positions' => $mPositions,
            'shifts' => $mShifts,
            'locations' => $mLocations,
            'listSalary' => $listSalary,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, string $obfuscatedId)
    {
        $employeeId = AppHelper::unObfuscate($obfuscatedId);
        $validator = Validator::make($request->all(), [
            "name" => "nullable|string",
            "email" => "nullable|email|unique:employees,email,$employeeId,id",
            "position" => "nullable|exists:positions,id",
            "shift" => "nullable|exists:shifts,id",
            "location" => "nullable|exists:locations,id",
            "password" => "nullable|string|min:8",
            "role" => "nullable",
            "delete_salary" => "nullable|string",
            "amount" => "nullable|numeric",
            "add_salary" => "nullable|string"
        ], [
            "email.unique" => "Email yang anda masukkan telah digunakan. Harap gunakan email lain.",
            "password.min" => "Harap masukkan kata sandi yang lebih dari atau sama dengan 8 karakter"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->add_salary && $request->amount) {
            $status = EmployeeSalary::create([
                'salary_code' => $request->add_salary,
                'amount' => $request->amount,
                "employee_id" => $employeeId
            ]);
            if ($status)
                return redirect()->back()->with('success', 'Data gaji karyawan berhasil di tambahkan');
        }

        if ($request->delete_salary) {
            $salaryId = AppHelper::unObfuscate($request->delete_salary);
            $status = EmployeeSalary::where([
                'id' => $salaryId,
                'employee_id' => $employeeId
            ])->delete();

            if ($status)
                return redirect()->back()->with('success', 'Data gaji karyawan berhasil di hapus');
        }

        $data = array_filter([
            ...$request->only('name', 'email'),
            "position_id" => $request->position,
            "shift_id" => $request->shift_id,
            "location_id" => $request->location_id,
            "password" => $request->password ? bcrypt($request->password) : null,
        ], fn ($item) => !is_null($item));

        $employee = Employee::where('id', $employeeId)->update([...$data, ...[
            "role" => $request->role
        ]]);

        if ($employee)
            return redirect()->back()->with('success', 'Update data karyawan berhasil. Silahkan kabari karyawan bersangkutan mengenai perubahan ini.');
    }
}
