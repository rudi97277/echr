<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PositionResource;
use App\Models\Position;
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
}
