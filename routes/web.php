<?php

use App\Livewire\Worker\MyDashboard;
use App\Livewire\Worker\Navigation;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('https://dev-be.x5.com.au/testing/', $handle);
});


Livewire::setScriptRoute(function ($handle) {
    return Route::get('https://dev-be.x5.com.au/testing/', $handle);
});

Route::get('/', MyDashboard::class);
