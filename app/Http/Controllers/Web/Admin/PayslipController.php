<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function page(Request $request)
    {
        return view('layouts.admin.payslip');
    }
}
