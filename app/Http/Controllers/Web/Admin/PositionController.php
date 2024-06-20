<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use App\Models\PositionSalary;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $headers = [
            'Nama',
            'Karyawan',
            'Gaji'
        ];

        $positions = Position::select('id', 'name')
            ->when(
                $request->keyword,
                fn ($query) => $query
                    ->where('name', 'LIKE', "%$request->keyword%")
            )
            ->withCount('employees as employee')
            ->withSum('salaries as salary', 'amount')
            ->paginate($request->input('page_size', 10));

        $salaries = Salary::get();

        return view('layouts.admin.position', [
            'headers' => $headers,
            'positions' => PositionResource::collection($positions),
            'pagination' => AppHelper::paginationData($positions),
            'salaries' => $salaries
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
        ], [
            "name.required" => "Nama posisi dibutuhkan",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $position = Position::create(['name' => $request->name]);
        $salaries = [];
        $codes = $request->codes ?? [];
        $amounts = $request->amounts ?? [];
        foreach ($codes as $key => $code) {
            if (isset($amounts[$key]) && $amounts[$key] > 0)
                $salaries[] = [
                    'position_id' => $position->id,
                    'salary_code' => $code,
                    'amount' => $amounts[$key],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
        }

        $position->salaries()->insert($salaries);

        return redirect()->back()->with('success', 'Data jabatan berhasil di simpan');
    }

    public function show(Request $request, string $obfuscatedId)
    {
        $positionId = AppHelper::unObfuscate($obfuscatedId);
        $position = Position::where('id', $positionId)->firstOrFail();

        $subSalary = PositionSalary::where('position_id', $position->id)->select('salary_code', 'amount');

        $salaries = Salary::leftJoinSub(
            $subSalary,
            'sub_salary',
            fn ($join) =>
            $join->on('sub_salary.salary_code', 'salaries.code')
        )
            ->select('code', 'name', 'amount')
            ->get();
        return view('layouts.admin.position-edit', [
            'salaries' => $salaries,
            'position' => $position
        ]);
    }

    public function update(Request $request, string $obfuscatedId)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
        ], [
            "name.required" => "Nama posisi dibutuhkan",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $positionId = AppHelper::unObfuscate($obfuscatedId);
        Position::where('id', $positionId)->update(['name' => $request->name]);
        PositionSalary::where('position_id', $positionId)->delete();

        $salaries = [];
        $codes = $request->codes ?? [];
        $amounts = $request->amounts ?? [];
        foreach ($codes as $key => $code) {
            if (isset($amounts[$key]) && $amounts[$key] > 0)
                $salaries[] = [
                    'position_id' => $positionId,
                    'salary_code' => $code,
                    'amount' => $amounts[$key],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
        }

        PositionSalary::insert($salaries);
        return redirect()->route('admin.master-jabatan')->with('success', 'Data jabatan berhasil di simpan');
    }
}
