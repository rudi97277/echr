<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\Web\AdministratorContoller;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\HistoryController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\MyDashboard;
use App\Http\Controllers\Web\ProfileController;
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

Route::get('login', [LoginController::class, 'page'])->name('worker.login');
Route::post('login', [LoginController::class, 'login']);

Route::get('register', [RegisterController::class, 'page'])->name('worker.register');
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('', [MyDashboard::class, 'page'])->name('worker.home');
    Route::post('', [MyDashboard::class, 'attendance']);
    Route::get('history', [HistoryController::class, 'page'])->name('worker.history');
    Route::post('history', [HistoryController::class, 'page']);
    Route::get('profile', [ProfileController::class, 'page'])->name('worker.profile');
});

Route::middleware(['auth', 'roles:' . RoleEnum::ADMINISTRATOR])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('employee', [EmployeeController::class, 'page'])->name('admin.employee');
        Route::get('employee/{id}', [EmployeeController::class, 'pageEdit'])->name('admin.employee-edit');
    });
});

Route::get('{path}', function () {
    return redirect()->route('admin.employee');
});
