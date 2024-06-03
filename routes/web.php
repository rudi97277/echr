<?php

use App\Http\Controllers\Web\HistoryController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\MyDashboard;
use App\Http\Controllers\Web\RegisterController;
use Illuminate\Support\Facades\Route;

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

Route::get('login', [LoginController::class, 'page'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('register', [RegisterController::class, 'page'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('', [MyDashboard::class, 'page'])->name('home');
    Route::post('', [MyDashboard::class, 'attendance']);
    Route::get('history', [HistoryController::class, 'page'])->name('history');
});
