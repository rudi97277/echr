<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function page()
    {
        return view('front.worker.history');
    }
}
