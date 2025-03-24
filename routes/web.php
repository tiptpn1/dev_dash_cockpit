<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AiResponseController;
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

Route::get('/portalaplikasi', [PageController::class, 'portalaplikasi'])->name('portalaplikasi');
Route::get('/portallm', [PageController::class, 'portallm'])->name('portallm');

Route::middleware('auth:custom')->group(function () {
        Route::get('/', [PageController::class, 'overview'])->name('overview');
        Route::get('/mrc', [PageController::class, 'mrc'])->name('mrc');
        Route::get('/aigri', [PageController::class, 'aigri'])->name('aigri');
        Route::get('/onfarmkaret', [PageController::class, 'onfarmkaret'])->name('onfarmkaret');
        Route::get('/onfarmteh', [PageController::class, 'onfarmteh'])->name('onfarmteh');
        Route::get('/onfarmkopi', [PageController::class, 'onfarmkopi'])->name('onfarmkopi');
        Route::get('/offfarmkaret', [PageController::class, 'offfarmkaret'])->name('offfarmkaret');
        Route::get('/offfarmteh', [PageController::class, 'offfarmteh'])->name('offfarmteh');
        Route::get('/offfarmkopi', [PageController::class, 'offfarmkopi'])->name('offfarmkopi');

        Route::get('/picaonfarm', [PageController::class, 'picaonfarm'])->name('picaonfarm');
        Route::get('/picaofffarm', [PageController::class, 'picaofffarm'])->name('picaofffarm');

        Route::get('/dfarmkaret', [PageController::class, 'dfarmkaret'])->name('dfarmkaret');
        Route::get('/dfarmteh', [PageController::class, 'dfarmteh'])->name('dfarmteh');

        Route::get('/fin_console', [PageController::class, 'fin_console'])->name('fin_console');
        Route::get('/fin_parent', [PageController::class, 'fin_parent'])->name('fin_parent');
        Route::get('/fin_sub', [PageController::class, 'fin_sub'])->name('fin_sub');
        
        Route::get('/hr_demographics', [PageController::class, 'hr_demographics'])->name('hr_demographics');
        Route::get('/hr_dev', [PageController::class, 'hr_dev'])->name('hr_dev');
        Route::get('/hr_revenue', [PageController::class, 'hr_revenue'])->name('hr_revenue');

        Route::get('/agraria_tax', [PageController::class, 'agraria_tax'])->name('agraria_tax');
        Route::get('/agraria', [PageController::class, 'agraria'])->name('agraria');

        Route::get('/sales_comodities', [PageController::class, 'sales_comodities'])->name('sales_comodities');

        Route::get('/asset_peta', [PageController::class, 'asset_peta'])->name('asset_peta');
        Route::get('/asset_recovery', [PageController::class, 'asset_recovery'])->name('asset_recovery');
        Route::get('/asset_optimalisasi', [PageController::class, 'asset_optimalisasi'])->name('asset_optimalisasi');
        Route::get('/asset_divestasi', [PageController::class, 'asset_divestasi'])->name('asset_divestasi');

        Route::get('/sla', [PageController::class, 'sla'])->name('sla');
        Route::get('/pengadaan', [PageController::class, 'pengadaan'])->name('pengadaaan');
        Route::get('/amanah', [PageController::class, 'amanah'])->name('amanah');
        Route::get('/iot', [PageController::class, 'iot'])->name('iot');
        Route::get('/prapengadaan', [PageController::class, 'prapengadaan'])->name('prapengadaan');
        Route::get('/prosespengadaan', [PageController::class, 'prosespengadaan'])->name('prosespengadaan');
        Route::get('/kontrakpengadaan', [PageController::class, 'kontrakpengadaan'])->name('kontrakpengadaan');
        Route::get('/stokpengadaan', [PageController::class, 'stokpengadaan'])->name('stokpengadaan');
        Route::get('/dashboardemisi', [PageController::class, 'dashboardemisi'])->name('dashboardemisi');
        Route::get('/soptea', [PageController::class, 'soptea'])->name('soptea');
});

Route::post('/ai/response', [AiResponseController::class, 'aiResponse']);
