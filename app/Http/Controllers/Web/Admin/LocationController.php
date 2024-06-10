<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function page(Request $request)
    {
        $headers = [
            'Nama',
            'Alamat'
        ];

        $locations = Location::select('id', 'name', 'address')
            ->when(
                $request->keyword,
                fn ($query) => $query
                    ->where('name', 'LIKE', "%$request->keyword%")
                    ->orWhere('address', 'LIKE', "%$request->keyword%")
            )
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.location', [
            'headers' => $headers,
            'locations' => $locations,
            'pagination' => AppHelper::paginationData($locations)
        ]);
    }
}
