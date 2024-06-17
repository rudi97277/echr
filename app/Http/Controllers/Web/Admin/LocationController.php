<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $headers = [
            'Nama',
            'Alamat',
            'Karyawan'
        ];

        $locations = Location::select('id', 'name', 'address')
            ->when(
                $request->keyword,
                fn ($query) => $query
                    ->where('name', 'LIKE', "%$request->keyword%")
                    ->orWhere('address', 'LIKE', "%$request->keyword%")
            )
            ->withCount('employees')
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.location', [
            'headers' => $headers,
            'locations' => $locations,
            'pagination' => AppHelper::paginationData($locations)
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "address" => "required|string",
        ], [
            "name.required" => "Nama lokasi dibutuhkan",
            "address.required" => "Alamat lokasi dibutuhkan",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Location::create([
            'name' => $request->name,
            'address' => $request->address
        ]);

        return redirect()->back()->with('success', 'Data lokasi berhasil di simpan');
    }

    public function show(Request $request, string $obfuscatedId)
    {
        $locationId = AppHelper::unObfuscate($obfuscatedId);
        $location = Location::where('id', $locationId)->firstOrFail();
        return view('layouts.admin.location-edit', [
            'location' => $location
        ]);
    }

    public function update(Request $request, string $obfuscatedId)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "address" => "required|string",
        ], [
            "name.required" => "Nama lokasi dibutuhkan",
            "address.required" => "Alamat lokasi dibutuhkan",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $locationId = AppHelper::unObfuscate($obfuscatedId);

        Location::where('id', $locationId)->update([
            'name' => $request->name,
            'address' => $request->address
        ]);

        return redirect()->route('admin.master-lokasi')->with('success', 'Data lokasi berhasil di simpan');
    }
}
