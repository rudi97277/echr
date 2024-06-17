<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\Web\Admin\AttendanceController;
use App\Http\Controllers\Web\Admin\EmployeeController;
use App\Http\Controllers\Web\Admin\LocationController;
use App\Http\Controllers\Web\Admin\MasterFormController;
use App\Http\Controllers\Web\Admin\PayslipController as AdminPayslipController;
use App\Http\Controllers\Web\Admin\PositionController;
use App\Http\Controllers\Web\Admin\ShiftController;
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

    Route::resource('payslip', PayslipController::class)->only('index', 'show')->names([
        'index' => 'worker.payslip',
        'show' => 'worker.payslip.detail'
    ]);

    Route::get('logout', [LoginController::class, 'logout'])->name('worker.logout');
});

Route::middleware(['auth', 'roles:' . RoleEnum::ADMINISTRATOR])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('master')->group(function () {
            Route::resource('employee', EmployeeController::class)->only('index', 'show', 'update')->names([
                'index' => 'admin.master-karyawan',
                'show' => 'admin.master-karyawan.edit'
            ]);
            Route::get('employee/{id}/attendance', [AttendanceController::class, 'page'])->name('admin.master-karyawan.absensi');

            Route::resource('shift', ShiftController::class)->only('index', 'show', 'update', 'store')->names([
                'index' => 'admin.master-jadwal',
                'show' => 'admin.master-jadwal.edit'
            ]);
            Route::resource('position', PositionController::class)->only('index', 'show')->names([
                'index' => 'admin.master-jabatan',
                'show' => 'admin.master-jabatan.edit'
            ]);
            Route::resource('location', LocationController::class)->only('index', 'show')->names([
                'index' => 'admin.master-lokasi',
                'show' => 'admin.master-lokasi.edit'
            ]);

            Route::resource('form', MasterFormController::class)->only('index', 'create', 'store', 'show', 'update')->names([
                'index' => 'admin.master-form',
                'show' => 'admin.master-form.edit',
                'create' => 'admin.master-form.tambah',
                'store' => 'admin.master-form.store'
            ]);
        });

        Route::resource('payslip', AdminPayslipController::class)->only('index', 'store', 'show')->names([
            'index' => 'admin.payslip',
            'show' => 'admin.payslip.detail'
        ]);






        Route::get('form', [FormController::class, 'page'])->name('admin.form');
        Route::get('form/add', [FormController::class, 'pageAdd'])->name('admin.form.tambah');
        Route::post('form/add', [FormController::class, 'pageAddAction']);

        Route::get('form/{id}', [FormController::class, 'pageEdit'])->name('admin.form.edit');
        Route::post('form/{id}', [FormController::class, 'pageEditAction']);
    });
});

Route::get('{path}', function () {
    return redirect()->route('admin.master-karyawan');
});
