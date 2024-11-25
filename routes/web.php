<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;
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

// 

Route::get('/login', function () {
    return view('auth/login');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth:custom')->group(function () {
        Route::get('/', [PageController::class, 'overview'])->name('overview');
        Route::get('/onfarmkaret', [PageController::class, 'onfarmkaret'])->name('onfarmkaret');
        Route::get('/onfarmteh', [PageController::class, 'onfarmteh'])->name('onfarmteh');
        Route::get('/onfarmkopi', [PageController::class, 'onfarmkopi'])->name('onfarmkopi');
        Route::get('/offfarmkaret', [PageController::class, 'offfarmkaret'])->name('offfarmkaret');
        Route::get('/offfarmteh', [PageController::class, 'offfarmteh'])->name('offfarmteh');
        Route::get('/offfarmkopi', [PageController::class, 'offfarmkopi'])->name('offfarmkopi');

        Route::get('/fin_console', [PageController::class, 'fin_console'])->name('fin_console');
        Route::get('/fin_parent', [PageController::class, 'fin_parent'])->name('fin_parent');
        Route::get('/fin_sub', [PageController::class, 'fin_sub'])->name('fin_sub');
        
        Route::get('/hr_demographics', [PageController::class, 'hr_demographics'])->name('hr_demographics');
        Route::get('/hr_dev', [PageController::class, 'hr_dev'])->name('hr_dev');
        Route::get('/hr_revenue', [PageController::class, 'hr_revenue'])->name('hr_revenue');

        Route::get('/agraria_tax', [PageController::class, 'agraria_tax'])->name('agraria_tax');
        Route::get('/agraria', [PageController::class, 'agraria'])->name('agraria');

        Route::get('/sales_comodities', [PageController::class, 'sales_comodities'])->name('sales_comodities');

        Route::get('/asset_recovery', [PageController::class, 'asset_recovery'])->name('asset_recovery');
        Route::get('/asset_optimalisasi', [PageController::class, 'asset_optimalisasi'])->name('asset_optimalisasi');
        Route::get('/asset_divestasi', [PageController::class, 'asset_divestasi'])->name('asset_divestasi');

        Route::get('/portalaplikasi', [PageController::class, 'portalaplikasi'])->name('portalaplikasi');
});
