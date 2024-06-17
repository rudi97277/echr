<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $headers = [
            'Nama',
            'Karyawan'
        ];

        $positions = Position::select('id', 'name')
            ->when(
                $request->keyword,
                fn ($query) => $query
                    ->where('name', 'LIKE', "%$request->keyword%")
            )
            ->withCount('employees')
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.position', [
            'headers' => $headers,
            'positions' => $positions,
            'pagination' => AppHelper::paginationData($positions)
        ]);
    }
}
