<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShiftResource;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $headers = [
            'Nama',
            'Clock In',
            'Clock Out',
            'Penalti Per Menit',
            'Karyawan'
        ];

        $shifts = Shift::select('id', 'name', 'clock_in', 'clock_out', 'penalty_per_minutes')
            ->when(
                $request->keyword,
                fn ($query) => $query
                    ->where('name', 'LIKE', "%$request->keyword%")
                    ->orWhere('clock_in', 'LIKE', "%$request->keyword%")
                    ->orWhere('clock_out', 'LIKE', "%$request->keyword%")
            )
            ->withCount('employees')
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.shift', [
            'headers' => $headers,
            'shifts' => ShiftResource::collection($shifts),
            'pagination' => AppHelper::paginationData($shifts)
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "clock_in" => "required",
            "clock_out" => "required",
            "penalty_per_minutes" => "required"
        ], [
            "name.required" => "Nama jadwal dibutuhkan",
            "clock_in.required" => "Clock in dibutuhkan"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Shift::create([
            'name' => $request->name,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'penalty_per_minutes' => $request->penalty_per_minutes
        ]);

        return redirect()->back()->with('success', 'Data jadwal berhasil di tambahkan');
    }

    public function show(Request $request, string $obfuscatedId)
    {
        $shiftId = AppHelper::unObfuscate($obfuscatedId);
        $shift = Shift::where('id', $shiftId)->firstOrFail();

        return view('layouts.admin.shift-edit', [
            'shift' => $shift
        ]);
    }

    public function update(Request $request, string $obfuscatedId)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "clock_in" => "required",
            "clock_out" => "required",
            "penalty_per_minutes" => "required"
        ], [
            "name.required" => "Nama jadwal dibutuhkan",
            "clock_in.required" => "Clock in dibutuhkan"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $shiftId = AppHelper::unObfuscate($obfuscatedId);
        Shift::where('id', $shiftId)->update($request->only('name', 'clock_in', 'clock_out', 'penalty_per_minutes'));

        return redirect()->route('admin.master-jadwal')->with('success', 'Data jadwal berhasil di simpan');
    }
}
