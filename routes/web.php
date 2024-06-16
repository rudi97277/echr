<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\Web\Admin\AttendanceController;
use App\Http\Controllers\Web\Admin\EmployeeController;
use App\Http\Controllers\Web\Admin\LocationController;
use App\Http\Controllers\Web\Admin\PayslipController as AdminPayslipController;
use App\Http\Controllers\Web\Admin\PositionController;
use App\Http\Controllers\Web\Admin\ShiftController;
use App\Http\Controllers\Web\AdministratorContoller;
use App\Http\Controllers\Web\FormController;
use App\Http\Controllers\Web\HistoryController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\MyDashboardController;
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
    Route::get('', [MyDashboardController::class, 'page'])->name('worker.home');
    Route::post('', [MyDashboardController::class, 'attendance']);
    Route::get('history', [HistoryController::class, 'page'])->name('worker.history');
    Route::post('history', [HistoryController::class, 'page']);

    Route::get('profile', [ProfileController::class, 'page'])->name('worker.profile');
    Route::post('profile', [ProfileController::class, 'update']);

    Route::get('payslip', [PayslipController::class, 'page'])->name('worker.payslip');
    Route::get('payslip/{id}', [PayslipController::class, 'pageDetail'])->name('worker.payslip.detail');

    Route::get('logout', [LoginController::class, 'logout'])->name('worker.logout');
});

Route::middleware(['auth', 'roles:' . RoleEnum::ADMINISTRATOR])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('employee', [EmployeeController::class, 'page'])->name('admin.karyawan');
        Route::get('employee/{id}', [EmployeeController::class, 'pageEdit'])->name('admin.karyawan.edit');
        Route::post('employee/{id}', [EmployeeController::class, 'update']);
        Route::get('employee/{id}/attendance', [AttendanceController::class, 'page'])->name('admin.karyawan.absensi');

        Route::get('shift', [ShiftController::class, 'page'])->name('admin.jadwal');
        Route::get('shift/{id}', [ShiftController::class, 'pageEdit'])->name('admin.jadwal.edit');

        Route::get('position', [PositionController::class, 'page'])->name('admin.jabatan');
        Route::get('position/{id}', [PositionController::class, 'pageEdit'])->name('admin.jabatan.edit');

        Route::get('location', [LocationController::class, 'page'])->name('admin.lokasi');
        Route::get('location/{id}', [LocationController::class, 'pageEdit'])->name('admin.lokasi.edit');

        Route::get('payslip', [AdminPayslipController::class, 'page'])->name('admin.payslip');
        Route::post('payslip', [AdminPayslipController::class, 'createPayslip']);
        Route::get('payslip/{id}', [AdminPayslipController::class, 'pageEdit'])->name('admin.payslip.detail');

        Route::get('form', [FormController::class, 'page'])->name('admin.form');
        Route::get('form/add', [FormController::class, 'pageAdd'])->name('admin.form.tambah');
        Route::post('form/add', [FormController::class, 'pageAddAction']);

        Route::get('form/{id}', [FormController::class, 'pageEdit'])->name('admin.form.edit');
        Route::post('form/{id}', [FormController::class, 'pageEditAction']);
    });
});

Route::get('{path}', function () {
    return redirect()->route('admin.karyawan');
});
