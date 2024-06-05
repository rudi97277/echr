<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdministratorContoller extends Controller
{
    public function page()
    {
        return view('layouts.admin.home');
    }
}
