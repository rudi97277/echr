<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\Web\Admin\EmployeeController;
use App\Http\Controllers\Web\Admin\LocationController;
use App\Http\Controllers\Web\Admin\PositionController;
use App\Http\Controllers\Web\Admin\ShiftController;
use App\Http\Controllers\Web\HistoryController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\MyDashboard;
use App\Http\Controllers\Web\PayslipController;
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
    Route::post('profile', [ProfileController::class, 'update']);

    Route::get('payslip', [PayslipController::class, 'page'])->name('worker.payslip');

    Route::get('logout', [LoginController::class, 'logout'])->name('worker.logout');
});

Route::middleware(['auth', 'roles:' . RoleEnum::ADMINISTRATOR])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('employee', [EmployeeController::class, 'page'])->name('admin.employee');
        Route::get('employee/{id}', [EmployeeController::class, 'pageEdit'])->name('admin.employee-edit');

        Route::get('shift', [ShiftController::class, 'page'])->name('admin.shift');
        Route::get('shift/{id}', [ShiftController::class, 'pageEdit'])->name('admin.shift-edit');

        Route::get('position', [PositionController::class, 'page'])->name('admin.position');
        Route::get('position/{id}', [PositionController::class, 'pageEdit'])->name('admin.position-edit');

        Route::get('location', [LocationController::class, 'page'])->name('admin.location');
        Route::get('location/{id}', [LocationController::class, 'pageEdit'])->name('admin.location-edit');
    });
});

Route::get('{path}', function () {
    return redirect()->route('admin.employee');
});
