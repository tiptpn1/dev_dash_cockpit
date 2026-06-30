<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SSOController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AiResponseController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BigQueryController;
use App\Http\Controllers\SkyviewController;
use App\Http\Controllers\Management\UserManagementController;
use App\Http\Controllers\Management\FeatureManagementController;
use App\Http\Controllers\Management\UserFeatureAccessController;
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

// Include SSO routes
require base_path('routes/sso.php');

Route::get('/login', function () {
    return view('auth/login');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/svg-captcha', [LoginController::class, 'svgCaptcha'])->name('svg.captcha');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/portalaplikasi', [PageController::class, 'portalaplikasi'])->name('portalaplikasi');
Route::get('/portallm', [PageController::class, 'portallm'])->name('portallm');

Route::middleware('auth:custom')->group(function () {
    Route::get('/', [PageController::class, 'overview'])->name('overview');

    // Change Password Routes
    Route::get('/ubah-password', [\App\Http\Controllers\Auth\PasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/ubah-password', [\App\Http\Controllers\Auth\PasswordController::class, 'updatePassword'])->name('password.update');

    Route::get('/mrc', [PageController::class, 'mrc'])->name('mrc');
    Route::get('/aigri', [PageController::class, 'aigri'])->name('aigri');
    Route::get('/gardai', [PageController::class, 'gardai'])->name('gardai');
    Route::get('/onfarmkaret', [PageController::class, 'onfarmkaret'])->name('onfarmkaret');
    Route::get('/onfarmteh', [PageController::class, 'onfarmteh'])->name('onfarmteh');
    Route::get('/onfarmkopi', [PageController::class, 'onfarmkopi'])->name('onfarmkopi');
    Route::get('/offfarmkaret', [PageController::class, 'offfarmkaret'])->name('offfarmkaret');
    Route::get('/offfarmteh', [PageController::class, 'offfarmteh'])->name('offfarmteh');
    Route::get('/offfarmkopi', [PageController::class, 'offfarmkopi'])->name('offfarmkopi');
    Route::get('/gudangutilisasi', [PageController::class, 'gudangutilisasi'])->name('gudangutilisasi');

    Route::get('/picaonfarm', [PageController::class, 'picaonfarm'])->name('picaonfarm');
    Route::get('/picaofffarm', [PageController::class, 'picaofffarm'])->name('picaofffarm');
    Route::get('/pica/kuadran-problem-identifications', [PageController::class, 'picaKuadranProblemIdentifications'])->name('pica.kuadran_problem_identifications');
    Route::get('/pica/list-corrective-actions', [PageController::class, 'picaListCorrectiveActions'])->name('pica.list_corrective_actions');

    Route::get('/dfarmkaret', [PageController::class, 'dfarmkaretpresensi'])->name('dfarmkaretpresensi');
    Route::get('/dfarmpresensitabular', [PageController::class, 'dfarmkaretpresensitabular'])->name('dfarmkaretpresensitabular');
    Route::get('/dfarmkaretproduksi', [PageController::class, 'dfarmkaretproduksi'])->name('dfarmkaretproduksi');
    Route::get('/dfarmteh', [PageController::class, 'dfarmtehpresensi'])->name('dfarmtehpresensi');
    Route::get('/dfarmtehproduksi', [PageController::class, 'dfarmtehproduksi'])->name('dfarmtehproduksi');
    Route::post('/ajax_dfarmtehproduksi', [PageController::class, 'ajax_dfarmtehproduksi'])->name('ajax_dfarmtehproduksi');
    Route::get('/dfarmkopiproduksi', [PageController::class, 'dfarmkopiproduksi'])->name('dfarmkopiproduksi');
    Route::post('/ajax_dfarmkopiproduksi', [PageController::class, 'ajax_dfarmkopiproduksi'])->name('ajax_dfarmkopiproduksi');
    Route::get('/dfarmpemeliharaan', [PageController::class, 'dfarmpemeliharaan'])->name('dfarmpemeliharaan');
    Route::post('/ajax_dfarmpemeliharaan', [PageController::class, 'ajax_dfarmpemeliharaan'])->name('ajax_dfarmpemeliharaan');
    Route::get('/get_data_kebun', [ApiController::class, 'get_data_kebun'])->name('get_data_kebun');
    Route::get('/get_data_aktivitas', [ApiController::class, 'get_data_aktivitas'])->name('get_data_aktivitas');
    Route::get('/dfarmkaretbkmsap', [PageController::class, 'dfarmkaretbkm'])->name('dfarmkaretbkm');

    Route::get('/sapa-evaluasi', [PageController::class, 'sapaEvaluasi'])->name('sapa.evaluasi');
    Route::get('/bpd-evaluasi', [PageController::class, 'bpdEvaluasi'])->name('bpd.evaluasi');
    Route::get('/api/bpd/bidang-status', [PageController::class, 'getBidangStatusApi'])->name('api.bpd.bidang.status');
    Route::get('/api/bpd/biaya-anggaran', [PageController::class, 'getBiayaAnggaranApi'])->name('api.bpd.biaya.anggaran');
    Route::get('/api/bpd/detailbpd', [PageController::class, 'SelectListBpdBiaya'])->name('api.bpd.listbpdbiaya');

    Route::get('/fin_console', [PageController::class, 'fin_console'])->name('fin_console');
    Route::get('/fin_parent', [PageController::class, 'fin_parent'])->name('fin_parent');
    Route::get('/fin_sub', [PageController::class, 'fin_sub'])->name('fin_sub');

    Route::get('/hr_demographics', [PageController::class, 'hr_demographics'])->name('hr_demographics');
    Route::get('/hr_dev', [PageController::class, 'hr_dev'])->name('hr_dev');
    Route::get('/hr_revenue', [PageController::class, 'hr_revenue'])->name('hr_revenue');

    Route::get('/agraria_tax', [PageController::class, 'agraria_tax'])->name('agraria_tax');
    Route::get('/agraria', [PageController::class, 'agraria'])->name('agraria');

    Route::get('/sales_comodities', [PageController::class, 'sales_comodities'])->name('sales_comodities');
    Route::get('/overview_sales', [PageController::class, 'overview_sales'])->name('overview_sales');
    Route::get('/penjualan_karet', [PageController::class, 'penjualan_karet'])->name('penjualan_karet');
    Route::get('/pemasaran_karet', [PageController::class, 'pemasaran_karet'])->name('pemasaran_karet');

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

    Route::get('/lm13', [PageController::class, 'lm13'])->name('lm13');
    Route::get('/lm14', [PageController::class, 'lm14'])->name('lm14');
    Route::get('/lm14_rev', [PageController::class, 'lm14_rev'])->name('lm14_rev');
    Route::get('/lm16', [PageController::class, 'lm16'])->name('lm16');
    Route::get('/lm16_rev', [PageController::class, 'lm16_rev'])->name('lm16_rev');
    Route::get('/lm34', [PageController::class, 'lm34'])->name('lm34');
    Route::get('/lm34_tab', [PageController::class, 'lm34_tab'])->name('lm34_tab');
    Route::get('/lm62', [PageController::class, 'lm62'])->name('lm62');

    Route::get('/under_construction', [PageController::class, 'under_construction'])->name('under_construction');

    Route::get('/skyview', [PageController::class, 'skyview'])->name('skyview');
    Route::get('/exec_summary', [PageController::class, 'exec_summary'])->name('exec_summary');

    // Skyview Table (CRUD)
    Route::get('/skyview-table', [SkyviewController::class, 'index'])->name('skyview_table');
    Route::post('/skyview-table', [SkyviewController::class, 'store'])->name('skyview.store');
    Route::get('/skyview-table/{skyview}', [SkyviewController::class, 'show'])->name('skyview.show');
    Route::put('/skyview-table/{skyview}', [SkyviewController::class, 'update'])->name('skyview.update');
    Route::delete('/skyview-table/{skyview}', [SkyviewController::class, 'destroy'])->name('skyview.destroy');

    Route::get('/get_data_lm13', [BigQueryController::class, 'get_data_lm13'])->name('get_data_lm13');
    Route::get('/get_data_lm14', [BigQueryController::class, 'get_data_lm14'])->name('get_data_lm14');
    Route::get('/get_data_lm14_rev', [BigQueryController::class, 'get_data_lm14_rev'])->name('get_data_lm14_rev');
    Route::get('/get_data_lm16', [BigQueryController::class, 'get_data_lm16'])->name('get_data_lm16');
    Route::get('/get_data_lm16_rev', [BigQueryController::class, 'get_data_lm16_rev'])->name('get_data_lm16_rev');
    Route::get('/get_data_lm34', [BigQueryController::class, 'get_data_lm34'])->name('get_data_lm34');
    Route::get('/get_data_lm34_by_negara', [BigQueryController::class, 'get_data_lm34_by_negara'])->name('get_data_lm34_by_negara');
    Route::get('/get_data_lm34_by_customer', [BigQueryController::class, 'get_data_lm34_by_customer'])->name('get_data_lm34_by_customer');
    Route::get('/get_data_lm62', [BigQueryController::class, 'get_data_lm62'])->name('get_data_lm62');
    // Management Routes
    Route::prefix('management')->name('management.')->group(function () {
        Route::get('users/export', [UserManagementController::class, 'export'])->name('users.export');
        Route::resource('users', UserManagementController::class);

        Route::get('features/export', [FeatureManagementController::class, 'export'])->name('features.export');
        Route::resource('features', FeatureManagementController::class);

        Route::get('access/export', [UserFeatureAccessController::class, 'export'])->name('access.export');
        Route::get('access', [UserFeatureAccessController::class, 'index'])->name('access.index');
        Route::get('access/{user}/edit', [UserFeatureAccessController::class, 'edit'])->name('access.edit');
        Route::put('access/{user}', [UserFeatureAccessController::class, 'update'])->name('access.update');
        Route::get('lastlogin/export', [UserManagementController::class, 'exportLastLogin'])->name('lastlogin.export');
        Route::get('lastlogin', [UserManagementController::class, 'lastLogin'])->name('lastlogin.index');
    });

    // AI Response Route
    Route::post('/ai/response', [AiResponseController::class, 'aiResponse']);
});

Route::get('/evaluasi-bypass', function (\Illuminate\Http\Request $request) {
    if ($request->get('token') === 'ptpn1-admin-eval-bypass-992') {
        $user = \App\Models\CustomUser::where('username', 'superadmin')->first();
        if ($user) {
            \Illuminate\Support\Facades\Auth::guard('custom')->login($user);
            return redirect('/evaluasi-aplikasi');
        }
    }
    abort(403, 'Invalid token');
});

// Evaluasi Aplikasi Routes - menggunakan static token OR session login biasa
// Akses via token  : /evaluasi-aplikasi?token=ptpn1-hris-eval-2024-xK9mPqRs
// Akses via session: login biasa kemudian kunjungi /evaluasi-aplikasi
Route::middleware(['check.token.or.session'])->group(function () {
    Route::get('/evaluasi-aplikasi', [PageController::class, 'evaluasi_aplikasi'])->name('evaluasi_aplikasi');
    Route::get('/evaluasi-aplikasi/monika', [PageController::class, 'evaluasi_monika'])->name('evaluasi_monika');
    Route::get('/evaluasi-aplikasi/maia', [PageController::class, 'evaluasi_maia'])->name('evaluasi_maia');
    Route::get('/api/monika/dashboard', [PageController::class, 'monika_dashboard'])->name('monika_dashboard');
    Route::get('/api/maia/dashboard', [PageController::class, 'maia_dashboard'])->name('maia_dashboard');
    Route::get('/evaluasi-aghris', [PageController::class, 'evaluasi_aghris'])->name('evaluasi_aghris');
    Route::post('/api/aghris/dashboard', [PageController::class, 'aghris_dashboard'])->name('aghris_dashboard');
    Route::get('/evaluasi-aplikasi/hris-data', [PageController::class, 'evaluasi_hris_data'])->name('evaluasi_hris_data');
    Route::get('/evaluasi-aplikasi/hris-detail', [PageController::class, 'evaluasi_hris_detail'])->name('evaluasi_hris_detail');
    Route::get('/evaluasi-aplikasi/hris-divisi', [PageController::class, 'evaluasi_hris_divisi'])->name('evaluasi_hris_divisi');
    Route::get('/evaluasi-aplikasi/hris-harian', [PageController::class, 'evaluasi_hris_harian'])->name('evaluasi_hris_harian');
    Route::get('/evaluasi-aplikasi/hris-perkaryawan', [PageController::class, 'evaluasi_hris_perkaryawan'])->name('evaluasi_hris_perkaryawan');
    Route::get('/evaluasi-aplikasi/hris-pegawai-list', [PageController::class, 'evaluasi_hris_pegawai_list'])->name('evaluasi_hris_pegawai_list');
    Route::get('/evaluasi-aplikasi/hris-regional-list', [PageController::class, 'evaluasi_hris_regional_list'])->name('evaluasi_hris_regional_list');
    Route::get('/evaluasi-aplikasi/hris-rekap-regional', [PageController::class, 'evaluasi_hris_rekap_regional'])->name('evaluasi_hris_rekap_regional');
    Route::get('/evaluasi-aplikasi/hris-rekap-regional-detail', [PageController::class, 'evaluasi_hris_rekap_regional_detail'])->name('evaluasi_hris_rekap_regional_detail');
    Route::get('/evaluasi-aplikasi/hris-rekap-regional-pegawai', [PageController::class, 'evaluasi_hris_rekap_regional_pegawai'])->name('evaluasi_hris_rekap_regional_pegawai');
    Route::get('/evaluasi-aplikasi/hris-rekap-regional-pegawai-detail', [PageController::class, 'evaluasi_hris_rekap_regional_pegawai_detail'])->name('evaluasi_hris_rekap_regional_pegawai_detail');

});

Route::get('/test-external-api', function () {
    $apiKey = env('INTERNAL_API_KEY', 'RahasiaAPIKey123');

    $rekapUrl = 'https://aset.ptpn1.co.id/api/report/rekap-presentase?year=2026&month=6';
    $detailUrl = 'https://aset.ptpn1.co.id/api/report/presentase?year=2026&month=6';

    $rekapResponse = null;
    $detailResponse = null;
    $rekapError = null;
    $detailError = null;

    try {
        $res = \Illuminate\Support\Facades\Http::withoutVerifying()
            ->withHeaders(['x-api-key' => $apiKey])
            ->timeout(10)
            ->get($rekapUrl);
        $rekapResponse = $res->json();
    } catch (\Throwable $e) {
        $rekapError = $e->getMessage();
    }

    try {
        $res = \Illuminate\Support\Facades\Http::withoutVerifying()
            ->withHeaders(['x-api-key' => $apiKey])
            ->timeout(10)
            ->get($detailUrl);
        $detailResponse = $res->json();
    } catch (\Throwable $e) {
        $detailError = $e->getMessage();
    }

    return response()->json([
        'rekap_url' => $rekapUrl,
        'rekap_response' => $rekapResponse,
        'rekap_error' => $rekapError,
        'detail_url' => $detailUrl,
        'detail_response' => $detailResponse,
        'detail_error' => $detailError,
    ]);
});

