<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

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
}
