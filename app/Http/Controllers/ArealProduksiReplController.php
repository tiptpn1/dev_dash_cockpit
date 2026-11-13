<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ArealProduksiReplController extends Controller
{
    public function index(Request $request)
    {
        // 0. Cek hak akses jika user login adalah akun regional (regional 2, 3, 5, 7, 8 atau memiliki field regional)
        $user = Auth::guard('custom')->user();
        $username = strtolower($user->username ?? '');
        $userRegId = null;

        if (preg_match('/^regional(\d+)$/i', $username, $matches)) {
            $userRegId = (string) $matches[1];
        } elseif (!empty($user->regional) && is_numeric($user->regional)) {
            $userRegId = (string) $user->regional;
        }

        // Flag apakah user login dibatasi hanya untuk regional tertentu
        $isRegionalUser = !empty($userRegId) && in_array((string)$userRegId, ['1', '2', '3', '4', '5', '6', '7', '8']);

        // 1. Master Reference Data
        $listTahun = Cache::remember('areal_list_tahun', 86400, function () {
            return DB::connection('looker')->table('vw_trend_dengan_pembanding')
                ->select('tahun')
                ->distinct()
                ->orderByDesc('tahun')
                ->pluck('tahun')
                ->toArray();
        });

        if (empty($listTahun)) {
            $listTahun = [date('Y')];
        }

        $listBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $listRegionalMaster = Cache::remember('areal_list_regional', 86400, function () {
            return DB::connection('looker')->table('vw_trend_dengan_pembanding')
                ->select('reg')
                ->distinct()
                ->orderBy('reg')
                ->pluck('reg')
                ->toArray();
        });

        // Untuk user regional, pilihan regional dibatasi hanya regional akunnya
        $listRegional = $isRegionalUser ? [(string)$userRegId] : $listRegionalMaster;

        $listKomoditi = ['KARET', 'TEH', 'ARABICA', 'ROBUSTA'];
        $allowedTabs = ['summary', 'produktivitas_regional', 'trend_produksi', 'rincian_kebun'];
        $allowedModes = ['sd', 'single'];

        // Handler jika form disubmit via POST (PRG: Post-Redirect-Get untuk mencegah URL terekspos dan Reflected XSS)
        if ($request->isMethod('post')) {
            $inputTahun = (int) $request->input('tahun', $listTahun[0]);
            $tahunClean = in_array($inputTahun, $listTahun, true) ? $inputTahun : $listTahun[0];

            $inputBulan = (int) $request->input('bulan', 11);
            $bulanClean = ($inputBulan >= 1 && $inputBulan <= 12) ? $inputBulan : 11;

            $inputMode = $request->input('mode_periode', 'sd');
            $modeClean = in_array($inputMode, $allowedModes, true) ? $inputMode : 'sd';

            $inputTab = $request->input('tab', 'summary');
            $tabClean = in_array($inputTab, $allowedTabs, true) ? $inputTab : 'summary';

            $inputKomoditi = strtoupper(trim((string)$request->input('komoditi', 'KARET')));
            $komoditiClean = in_array($inputKomoditi, $listKomoditi, true) ? $inputKomoditi : 'KARET';

            // Regional sanitasi dengan whitelist (Akun regional dipaksa hanya regional miliknya)
            if ($isRegionalUser) {
                $regClean = [(string)$userRegId];
            } else {
                $rawReg = $request->input('regional');
                $regClean = [];
                if (is_array($rawReg)) {
                    $regClean = array_values(array_intersect($rawReg, $listRegionalMaster));
                } elseif (is_string($rawReg) && strlen(trim($rawReg)) > 0) {
                    $exploded = array_map('trim', explode(',', $rawReg));
                    $regClean = array_values(array_intersect($exploded, $listRegionalMaster));
                }
                // Jika kosong, jangan dipaksa ke default ['5'] agar user bisa memilih Semua Regional (tanpa regional tertentu)
            }

            // Kebun sanitasi (hanya izinkan string alfanumerik / nama kebun bersih)
            $rawKebun = $request->input('kebun');
            $kebunClean = [];
            if (is_array($rawKebun)) {
                $kebunClean = array_values(array_filter(array_map('trim', $rawKebun), fn($v) => !empty($v)));
            } elseif (is_string($rawKebun) && strlen(trim($rawKebun)) > 0) {
                $kebunClean = array_values(array_filter(array_map('trim', explode(',', $rawKebun)), fn($v) => !empty($v)));
            }

            session(['areal_filters' => [
                'tahun' => $tahunClean,
                'bulan' => $bulanClean,
                'mode_periode' => $modeClean,
                'tab' => $tabClean,
                'komoditi' => $komoditiClean,
                'regional' => $regClean,
                'is_explicit_reg' => !empty($regClean),
                'kebun' => $kebunClean,
            ]]);

            $targetRoute = $request->routeIs('arealproduksi') ? 'arealproduksi' : 'arealproduksi_repl';
            return redirect()->route($targetRoute);
        }

        // 2. Ambil Parameter Filter dari Session atau Request GET (Strict Whitelisting Anti-XSS)
        $savedFilters = session('areal_filters', []);

        // Tahun
        $reqTahun = $request->has('tahun') ? (int)$request->input('tahun') : ($savedFilters['tahun'] ?? $listTahun[0]);
        $tahunSelected = in_array($reqTahun, $listTahun, true) ? $reqTahun : $listTahun[0];

        // Cari bulan maksimum yang memiliki data produksi real di tahun terpilih
        $maxBulanWithData = Cache::remember("areal_max_bulan_{$tahunSelected}", 3600, function () use ($tahunSelected) {
            return DB::connection('looker')->table('vw_trend_dengan_pembanding')
                ->where('tahun', $tahunSelected)
                ->where('produksi_real', '>', 0)
                ->max('bulan');
        });
        $defaultBulan = $maxBulanWithData ?: 11;

        // Bulan
        $reqBulan = $request->has('bulan') ? (int)$request->input('bulan') : ($savedFilters['bulan'] ?? $defaultBulan);
        $bulanSelected = ($reqBulan >= 1 && $reqBulan <= 12) ? $reqBulan : $defaultBulan;

        // Mode Periode
        $reqMode = $request->input('mode_periode', $savedFilters['mode_periode'] ?? 'sd');
        $modePeriode = in_array($reqMode, $allowedModes, true) ? $reqMode : 'sd';

        // Tab
        $reqTab = $request->input('tab', $savedFilters['tab'] ?? 'summary');
        $activeTab = in_array($reqTab, $allowedTabs, true) ? $reqTab : 'summary';

        // Komoditi
        $reqKomoditi = strtoupper(trim((string)$request->input('komoditi', $savedFilters['komoditi'] ?? 'KARET')));
        $komoditiSelected = in_array($reqKomoditi, $listKomoditi, true) ? $reqKomoditi : 'KARET';

        // Regional (Strict Whitelist terhadap $listRegionalMaster / locked jika user regional)
        // Reset sisa default lama ['5'] di session jika ada
        if (!$request->has('regional') && isset($savedFilters['regional']) && $savedFilters['regional'] === ['5'] && empty($savedFilters['is_explicit_reg'])) {
            $savedFilters['regional'] = [];
            session(['areal_filters.regional' => []]);
        }

        if ($isRegionalUser) {
            $regionalSelected = [(string)$userRegId];
        } elseif ($request->has('regional')) {
            $rawReg = $request->input('regional');
            $regArr = is_array($rawReg) ? $rawReg : (is_string($rawReg) ? explode(',', $rawReg) : []);
            $regionalSelected = array_values(array_intersect(array_map('trim', $regArr), $listRegionalMaster));
        } elseif (isset($savedFilters['regional'])) {
            $regionalSelected = array_values(array_intersect($savedFilters['regional'], $listRegionalMaster));
        } else {
            $regionalSelected = []; // Default awal: tidak ada regional tertentu yang dipilih (Semua Regional)
        }

        // List Kebun per Regional terpilih (Semua kebun di regional terpilih, lintas komoditi)
        $isAllReg = empty($regionalSelected) || in_array('all', $regionalSelected);
        $cacheKeyKebunData = "areal_kebun_data_all_" . md5(implode(',', (array)$regionalSelected));
        $kebunRows = Cache::remember($cacheKeyKebunData, 3600, function () use ($isAllReg, $regionalSelected) {
            return DB::connection('looker')->table('vw_trend_kebun_dengan_pembanding')
                ->when(!$isAllReg, function ($q) use ($regionalSelected) {
                    return $q->whereIn('reg', $regionalSelected);
                })
                ->select('kebun', 'komoditi')
                ->distinct()
                ->orderBy('kebun')
                ->get();
        });

        // List seluruh kebun unik di regional
        $listKebun = $kebunRows->pluck('kebun')->unique()->values()->toArray();

        // Pemetaan kebun -> array komoditi yang dihasilkan
        $kebunKomoditiMap = [];
        foreach ($kebunRows as $row) {
            $kebunKomoditiMap[$row->kebun][] = strtoupper($row->komoditi);
        }

        // Kebun Selected (Sanitasi ketat terhadap $listKebun yang sah)
        if ($request->has('kebun')) {
            $rawKebun = $request->input('kebun');
            $kebunArr = is_array($rawKebun) ? $rawKebun : (is_string($rawKebun) ? explode(',', $rawKebun) : []);
            $kebunSelected = array_values(array_intersect(array_map('trim', $kebunArr), $listKebun));
        } elseif (isset($savedFilters['kebun'])) {
            $kebunSelected = array_values(array_intersect($savedFilters['kebun'], $listKebun));
        } else {
            $kebunSelected = [];
        }

        // Filter kebun khusus untuk Tab 3 vs Tab 4 agar tidak saling mempengaruhi
        $kebunTrend = ($activeTab === 'trend_produksi') ? $kebunSelected : [];
        $kebunRincian = ($activeTab === 'rincian_kebun') ? $kebunSelected : [];

        // 3. Fetch Data untuk Masing-Masing Tab
        // Tab Summary selalu menggunakan $listRegionalMaster karena tidak memiliki filter regional (agregat nasional seluruh regional)
        $summaryData = $this->getSummaryData($tahunSelected, $bulanSelected, $listKomoditi, $listRegionalMaster, $modePeriode);
        $regionalData = $this->getRegionalData($tahunSelected, $bulanSelected, $regionalSelected, $komoditiSelected, $modePeriode);
        $trendData = $this->getTrendData($tahunSelected, $regionalSelected, $kebunTrend, $listKomoditi);
        $rincianData = $this->getRincianData($tahunSelected, $bulanSelected, $regionalSelected, $kebunRincian, $komoditiSelected, $modePeriode);

        return view('pages.areal_produksi.index', compact(
            'listTahun',
            'listBulan',
            'listRegional',
            'listKomoditi',
            'listKebun',
            'kebunKomoditiMap',
            'tahunSelected',
            'bulanSelected',
            'modePeriode',
            'regionalSelected',
            'komoditiSelected',
            'kebunSelected',
            'activeTab',
            'isRegionalUser',
            'userRegId',
            'summaryData',
            'regionalData',
            'trendData',
            'rincianData'
        ));
    }

    /**
     * Data untuk TAB 1: SUMMARY (Areal, Produksi & Produktivitas)
     */
    private function getSummaryData($tahun, $bulan, $commodities, $regionals, $modePeriode = 'sd')
    {
        $bulanOp = ($modePeriode === 'single' || $modePeriode === 'hanya') ? '=' : '<=';

        // 1. Luas Areal per Komoditi & Regional dari vw_luas_areal_distinct_kebun (Cached 1 jam)
        $luasRegional = Cache::remember("areal_luas_reg_{$tahun}", 3600, function () use ($tahun) {
            return DB::connection('looker')->table('vw_luas_areal_distinct_kebun')
                ->where('tahun', $tahun)
                ->groupBy('komoditi', 'reg')
                ->select(
                    'komoditi',
                    'reg',
                    DB::raw('SUM(luas_real) as luas_real'),
                    DB::raw('SUM(luas_rkap) as luas_rkap'),
                    DB::raw('SUM(luas_thn_lalu) as luas_thn_lalu')
                )
                ->get();
        });

        // Hitung luas per komoditi dari $luasRegional (tanpa query duplikat)
        $luasKomoditi = $luasRegional->groupBy('komoditi')->map(function ($items, $comm) {
            return (object)[
                'komoditi' => $comm,
                'luas_real' => $items->sum('luas_real'),
                'luas_rkap' => $items->sum('luas_rkap'),
                'luas_thn_lalu' => $items->sum('luas_thn_lalu'),
            ];
        });

        // 2. Produksi (bulan <= $bulan atau bulan = $bulan) per Komoditi & Regional dari vw_trend_dengan_pembanding (Cached 30 menit)
        $cacheKeyTrend = "areal_trend_sum_{$tahun}_{$bulan}_{$modePeriode}";
        $trendData = Cache::remember($cacheKeyTrend, 1800, function () use ($tahun, $bulan, $bulanOp) {
            return DB::connection('looker')->table('vw_trend_dengan_pembanding')
                ->where('tahun', $tahun)
                ->where('bulan', $bulanOp, $bulan)
                ->groupBy('komoditi', 'reg')
                ->select(
                    'komoditi',
                    'reg',
                    DB::raw('SUM(produksi_real) as prod_real'),
                    DB::raw('SUM(produksi_rkap) as prod_rkap'),
                    DB::raw('SUM(produksi_thn_lalu) as prod_thn_lalu')
                )
                ->get();
        });

        // KPI Summary Cards per Komoditi
        $cards = [];
        $chartData = [
            'categories' => $commodities,
            'luas' => ['thn_lalu' => [], 'rkap' => [], 'real' => []],
            'produksi' => ['thn_lalu' => [], 'rkap' => [], 'real' => []],
            'protas' => ['thn_lalu' => [], 'rkap' => [], 'real' => []]
        ];

        foreach ($commodities as $comm) {
            $lRow = $luasKomoditi[$comm] ?? null;
            $luasReal = $lRow ? (float)$lRow->luas_real : 0;
            $luasRkap = $lRow ? (float)$lRow->luas_rkap : 0;
            $luasThnLalu = $lRow ? (float)$lRow->luas_thn_lalu : 0;
            $luasPctRkap = $luasRkap > 0 ? round(($luasReal / $luasRkap) * 100) : 100;

            $commRows = $trendData->where('komoditi', $comm);
            $prodRealKg = $commRows->sum('prod_real');
            $prodRkapKg = $commRows->sum('prod_rkap');
            $prodThnLaluKg = $commRows->sum('prod_thn_lalu');

            $prodRealTon = $prodRealKg / 1000;
            $prodRkapTon = $prodRkapKg / 1000;
            $prodThnLaluTon = $prodThnLaluKg / 1000;
            $prodPctRkap = $prodRkapTon > 0 ? round(($prodRealTon / $prodRkapTon) * 100) : 0;

            $protasReal = $luasReal > 0 ? ($prodRealKg / $luasReal) : 0;
            $protasRkap = $luasRkap > 0 ? ($prodRkapKg / $luasRkap) : 0;
            $protasThnLalu = $luasThnLalu > 0 ? ($prodThnLaluKg / $luasThnLalu) : 0;
            $protasPctRkap = $protasRkap > 0 ? round(($protasReal / $protasRkap) * 100) : 0;

            $cards[$comm] = [
                'luas_real' => $luasReal,
                'luas_rkap' => $luasRkap,
                'luas_pct_rkap' => $luasPctRkap,
                'prod_real_ton' => $prodRealTon,
                'prod_rkap_ton' => $prodRkapTon,
                'prod_pct_rkap' => $prodPctRkap,
                'protas_real' => $protasReal,
                'protas_rkap' => $protasRkap,
                'protas_pct_rkap' => $protasPctRkap,
            ];

            // Chart Series
            $chartData['luas']['thn_lalu'][] = round($luasThnLalu, 2);
            $chartData['luas']['rkap'][] = round($luasRkap, 2);
            $chartData['luas']['real'][] = round($luasReal, 2);

            $chartData['produksi']['thn_lalu'][] = round($prodThnLaluTon, 2);
            $chartData['produksi']['rkap'][] = round($prodRkapTon, 2);
            $chartData['produksi']['real'][] = round($prodRealTon, 2);

            $chartData['protas']['thn_lalu'][] = round($protasThnLalu, 2);
            $chartData['protas']['rkap'][] = round($protasRkap, 2);
            $chartData['protas']['real'][] = round($protasReal, 2);
        }

        // Tabel Perbandingan Produksi & Protas Per Regional
        $tabelRegional = [];
        foreach ($commodities as $comm) {
            $tabelRegional[$comm] = [
                'rows' => [],
                'total' => [
                    'luas_real' => 0,
                    'prod_thn_lalu_ton' => 0,
                    'prod_rkap_ton' => 0,
                    'prod_real_ton' => 0,
                    'pct_tl' => 0,
                    'pct_rkap' => 0,
                    'protas_thn_lalu' => 0,
                    'protas_rkap' => 0,
                    'protas_real' => 0,
                    'protas_pct_tl' => 0,
                    'protas_pct_rkap' => 0,
                ]
            ];

            $totalLuasThnLalu = 0;
            $totalLuasRkap = 0;
            $totalProdThnLaluKg = 0;
            $totalProdRkapKg = 0;
            $totalProdRealKg = 0;

            // Get all regionals with data for this commodity
            $commTrendRows = $trendData->where('komoditi', $comm);
            $activeRegs = $commTrendRows->pluck('reg')->unique()->sort()->values();

            foreach ($activeRegs as $reg) {
                $tRow = $commTrendRows->firstWhere('reg', $reg);
                $lRow = $luasRegional->where('komoditi', $comm)->firstWhere('reg', $reg);

                $lReal = $lRow ? (float)$lRow->luas_real : 0;
                $lRkap = $lRow ? (float)$lRow->luas_rkap : 0;
                $lThnLalu = $lRow ? (float)$lRow->luas_thn_lalu : 0;

                $pRealKg = $tRow ? (float)$tRow->prod_real : 0;
                $pRkapKg = $tRow ? (float)$tRow->prod_rkap : 0;
                $pThnLaluKg = $tRow ? (float)$tRow->prod_thn_lalu : 0;

                $pRealTon = $pRealKg / 1000;
                $pRkapTon = $pRkapKg / 1000;
                $pThnLaluTon = $pThnLaluKg / 1000;

                $pctTL = $pThnLaluTon > 0 ? round(($pRealTon / $pThnLaluTon) * 100) : 0;
                $pctRkap = $pRkapTon > 0 ? round(($pRealTon / $pRkapTon) * 100) : 0;

                $protasTL = $lThnLalu > 0 ? ($pThnLaluKg / $lThnLalu) : 0;
                $protasRkap = $lRkap > 0 ? ($pRkapKg / $lRkap) : 0;
                $protasReal = $lReal > 0 ? ($pRealKg / $lReal) : 0;

                $protasPctTL = $protasTL > 0 ? round(($protasReal / $protasTL) * 100) : 0;
                $protasPctRkap = $protasRkap > 0 ? round(($protasReal / $protasRkap) * 100) : 0;

                $tabelRegional[$comm]['rows'][] = [
                    'reg' => $reg,
                    'luas_real' => $lReal,
                    'prod_thn_lalu_ton' => $pThnLaluTon,
                    'prod_rkap_ton' => $pRkapTon,
                    'prod_real_ton' => $pRealTon,
                    'pct_tl' => $pctTL,
                    'pct_rkap' => $pctRkap,
                    'protas_thn_lalu' => $protasTL,
                    'protas_rkap' => $protasRkap,
                    'protas_real' => $protasReal,
                    'protas_pct_tl' => $protasPctTL,
                    'protas_pct_rkap' => $protasPctRkap,
                ];

                $tabelRegional[$comm]['total']['luas_real'] += $lReal;
                $tabelRegional[$comm]['total']['prod_thn_lalu_ton'] += $pThnLaluTon;
                $tabelRegional[$comm]['total']['prod_rkap_ton'] += $pRkapTon;
                $tabelRegional[$comm]['total']['prod_real_ton'] += $pRealTon;

                $totalLuasThnLalu += $lThnLalu;
                $totalLuasRkap += $lRkap;
                $totalProdThnLaluKg += $pThnLaluKg;
                $totalProdRkapKg += $pRkapKg;
                $totalProdRealKg += $pRealKg;
            }

            $tot = &$tabelRegional[$comm]['total'];
            $tot['pct_tl'] = $tot['prod_thn_lalu_ton'] > 0 ? round(($tot['prod_real_ton'] / $tot['prod_thn_lalu_ton']) * 100) : 0;
            $tot['pct_rkap'] = $tot['prod_rkap_ton'] > 0 ? round(($tot['prod_real_ton'] / $tot['prod_rkap_ton']) * 100) : 0;
            $tot['protas_thn_lalu'] = $totalLuasThnLalu > 0 ? ($totalProdThnLaluKg / $totalLuasThnLalu) : 0;
            $tot['protas_rkap'] = $totalLuasRkap > 0 ? ($totalProdRkapKg / $totalLuasRkap) : 0;
            $tot['protas_real'] = $tot['luas_real'] > 0 ? ($totalProdRealKg / $tot['luas_real']) : 0;
            $tot['protas_pct_tl'] = $tot['protas_thn_lalu'] > 0 ? round(($tot['protas_real'] / $tot['protas_thn_lalu']) * 100) : 0;
            $tot['protas_pct_rkap'] = $tot['protas_rkap'] > 0 ? round(($tot['protas_real'] / $tot['protas_rkap']) * 100) : 0;
        }

        return [
            'cards' => $cards,
            'chartData' => $chartData,
            'tabelRegional' => $tabelRegional,
        ];
    }

    /**
     * Data untuk TAB 2: PRODUKTIVITAS REGIONAL
     */
    private function getRegionalData($tahun, $bulan, $reg, $komoditi, $modePeriode = 'sd')
    {
        $bulanOp = ($modePeriode === 'single' || $modePeriode === 'hanya') ? '=' : '<=';
        $regs = is_array($reg) ? $reg : (empty($reg) || $reg === 'all' ? [] : [$reg]);
        $isAllReg = empty($regs) || in_array('all', $regs);
        $komoditi = $komoditi ?: 'KARET';

        // 1. Data Kebun untuk Donut, Combo Chart, dan Bubble Chart (Cached 30 menit)
        $cacheKeyReg = "areal_reg_" . md5($tahun . '_' . $bulan . '_' . implode(',', (array)$regs) . '_' . $komoditi . '_' . $modePeriode);
        $kebunQuery = Cache::remember($cacheKeyReg, 1800, function () use ($tahun, $komoditi, $isAllReg, $regs, $bulanOp, $bulan) {
            return DB::connection('looker')->table('vw_trend_kebun_dengan_pembanding')
                ->where('tahun', $tahun)
                ->where('komoditi', $komoditi)
                ->when(!$isAllReg, function ($q) use ($regs) {
                    return $q->whereIn('reg', $regs);
                })
                ->where('bulan', $bulanOp, $bulan)
                ->groupBy('kebun')
                ->select(
                    'kebun',
                    DB::raw('MAX(luas_real) as luas_real'),
                    DB::raw('MAX(luas_rkap) as luas_rkap'),
                    DB::raw('MAX(luas_thn_lalu) as luas_thn_lalu'),
                    DB::raw('SUM(produksi_real) as prod_real_kg'),
                    DB::raw('SUM(produksi_rkap) as prod_rkap_kg'),
                    DB::raw('SUM(produksi_thn_lalu) as prod_thn_lalu_kg')
                )
                ->get();
        });

        $kebuns = [];
        $totalLuasReal = 0;
        $totalLuasRkap = 0;
        $totalLuasThnLalu = 0;
        $totalProdRealKg = 0;
        $totalProdRkapKg = 0;
        $totalProdThnLaluKg = 0;

        foreach ($kebunQuery as $row) {
            $lReal = (float) $row->luas_real;
            $lRkap = (float) $row->luas_rkap;
            $lTL = (float) $row->luas_thn_lalu;

            $pRealKg = (float) $row->prod_real_kg;
            $pRkapKg = (float) $row->prod_rkap_kg;
            $pTLKg = (float) $row->prod_thn_lalu_kg;

            $protasReal = $lReal > 0 ? ($pRealKg / $lReal) : 0;
            $protasRkap = $lRkap > 0 ? ($pRkapKg / $lRkap) : 0;
            $protasTL = $lTL > 0 ? ($pTLKg / $lTL) : 0;

            $pctRkap = $protasRkap > 0 ? round(($protasReal / $protasRkap) * 100, 1) : 0;
            $pctTL = $protasTL > 0 ? round(($protasReal / $protasTL) * 100, 1) : 0;

            $kebuns[] = [
                'kebun' => $row->kebun,
                'luas_real' => $lReal,
                'luas_rkap' => $lRkap,
                'prod_real_ton' => $pRealKg / 1000,
                'prod_real_kg' => $pRealKg,
                'protas_real' => round($protasReal, 2),
                'protas_rkap' => round($protasRkap, 2),
                'protas_tl' => round($protasTL, 2),
                'pct_rkap' => $pctRkap,
                'pct_tl' => $pctTL,
            ];

            $totalLuasReal += $lReal;
            $totalLuasRkap += $lRkap;
            $totalLuasThnLalu += $lTL;
            $totalProdRealKg += $pRealKg;
            $totalProdRkapKg += $pRkapKg;
            $totalProdThnLaluKg += $pTLKg;
        }

        // Urutkan kebun berdasarkan protas realisasi descending untuk combo chart
        usort($kebuns, function ($a, $b) {
            return $b['protas_real'] <=> $a['protas_real'];
        });

        // 2. Matrix Top Cards
        $totalProdRealTon = $totalProdRealKg / 1000;
        $totalProdRkapTon = $totalProdRkapKg / 1000;
        $totalProdThnLaluTon = $totalProdThnLaluKg / 1000;

        $totalProtasReal = $totalLuasReal > 0 ? ($totalProdRealKg / $totalLuasReal) : 0;
        $totalProtasRkap = $totalLuasRkap > 0 ? ($totalProdRkapKg / $totalLuasRkap) : 0;
        $totalProtasThnLalu = $totalLuasThnLalu > 0 ? ($totalProdThnLaluKg / $totalLuasThnLalu) : 0;

        $matrix = [
            'luas' => [
                'thn_lalu' => $totalLuasThnLalu,
                'rkap' => $totalLuasRkap,
                'real' => $totalLuasReal,
                'pct_tl' => $totalLuasThnLalu > 0 ? round(($totalLuasReal / $totalLuasThnLalu) * 100) : 0,
                'pct_rkap' => $totalLuasRkap > 0 ? round(($totalLuasReal / $totalLuasRkap) * 100) : 0,
            ],
            'produksi' => [
                'thn_lalu' => $totalProdThnLaluTon,
                'rkap' => $totalProdRkapTon,
                'real' => $totalProdRealTon,
                'pct_tl' => $totalProdThnLaluTon > 0 ? round(($totalProdRealTon / $totalProdThnLaluTon) * 100) : 0,
                'pct_rkap' => $totalProdRkapTon > 0 ? round(($totalProdRealTon / $totalProdRkapTon) * 100) : 0,
            ],
            'protas' => [
                'thn_lalu' => $totalProtasThnLalu,
                'rkap' => $totalProtasRkap,
                'real' => $totalProtasReal,
                'pct_tl' => $totalProtasThnLalu > 0 ? round(($totalProtasReal / $totalProtasThnLalu) * 100) : 0,
                'pct_rkap' => $totalProtasRkap > 0 ? round(($totalProtasReal / $totalProtasRkap) * 100) : 0,
            ]
        ];

        // 3. Donut Chart Series
        $donutLabels = [];
        $donutSeries = [];
        foreach ($kebuns as $k) {
            $donutLabels[] = $k['kebun'];
            $donutSeries[] = round($k['luas_real'], 2);
        }

        // 4. Combo Chart Series (sorted kebun)
        $comboCategories = [];
        $comboBarSeries = [];
        $comboLineTL = [];
        $comboLineRKAP = [];
        foreach ($kebuns as $k) {
            $comboCategories[] = $k['kebun'];
            $comboBarSeries[] = $k['protas_real'];
            $comboLineTL[] = $k['pct_tl'];
            $comboLineRKAP[] = $k['pct_rkap'];
        }

        // 5. Bubble / Scatter Chart Data [Luas, Produksi Kg, Kebun Name]
        $bubbleData = [];
        foreach ($kebuns as $k) {
            $bubbleData[] = [
                'x' => $k['luas_real'],
                'y' => round($k['prod_real_kg']),
                'name' => $k['kebun'],
                'protas' => $k['protas_real'],
                'pct_rkap' => $k['pct_rkap']
            ];
        }

        return [
            'matrix' => $matrix,
            'donut' => ['labels' => $donutLabels, 'series' => $donutSeries],
            'combo' => [
                'categories' => $comboCategories,
                'bar' => $comboBarSeries,
                'line_tl' => $comboLineTL,
                'line_rkap' => $comboLineRKAP
            ],
            'bubble' => $bubbleData
        ];
    }

    /**
     * Data untuk TAB 3: TREND PRODUKSI (Jan - Des untuk 4 Komoditi)
     */
    private function getTrendData($tahun, $reg, $kebun, $commodities)
    {
        $regs = is_array($reg) ? $reg : (empty($reg) || $reg === 'all' ? [] : [$reg]);
        $isAllReg = empty($regs) || in_array('all', $regs);

        $kebuns = is_array($kebun) ? $kebun : (empty($kebun) || $kebun === 'all' ? [] : [$kebun]);
        $isAllKebun = empty($kebuns) || in_array('all', $kebuns);

        $table = (!$isAllKebun || !$isAllReg) ? 'vw_trend_kebun_dengan_pembanding' : 'vw_trend_dengan_pembanding';
        $cacheKeyTrend = "areal_trend_data_" . md5($table . '_' . $tahun . '_' . implode(',', (array)$regs) . '_' . implode(',', (array)$kebuns));
        $query = Cache::remember($cacheKeyTrend, 1800, function () use ($table, $tahun, $isAllReg, $regs, $isAllKebun, $kebuns) {
            return DB::connection('looker')->table($table)
                ->where('tahun', $tahun)
                ->when(!$isAllReg, function ($q) use ($regs) {
                    return $q->whereIn('reg', $regs);
                })
                ->when(!$isAllKebun, function ($q) use ($kebuns) {
                    return $q->whereIn('kebun', $kebuns);
                })
                ->groupBy('komoditi', 'bulan')
                ->select(
                    'komoditi',
                    'bulan',
                    DB::raw('SUM(produksi_real) as prod_real'),
                    DB::raw('SUM(produksi_rkap) as prod_rkap'),
                    DB::raw('SUM(produksi_thn_lalu) as prod_thn_lalu')
                )
                ->get();
        });

        $trends = [];
        foreach ($commodities as $comm) {
            $commData = $query->where('komoditi', $comm)->keyBy('bulan');
            $seriesReal = [];
            $seriesRkap = [];
            $seriesTL = [];

            for ($m = 1; $m <= 12; $m++) {
                $row = $commData[$m] ?? null;
                $seriesReal[] = $row ? round((float)$row->prod_real) : 0;
                $seriesRkap[] = $row ? round((float)$row->prod_rkap) : 0;
                $seriesTL[] = $row ? round((float)$row->prod_thn_lalu) : 0;
            }

            $trends[$comm] = [
                'real' => $seriesReal,
                'rkap' => $seriesRkap,
                'thn_lalu' => $seriesTL,
            ];
        }

        return $trends;
    }

    /**
     * Data untuk TAB 4: RINCIAN PER KEBUN
     */
    private function getRincianData($tahun, $bulan, $reg, $kebun, $komoditi, $modePeriode = 'sd')
    {
        $bulanOp = ($modePeriode === 'single' || $modePeriode === 'hanya') ? '=' : '<=';
        $regs = is_array($reg) ? $reg : (empty($reg) || $reg === 'all' ? [] : [$reg]);
        $isAllReg = empty($regs) || in_array('all', $regs);

        $kebuns = is_array($kebun) ? $kebun : (empty($kebun) || $kebun === 'all' ? [] : [$kebun]);
        $isAllKebun = empty($kebuns) || in_array('all', $kebuns);
        $komoditi = $komoditi ?: 'KARET';

        $cacheKeyRincian = "areal_rincian_" . md5($tahun . '_' . $bulan . '_' . implode(',', (array)$regs) . '_' . implode(',', (array)$kebuns) . '_' . $komoditi . '_' . $modePeriode);
        $query = Cache::remember($cacheKeyRincian, 1800, function () use ($tahun, $komoditi, $isAllReg, $regs, $isAllKebun, $kebuns, $bulanOp, $bulan) {
            return DB::connection('looker')->table('vw_trend_kebun_dengan_pembanding')
                ->where('tahun', $tahun)
                ->when($komoditi !== 'all', function ($q) use ($komoditi) {
                    return $q->where('komoditi', $komoditi);
                })
                ->when(!$isAllReg, function ($q) use ($regs) {
                    return $q->whereIn('reg', $regs);
                })
                ->when(!$isAllKebun, function ($q) use ($kebuns) {
                    return $q->whereIn('kebun', $kebuns);
                })
                ->where('bulan', $bulanOp, $bulan)
                ->groupBy('reg', 'kebun')
                ->select(
                    'reg',
                    'kebun',
                    DB::raw('MAX(luas_real) as luas_real'),
                    DB::raw('MAX(luas_rkap) as luas_rkap'),
                    DB::raw('MAX(luas_thn_lalu) as luas_thn_lalu'),
                    DB::raw('SUM(produksi_real) as prod_real_kg'),
                    DB::raw('SUM(produksi_rkap) as prod_rkap_kg'),
                    DB::raw('SUM(produksi_thn_lalu) as prod_thn_lalu_kg')
                )
                ->orderBy('kebun')
                ->get();
        });

        $rows = [];
        $totalLuasReal = 0;
        $totalLuasRkap = 0;
        $totalLuasTL = 0;
        $totalProdRealKg = 0;
        $totalProdRkapKg = 0;
        $totalProdTLKg = 0;

        foreach ($query as $r) {
            $lReal = (float) $r->luas_real;
            $lRkap = (float) $r->luas_rkap;
            $lTL = (float) $r->luas_thn_lalu;

            $pRealKg = (float) $r->prod_real_kg;
            $pRkapKg = (float) $r->prod_rkap_kg;
            $pTLKg = (float) $r->prod_thn_lalu_kg;

            $pRealTon = $pRealKg / 1000;
            $pRkapTon = $pRkapKg / 1000;
            $pTLTon = $pTLKg / 1000;

            $pctTL = $pTLTon > 0 ? round(($pRealTon / $pTLTon) * 100) : 0;
            $pctRkap = $pRkapTon > 0 ? round(($pRealTon / $pRkapTon) * 100) : 0;

            $rawProtasTL = $lTL > 0 ? ($pTLKg / $lTL) : 0;
            $rawProtasRkap = $lRkap > 0 ? ($pRkapKg / $lRkap) : 0;
            $rawProtasReal = $lReal > 0 ? ($pRealKg / $lReal) : 0;

            $protasTL = $lTL > 0 ? round($rawProtasTL, 2) : 0;
            $protasRkap = $lRkap > 0 ? round($rawProtasRkap, 2) : 0;
            $protasReal = $lReal > 0 ? round($rawProtasReal, 2) : 0;

            $protasPctTL = $rawProtasTL > 0 ? round(($rawProtasReal / $rawProtasTL) * 100) : 0;
            $protasPctRkap = $rawProtasRkap > 0 ? round(($rawProtasReal / $rawProtasRkap) * 100) : 0;

            $rows[] = [
                'reg' => $r->reg,
                'kebun' => $r->kebun,
                'luas_real' => $lReal,
                'prod_tl_ton' => $pTLTon,
                'prod_rkap_ton' => $pRkapTon,
                'prod_real_ton' => $pRealTon,
                'pct_tl' => $pctTL,
                'pct_rkap' => $pctRkap,
                'protas_tl' => $protasTL,
                'protas_rkap' => $protasRkap,
                'protas_real' => $protasReal,
                'protas_pct_tl' => $protasPctTL,
                'protas_pct_rkap' => $protasPctRkap,
            ];

            $totalLuasReal += $lReal;
            $totalLuasRkap += $lRkap;
            $totalLuasTL += $lTL;
            $totalProdRealKg += $pRealKg;
            $totalProdRkapKg += $pRkapKg;
            $totalProdTLKg += $pTLKg;
        }

        $totalProdRealTon = $totalProdRealKg / 1000;
        $totalProdRkapTon = $totalProdRkapKg / 1000;
        $totalProdTLTon = $totalProdTLKg / 1000;
        $totalProtasReal = $totalLuasReal > 0 ? ($totalProdRealKg / $totalLuasReal) : 0;
        $totalProtasRkap = $totalLuasRkap > 0 ? ($totalProdRkapKg / $totalLuasRkap) : 0;
        $totalProtasTL = $totalLuasTL > 0 ? ($totalProdTLKg / $totalLuasTL) : 0;

        $topCards = [
            'luas' => [
                'real' => $totalLuasReal,
                'rkap' => $totalLuasRkap,
                'thn_lalu' => $totalLuasTL,
                'pct' => $totalLuasRkap > 0 ? round(($totalLuasReal / $totalLuasRkap) * 100) : 100,
                'pct_tl' => $totalLuasTL > 0 ? round(($totalLuasReal / $totalLuasTL) * 100) : 0,
            ],
            'produksi' => [
                'real' => $totalProdRealTon,
                'rkap' => $totalProdRkapTon,
                'thn_lalu' => $totalProdTLTon,
                'pct' => $totalProdRkapTon > 0 ? round(($totalProdRealTon / $totalProdRkapTon) * 100) : 0,
                'pct_tl' => $totalProdTLTon > 0 ? round(($totalProdRealTon / $totalProdTLTon) * 100) : 0,
            ],
            'protas' => [
                'real' => $totalProtasReal,
                'rkap' => $totalProtasRkap,
                'thn_lalu' => $totalProtasTL,
                'pct' => $totalProtasRkap > 0 ? round(($totalProtasReal / $totalProtasRkap) * 100) : 0,
                'pct_tl' => $totalProtasTL > 0 ? round(($totalProtasReal / $totalProtasTL) * 100) : 0,
            ]
        ];

        return [
            'topCards' => $topCards,
            'rows' => $rows,
        ];
    }
}

