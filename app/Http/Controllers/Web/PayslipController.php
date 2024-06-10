<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function page()
    {
        return view('layouts.worker.payslip');
    }
}
