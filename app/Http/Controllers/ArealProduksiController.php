<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArealProduksiController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = Carbon::now()->year;
        
        // Default: Bulan lalu
        $defaultDate = Carbon::now()->subMonth();
        
        $tahunSelected = (int) $request->input('tahun', $defaultDate->year);
        $bulanSelected = (int) $request->input('bulan', $defaultDate->month);

        // List pilihan filter tahun (5 tahun terakhir)
        $listTahun = range($currentYear, $currentYear - 4);
        
        // List pilihan filter bulan
        $listBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Tanggal akhir bulan yang dipilih
        $dateObj = Carbon::createFromDate($tahunSelected, $bulanSelected, 1)->endOfMonth();
        $tanggalAkhir = $dateObj->format('Y-m-d');
        $tahun = $dateObj->year;
        
        // Tanggal akhir bulan yang sama di tahun lalu
        $tanggalAkhirTahunLalu = Carbon::createFromDate($tahunSelected - 1, $bulanSelected, 1)->endOfMonth()->format('Y-m-d');
        $tahunLalu = $tahunSelected - 1;

        $regionals = [2, 3, 5, 7, 8];
        $data = [
            'tanggal_akhir' => $tanggalAkhir,
            'karet' => [],
            'teh' => [],
            'karet_total' => $this->initEmptyRow(),
            'teh_total' => $this->initEmptyRow(),
        ];

        // Init regional data
        foreach ($regionals as $reg) {
            $data['karet'][$reg] = $this->initEmptyRow();
            $data['teh'][$reg] = $this->initEmptyRow();
        }

        // ==========================================
        // KARET
        // ==========================================
        
        // 1. Luas Karet Real & RKAP (Tahun Ini)
        $karetLuasRealSub = DB::connection('looker')
            ->table('tbl_prod_karet')
            ->select('kebun', DB::raw('MAX(luas_tm) as luas_real_max'), DB::raw('MAX(luas_tm_rkap) as luas_rkap_max'))
            ->whereYear('tanggal', $tahun)
            ->where('tanggal', '<=', $tanggalAkhir)
            ->groupBy('kebun');
            
        $karetLuasReal = DB::connection('looker')
            ->table(DB::raw("({$karetLuasRealSub->toSql()}) as sub"))
            ->mergeBindings($karetLuasRealSub)
            ->join('regional', 'sub.kebun', '=', 'regional.unit')
            ->select('regional.regional', DB::raw('SUM(sub.luas_real_max) as total_luas_real'), DB::raw('SUM(sub.luas_rkap_max) as total_luas_rkap'))
            ->groupBy('regional.regional')
            ->get();

        // 2. Luas Karet Thn Lalu
        $karetLuasThnLaluSub = DB::connection('looker')
            ->table('tbl_prod_karet')
            ->select('kebun', DB::raw('MAX(luas_tm) as luas_max'))
            ->whereYear('tanggal', $tahunLalu)
            ->where('tanggal', '<=', $tanggalAkhirTahunLalu)
            ->groupBy('kebun');
            
        $karetLuasThnLalu = DB::connection('looker')
            ->table(DB::raw("({$karetLuasThnLaluSub->toSql()}) as sub"))
            ->mergeBindings($karetLuasThnLaluSub)
            ->join('regional', 'sub.kebun', '=', 'regional.unit')
            ->select('regional.regional', DB::raw('SUM(sub.luas_max) as total_luas'))
            ->groupBy('regional.regional')
            ->get();

        // 3. Produksi Karet Real & RKAP (Tahun Ini)
        $karetProdReal = DB::connection('looker')
            ->table('tbl_prod_karet')
            ->join('regional', 'tbl_prod_karet.kebun', '=', 'regional.unit')
            ->select('regional.regional', DB::raw('SUM(prd_jml) as total_prod_real'), DB::raw('SUM(prd_tm_rkap) as total_prod_rkap'))
            ->whereYear('tanggal', $tahun)
            ->where('tanggal', '<=', $tanggalAkhir)
            ->groupBy('regional.regional')
            ->get();

        // 4. Produksi Karet Thn Lalu
        $karetProdThnLalu = DB::connection('looker')
            ->table('tbl_prod_karet')
            ->join('regional', 'tbl_prod_karet.kebun', '=', 'regional.unit')
            ->select('regional.regional', DB::raw('SUM(prd_jml) as total_prod'))
            ->whereYear('tanggal', $tahunLalu)
            ->where('tanggal', '<=', $tanggalAkhirTahunLalu)
            ->groupBy('regional.regional')
            ->get();

        // Mapping Karet Data
        foreach ($karetLuasReal as $row) { 
            if (isset($data['karet'][$row->regional])) {
                $data['karet'][$row->regional]['luas']['real'] = $row->total_luas_real; 
                $data['karet'][$row->regional]['luas']['rkap'] = $row->total_luas_rkap; 
            }
        }
        foreach ($karetLuasThnLalu as $row) { if (isset($data['karet'][$row->regional])) $data['karet'][$row->regional]['luas']['thn_lalu'] = $row->total_luas; }
        foreach ($karetProdReal as $row) { 
            if (isset($data['karet'][$row->regional])) {
                $data['karet'][$row->regional]['produksi']['real'] = $row->total_prod_real; 
                $data['karet'][$row->regional]['produksi']['rkap'] = $row->total_prod_rkap; 
            }
        }
        foreach ($karetProdThnLalu as $row) { if (isset($data['karet'][$row->regional])) $data['karet'][$row->regional]['produksi']['thn_lalu'] = $row->total_prod; }

        // ==========================================
        // TEH
        // ==========================================
        
        // 1. Luas Teh Real & RKAP (Tahun Ini)
        $tehLuasRealSub = DB::connection('looker')
            ->table('tbl_prod_teh')
            ->select('kebun', DB::raw('MAX(luas_tm_real) as luas_real_max'), DB::raw('MAX(luas_tm_rkap) as luas_rkap_max'))
            ->whereYear('tanggal', $tahun)
            ->where('tanggal', '<=', $tanggalAkhir)
            ->groupBy('kebun');
            
        $tehLuasReal = DB::connection('looker')
            ->table(DB::raw("({$tehLuasRealSub->toSql()}) as sub"))
            ->mergeBindings($tehLuasRealSub)
            ->join('regional', 'sub.kebun', '=', 'regional.unit')
            ->select('regional.regional', DB::raw('SUM(sub.luas_real_max) as total_luas_real'), DB::raw('SUM(sub.luas_rkap_max) as total_luas_rkap'))
            ->groupBy('regional.regional')
            ->get();

        // 2. Luas Teh Thn Lalu
        $tehLuasThnLaluSub = DB::connection('looker')
            ->table('tbl_prod_teh')
            ->select('kebun', DB::raw('MAX(luas_tm_real) as luas_real_max'))
            ->whereYear('tanggal', $tahunLalu)
            ->where('tanggal', '<=', $tanggalAkhirTahunLalu)
            ->groupBy('kebun');
            
        $tehLuasThnLalu = DB::connection('looker')
            ->table(DB::raw("({$tehLuasThnLaluSub->toSql()}) as sub"))
            ->mergeBindings($tehLuasThnLaluSub)
            ->join('regional', 'sub.kebun', '=', 'regional.unit')
            ->select('regional.regional', DB::raw('SUM(sub.luas_real_max) as total_luas'))
            ->groupBy('regional.regional')
            ->get();

        // 3. Produksi Teh Real & RKAP (Tahun Ini)
        $tehProdReal = DB::connection('looker')
            ->table('tbl_prod_teh')
            ->join('regional', 'tbl_prod_teh.kebun', '=', 'regional.unit')
            ->select('regional.regional', DB::raw('SUM(prod_kering_real) as total_prod_real'), DB::raw('SUM(prod_kering_rkap) as total_prod_rkap'))
            ->whereYear('tanggal', $tahun)
            ->where('tanggal', '<=', $tanggalAkhir)
            ->groupBy('regional.regional')
            ->get();

        // 4. Produksi Teh Thn Lalu
        $tehProdThnLalu = DB::connection('looker')
            ->table('tbl_prod_teh')
            ->join('regional', 'tbl_prod_teh.kebun', '=', 'regional.unit')
            ->select('regional.regional', DB::raw('SUM(prod_kering_real) as total_prod'))
            ->whereYear('tanggal', $tahunLalu)
            ->where('tanggal', '<=', $tanggalAkhirTahunLalu)
            ->groupBy('regional.regional')
            ->get();

        // Mapping Teh Data
        foreach ($tehLuasReal as $row) { 
            if (isset($data['teh'][$row->regional])) {
                $data['teh'][$row->regional]['luas']['real'] = $row->total_luas_real; 
                $data['teh'][$row->regional]['luas']['rkap'] = $row->total_luas_rkap; 
            }
        }
        foreach ($tehLuasThnLalu as $row) { if (isset($data['teh'][$row->regional])) $data['teh'][$row->regional]['luas']['thn_lalu'] = $row->total_luas; }
        foreach ($tehProdReal as $row) { 
            if (isset($data['teh'][$row->regional])) {
                $data['teh'][$row->regional]['produksi']['real'] = $row->total_prod_real; 
                $data['teh'][$row->regional]['produksi']['rkap'] = $row->total_prod_rkap; 
            }
        }
        foreach ($tehProdThnLalu as $row) { if (isset($data['teh'][$row->regional])) $data['teh'][$row->regional]['produksi']['thn_lalu'] = $row->total_prod; }


        // ==========================================
        // CALCULATIONS & TOTALS
        // ==========================================
        foreach (['karet', 'teh'] as $komoditi) {
            foreach ($regionals as $reg) {
                // Kalkulasi pct dan produktivitas per regional
                $row = &$data[$komoditi][$reg];
                
                // Pct Luas
                $row['luas']['pct_rkap'] = $row['luas']['rkap'] > 0 ? ($row['luas']['real'] / $row['luas']['rkap'] * 100) : 0;
                $row['luas']['pct_thn_lalu'] = $row['luas']['thn_lalu'] > 0 ? ($row['luas']['real'] / $row['luas']['thn_lalu'] * 100) : 0;
                
                // Pct Produksi
                $row['produksi']['pct_rkap'] = $row['produksi']['rkap'] > 0 ? ($row['produksi']['real'] / $row['produksi']['rkap'] * 100) : 0;
                $row['produksi']['pct_thn_lalu'] = $row['produksi']['thn_lalu'] > 0 ? ($row['produksi']['real'] / $row['produksi']['thn_lalu'] * 100) : 0;
                
                // Produktivitas
                $row['produktivitas']['rkap'] = $row['luas']['rkap'] > 0 ? ($row['produksi']['rkap'] / $row['luas']['rkap']) : 0;
                $row['produktivitas']['thn_lalu'] = $row['luas']['thn_lalu'] > 0 ? ($row['produksi']['thn_lalu'] / $row['luas']['thn_lalu']) : 0;
                $row['produktivitas']['real'] = $row['luas']['real'] > 0 ? ($row['produksi']['real'] / $row['luas']['real']) : 0;
                
                // Pct Produktivitas
                $row['produktivitas']['pct_rkap'] = $row['produktivitas']['rkap'] > 0 ? ($row['produktivitas']['real'] / $row['produktivitas']['rkap'] * 100) : 0;
                $row['produktivitas']['pct_thn_lalu'] = $row['produktivitas']['thn_lalu'] > 0 ? ($row['produktivitas']['real'] / $row['produktivitas']['thn_lalu'] * 100) : 0;
                
                // Accumulate to total
                $total = &$data[$komoditi . '_total'];
                $total['luas']['rkap'] += $row['luas']['rkap'];
                $total['luas']['thn_lalu'] += $row['luas']['thn_lalu'];
                $total['luas']['real'] += $row['luas']['real'];
                
                $total['produksi']['rkap'] += $row['produksi']['rkap'];
                $total['produksi']['thn_lalu'] += $row['produksi']['thn_lalu'];
                $total['produksi']['real'] += $row['produksi']['real'];
            }
            
            // Calculate total percentages and productivity
            $total = &$data[$komoditi . '_total'];
            
            // Pct Luas Total
            $total['luas']['pct_rkap'] = $total['luas']['rkap'] > 0 ? ($total['luas']['real'] / $total['luas']['rkap'] * 100) : 0;
            $total['luas']['pct_thn_lalu'] = $total['luas']['thn_lalu'] > 0 ? ($total['luas']['real'] / $total['luas']['thn_lalu'] * 100) : 0;
            
            // Pct Produksi Total
            $total['produksi']['pct_rkap'] = $total['produksi']['rkap'] > 0 ? ($total['produksi']['real'] / $total['produksi']['rkap'] * 100) : 0;
            $total['produksi']['pct_thn_lalu'] = $total['produksi']['thn_lalu'] > 0 ? ($total['produksi']['real'] / $total['produksi']['thn_lalu'] * 100) : 0;
            
            // Produktivitas Total
            $total['produktivitas']['rkap'] = $total['luas']['rkap'] > 0 ? ($total['produksi']['rkap'] / $total['luas']['rkap']) : 0;
            $total['produktivitas']['thn_lalu'] = $total['luas']['thn_lalu'] > 0 ? ($total['produksi']['thn_lalu'] / $total['luas']['thn_lalu']) : 0;
            $total['produktivitas']['real'] = $total['luas']['real'] > 0 ? ($total['produksi']['real'] / $total['luas']['real']) : 0;
            
            // Pct Produktivitas Total
            $total['produktivitas']['pct_rkap'] = $total['produktivitas']['rkap'] > 0 ? ($total['produktivitas']['real'] / $total['produktivitas']['rkap'] * 100) : 0;
            $total['produktivitas']['pct_thn_lalu'] = $total['produktivitas']['thn_lalu'] > 0 ? ($total['produktivitas']['real'] / $total['produktivitas']['thn_lalu'] * 100) : 0;
        }

        return view('pages.areal_produksi.index', compact(
            'data', 
            'regionals', 
            'tahunSelected', 
            'bulanSelected', 
            'listTahun', 
            'listBulan'
        ));
    }

    public function regional(Request $request)
    {
        // Gunakan logika yang sama dengan index()
        $currentYear = Carbon::now()->year;
        $defaultDate = Carbon::now()->subMonth();
        $tahunSelected = (int) $request->input('tahun', $defaultDate->year);
        $bulanSelected = (int) $request->input('bulan', $defaultDate->month);
        $listTahun = range($currentYear, $currentYear - 4);
        $listBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $dateObj = Carbon::createFromDate($tahunSelected, $bulanSelected, 1)->endOfMonth();
        $tanggalAkhir = $dateObj->format('Y-m-d');
        $tahun = $dateObj->year;
        $tanggalAkhirTahunLalu = Carbon::createFromDate($tahunSelected - 1, $bulanSelected, 1)->endOfMonth()->format('Y-m-d');
        $tahunLalu = $tahunSelected - 1;
        $regionals = [2, 3, 5, 7, 8];
        $data = ['tanggal_akhir' => $tanggalAkhir, 'karet' => [], 'teh' => [], 'karet_total' => $this->initEmptyRow(), 'teh_total' => $this->initEmptyRow()];
        foreach ($regionals as $reg) { $data['karet'][$reg] = $this->initEmptyRow(); $data['teh'][$reg] = $this->initEmptyRow(); }

        $karetLuasRealSub = DB::connection('looker')->table('tbl_prod_karet')->select('kebun', DB::raw('MAX(luas_tm) as luas_real_max'), DB::raw('MAX(luas_tm_rkap) as luas_rkap_max'))->whereYear('tanggal', $tahun)->where('tanggal', '<=', $tanggalAkhir)->groupBy('kebun');
        $karetLuasReal = DB::connection('looker')->table(DB::raw("({$karetLuasRealSub->toSql()}) as sub"))->mergeBindings($karetLuasRealSub)->join('regional', 'sub.kebun', '=', 'regional.unit')->select('regional.regional', DB::raw('SUM(sub.luas_real_max) as total_luas_real'), DB::raw('SUM(sub.luas_rkap_max) as total_luas_rkap'))->groupBy('regional.regional')->get();
        $karetLuasThnLaluSub = DB::connection('looker')->table('tbl_prod_karet')->select('kebun', DB::raw('MAX(luas_tm) as luas_max'))->whereYear('tanggal', $tahunLalu)->where('tanggal', '<=', $tanggalAkhirTahunLalu)->groupBy('kebun');
        $karetLuasThnLalu = DB::connection('looker')->table(DB::raw("({$karetLuasThnLaluSub->toSql()}) as sub"))->mergeBindings($karetLuasThnLaluSub)->join('regional', 'sub.kebun', '=', 'regional.unit')->select('regional.regional', DB::raw('SUM(sub.luas_max) as total_luas'))->groupBy('regional.regional')->get();
        $karetProdReal = DB::connection('looker')->table('tbl_prod_karet')->join('regional', 'tbl_prod_karet.kebun', '=', 'regional.unit')->select('regional.regional', DB::raw('SUM(prd_jml) as total_prod_real'), DB::raw('SUM(prd_tm_rkap) as total_prod_rkap'))->whereYear('tanggal', $tahun)->where('tanggal', '<=', $tanggalAkhir)->groupBy('regional.regional')->get();
        $karetProdThnLalu = DB::connection('looker')->table('tbl_prod_karet')->join('regional', 'tbl_prod_karet.kebun', '=', 'regional.unit')->select('regional.regional', DB::raw('SUM(prd_jml) as total_prod'))->whereYear('tanggal', $tahunLalu)->where('tanggal', '<=', $tanggalAkhirTahunLalu)->groupBy('regional.regional')->get();

        $tehLuasRealSub = DB::connection('looker')->table('tbl_prod_teh')->select('kebun', DB::raw('MAX(luas_tm_real) as luas_real_max'), DB::raw('MAX(luas_tm_rkap) as luas_rkap_max'))->whereYear('tanggal', $tahun)->where('tanggal', '<=', $tanggalAkhir)->groupBy('kebun');
        $tehLuasReal = DB::connection('looker')->table(DB::raw("({$tehLuasRealSub->toSql()}) as sub"))->mergeBindings($tehLuasRealSub)->join('regional', 'sub.kebun', '=', 'regional.unit')->select('regional.regional', DB::raw('SUM(sub.luas_real_max) as total_luas_real'), DB::raw('SUM(sub.luas_rkap_max) as total_luas_rkap'))->groupBy('regional.regional')->get();
        $tehLuasThnLaluSub = DB::connection('looker')->table('tbl_prod_teh')->select('kebun', DB::raw('MAX(luas_tm_real) as luas_real_max'))->whereYear('tanggal', $tahunLalu)->where('tanggal', '<=', $tanggalAkhirTahunLalu)->groupBy('kebun');
        $tehLuasThnLalu = DB::connection('looker')->table(DB::raw("({$tehLuasThnLaluSub->toSql()}) as sub"))->mergeBindings($tehLuasThnLaluSub)->join('regional', 'sub.kebun', '=', 'regional.unit')->select('regional.regional', DB::raw('SUM(sub.luas_real_max) as total_luas'))->groupBy('regional.regional')->get();
        $tehProdReal = DB::connection('looker')->table('tbl_prod_teh')->join('regional', 'tbl_prod_teh.kebun', '=', 'regional.unit')->select('regional.regional', DB::raw('SUM(prod_kering_real) as total_prod_real'), DB::raw('SUM(prod_kering_rkap) as total_prod_rkap'))->whereYear('tanggal', $tahun)->where('tanggal', '<=', $tanggalAkhir)->groupBy('regional.regional')->get();
        $tehProdThnLalu = DB::connection('looker')->table('tbl_prod_teh')->join('regional', 'tbl_prod_teh.kebun', '=', 'regional.unit')->select('regional.regional', DB::raw('SUM(prod_kering_real) as total_prod'))->whereYear('tanggal', $tahunLalu)->where('tanggal', '<=', $tanggalAkhirTahunLalu)->groupBy('regional.regional')->get();

        foreach ($karetLuasReal as $row) { if (isset($data['karet'][$row->regional])) { $data['karet'][$row->regional]['luas']['real'] = $row->total_luas_real; $data['karet'][$row->regional]['luas']['rkap'] = $row->total_luas_rkap; } }
        foreach ($karetLuasThnLalu as $row) { if (isset($data['karet'][$row->regional])) $data['karet'][$row->regional]['luas']['thn_lalu'] = $row->total_luas; }
        foreach ($karetProdReal as $row) { if (isset($data['karet'][$row->regional])) { $data['karet'][$row->regional]['produksi']['real'] = $row->total_prod_real; $data['karet'][$row->regional]['produksi']['rkap'] = $row->total_prod_rkap; } }
        foreach ($karetProdThnLalu as $row) { if (isset($data['karet'][$row->regional])) $data['karet'][$row->regional]['produksi']['thn_lalu'] = $row->total_prod; }
        foreach ($tehLuasReal as $row) { if (isset($data['teh'][$row->regional])) { $data['teh'][$row->regional]['luas']['real'] = $row->total_luas_real; $data['teh'][$row->regional]['luas']['rkap'] = $row->total_luas_rkap; } }
        foreach ($tehLuasThnLalu as $row) { if (isset($data['teh'][$row->regional])) $data['teh'][$row->regional]['luas']['thn_lalu'] = $row->total_luas; }
        foreach ($tehProdReal as $row) { if (isset($data['teh'][$row->regional])) { $data['teh'][$row->regional]['produksi']['real'] = $row->total_prod_real; $data['teh'][$row->regional]['produksi']['rkap'] = $row->total_prod_rkap; } }
        foreach ($tehProdThnLalu as $row) { if (isset($data['teh'][$row->regional])) $data['teh'][$row->regional]['produksi']['thn_lalu'] = $row->total_prod; }

        foreach (['karet', 'teh'] as $komoditi) {
            foreach ($regionals as $reg) {
                $row = &$data[$komoditi][$reg];
                $row['luas']['pct_rkap'] = $row['luas']['rkap'] > 0 ? ($row['luas']['real'] / $row['luas']['rkap'] * 100) : 0;
                $row['luas']['pct_thn_lalu'] = $row['luas']['thn_lalu'] > 0 ? ($row['luas']['real'] / $row['luas']['thn_lalu'] * 100) : 0;
                $row['produksi']['pct_rkap'] = $row['produksi']['rkap'] > 0 ? ($row['produksi']['real'] / $row['produksi']['rkap'] * 100) : 0;
                $row['produksi']['pct_thn_lalu'] = $row['produksi']['thn_lalu'] > 0 ? ($row['produksi']['real'] / $row['produksi']['thn_lalu'] * 100) : 0;
                $row['produktivitas']['rkap'] = $row['luas']['rkap'] > 0 ? ($row['produksi']['rkap'] / $row['luas']['rkap']) : 0;
                $row['produktivitas']['thn_lalu'] = $row['luas']['thn_lalu'] > 0 ? ($row['produksi']['thn_lalu'] / $row['luas']['thn_lalu']) : 0;
                $row['produktivitas']['real'] = $row['luas']['real'] > 0 ? ($row['produksi']['real'] / $row['luas']['real']) : 0;
                $row['produktivitas']['pct_rkap'] = $row['produktivitas']['rkap'] > 0 ? ($row['produktivitas']['real'] / $row['produktivitas']['rkap'] * 100) : 0;
                $row['produktivitas']['pct_thn_lalu'] = $row['produktivitas']['thn_lalu'] > 0 ? ($row['produktivitas']['real'] / $row['produktivitas']['thn_lalu'] * 100) : 0;
                $total = &$data[$komoditi . '_total'];
                $total['luas']['rkap'] += $row['luas']['rkap']; $total['luas']['thn_lalu'] += $row['luas']['thn_lalu']; $total['luas']['real'] += $row['luas']['real'];
                $total['produksi']['rkap'] += $row['produksi']['rkap']; $total['produksi']['thn_lalu'] += $row['produksi']['thn_lalu']; $total['produksi']['real'] += $row['produksi']['real'];
            }
            $total = &$data[$komoditi . '_total'];
            $total['luas']['pct_rkap'] = $total['luas']['rkap'] > 0 ? ($total['luas']['real'] / $total['luas']['rkap'] * 100) : 0;
            $total['luas']['pct_thn_lalu'] = $total['luas']['thn_lalu'] > 0 ? ($total['luas']['real'] / $total['luas']['thn_lalu'] * 100) : 0;
            $total['produksi']['pct_rkap'] = $total['produksi']['rkap'] > 0 ? ($total['produksi']['real'] / $total['produksi']['rkap'] * 100) : 0;
            $total['produksi']['pct_thn_lalu'] = $total['produksi']['thn_lalu'] > 0 ? ($total['produksi']['real'] / $total['produksi']['thn_lalu'] * 100) : 0;
            $total['produktivitas']['rkap'] = $total['luas']['rkap'] > 0 ? ($total['produksi']['rkap'] / $total['luas']['rkap']) : 0;
            $total['produktivitas']['thn_lalu'] = $total['luas']['thn_lalu'] > 0 ? ($total['produksi']['thn_lalu'] / $total['luas']['thn_lalu']) : 0;
            $total['produktivitas']['real'] = $total['luas']['real'] > 0 ? ($total['produksi']['real'] / $total['luas']['real']) : 0;
            $total['produktivitas']['pct_rkap'] = $total['produktivitas']['rkap'] > 0 ? ($total['produktivitas']['real'] / $total['produktivitas']['rkap'] * 100) : 0;
            $total['produktivitas']['pct_thn_lalu'] = $total['produktivitas']['thn_lalu'] > 0 ? ($total['produktivitas']['real'] / $total['produktivitas']['thn_lalu'] * 100) : 0;
        }

        return view('pages.areal_produksi.regional', compact(
            'data', 'regionals', 'tahunSelected', 'bulanSelected', 'listTahun', 'listBulan'
        ));
    }
    
    private function initEmptyRow() {
        return [
            'luas' => ['rkap' => 0, 'thn_lalu' => 0, 'real' => 0, 'pct_rkap' => 0, 'pct_thn_lalu' => 0],
            'produksi' => ['rkap' => 0, 'thn_lalu' => 0, 'real' => 0, 'pct_rkap' => 0, 'pct_thn_lalu' => 0],
            'produktivitas' => ['rkap' => 0, 'thn_lalu' => 0, 'real' => 0, 'pct_rkap' => 0, 'pct_thn_lalu' => 0],
        ];
    }
}
