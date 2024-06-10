<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function page(Request $request)
    {
        $headers = [
            'Nama',
            'Clock In',
            'Clock Out'
        ];

        $shifts = Shift::select('id', 'name', 'clock_in', 'clock_out')
            ->when(
                $request->keyword,
                fn ($query) => $query
                    ->where('name', 'LIKE', "%$request->keyword%")
                    ->orWhere('clock_in', 'LIKE', "%$request->keyword%")
                    ->orWhere('clock_out', 'LIKE', "%$request->keyword%")
            )
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.shift', [
            'headers' => $headers,
            'shifts' => $shifts,
            'pagination' => AppHelper::paginationData($shifts)
        ]);
    }
}
