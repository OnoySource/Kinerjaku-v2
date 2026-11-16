<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| KinerjaKu Web Routes
|--------------------------------------------------------------------------
*/

// DASHBOARD
Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');


// DATA KARYAWAN
Route::prefix('employees')
    ->name('employees.')
    ->controller(EmployeeController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/create', 'create')
            ->name('create');

        Route::post('/', 'store')
            ->name('store');

        Route::get('/{employee}', 'show')
            ->name('show');

        Route::get('/{employee}/edit', 'edit')
            ->name('edit');

        Route::put('/{employee}', 'update')
            ->name('update');

        Route::delete('/{employee}', 'destroy')
            ->name('destroy');
    });


// EVALUASI KINERJA
Route::prefix('evaluations')
    ->name('evaluations.')
    ->controller(EvaluationController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/create', 'create')
            ->name('create');

        Route::post('/', 'store')
            ->name('store');

        Route::get('/{evaluation}', 'show')
            ->name('show');
    });


// LAPORAN
Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');


// PENGATURAN
Route::get('/settings', [SettingController::class, 'index'])
    ->name('settings.index');
