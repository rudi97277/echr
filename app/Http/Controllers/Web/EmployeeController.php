<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function page(Request $request)
    {
        $headers = [
            'Nama',
            'Email',
            'Jabatan',
            'Shift',
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
            ->paginate($request->input('page_size', 10))->appends(request()->query());

        return view('layouts.admin.employee', [
            'headers' => $headers,
            'employees' => $employees,
            'pagination' => collect($employees)->only('from', 'to', 'per_page', 'total', 'last_page', 'next_page_url', 'prev_page_url', 'current_page')
        ]);
    }

    public function pageEdit(string $obfuscatedId)
    {
        $id = AppHelper::unObfuscate($obfuscatedId);
        $employee =  Employee::find($id);

        return view('layouts.admin.employee-edit', [
            'employee' => $employee
        ]);
    }
}
