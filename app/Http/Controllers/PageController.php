<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Plant;
use BigQuery;

class PageController extends Controller
{
    public function overview()
    {
        $user = Auth::guard('custom')->user();
        $username = $user->username;
        if ($username != 'mrc') {
            return view('pages/overviewnew');
        } else {
            return view('pages/overview');
        }
    }
    public function mrc()
    {
        return view('pages/overview');

        // $linkiframe = 'https://lookerstudio.google.com/embed/reporting/0c40fa91-90ba-474a-becc-f1b48ccd7553/page/p_fjvzqqpxmd';
        // return view('pages/overview_page', compact('linkiframe'));

    }
    public function onfarmkaret()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/0c40fa91-90ba-474a-becc-f1b48ccd7553/page/p_fjvzqqpxmd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function onfarmteh()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/e825898d-0a18-4e28-a258-9b4e83aff7b1/page/p_hsaddeiwmd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function onfarmkopi()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/107ef939-e0ce-4084-a50b-a9d526a368bc/page/p_ee90olr1md';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function offfarmkaret()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/b3d7816f-810b-4609-9d64-2db9bd818301/page/p_y59zpdpxmd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function offfarmteh()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/f0f0edeb-4e91-4306-910e-64389351f433/page/p_o6yw3alxmd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function offfarmkopi()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/107ef939-e0ce-4084-a50b-a9d526a368bc/page/p_ee90olr1md';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function fin_console()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/2195aff4-6f81-4d0c-a245-74f9f3e7a981/page/oPLPE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function fin_parent()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/0cbe6f0b-4ccd-4a52-9fef-ca04b1646d76/page/oPLPE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function fin_sub()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/2e81907d-96be-4fa5-85b6-b8ce253ddbf1/page/oPLPE';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function hr_demographics()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/e594bb0d-abf4-45a9-9b6c-9158a7758ca4/page/wpSPE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function hr_dev()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/e594bb0d-abf4-45a9-9b6c-9158a7758ca4/page/p_4r8uabgumd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function hr_revenue()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/e594bb0d-abf4-45a9-9b6c-9158a7758ca4/page/p_0544mbixmd';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function sales_comodities()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/8cd897b7-1bfc-4a2a-a6ae-19c1cd2d0cb2/page/06RUE';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function agraria_tax()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/5fed7d89-b764-4a87-b5da-6fada9560516/page/joCQE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function agraria()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/e0d7a03a-de00-4595-9737-1f67324bef7b/page/oyNLE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function asset_peta()
    {
        return view('pages/asset_peta');
    }
    public function asset_recovery()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/f61c7bcb-c5e4-4f98-ac6d-1c28c30de378/page/joCQE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function asset_optimalisasi()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/66f68a20-7f10-4f24-a555-b4f6466515ee/page/yz1VE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function asset_divestasi()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/9e0d8865-4fb9-48bf-946e-08a8ff1e45f5/page/NrNUE';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function picaonfarm()
    {
        $linkiframe = 'https://eis.ptpn1.co.id/dashpica_looker?pilih_tahun=2024&month=7&pilih_komoditas=2';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function picaofffarm()
    {
        $linkiframe = 'http://eis.ptpn1.co.id/dashpicaoff_looker?pilih_tahun=2024&month=7&pilih_komoditas=2';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function picaKuadranProblemIdentifications()
    {
        $linkiframe = 'https://picakateko.holding-perkebunan.com/on-farm/teh/dashboard-kuadran?token=8cb8a28ec911a78ebe997c92d162b29f44e00d3233f7e44649ad929bd105df4n';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function picaListCorrectiveActions()
    {
        $linkiframe = 'https://picakateko.holding-perkebunan.com/on-farm/teh/approval?token=8cb8a28ec911a78ebe997c92d162b29f44e00d3233f7e44649ad929bd105df4n';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function sla()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/5d2ef7fa-99cf-44bc-97a1-ad3866a43285/page/ihnUE';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function dfarmkaretold()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/719192ff-2e4c-4680-a6f1-ad1591eac05c/page/p_wsn4ogdumd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function dfarmkaretpresensi()
    {
        $regional = $_GET['id_reg'] ?? '';
        $tglAwal = $_GET['tgl_awal'] ?? date('Y-m-d');
        $tglAkhir = $_GET['tgl_akhir'] ?? date('Y-m-d');
        $kebun = $_GET['kode_kebun'] ?? '';
        $jobdesc = $_GET['jobdesc'] ?? 'PENYADAP';
        $komoditas = 2;
        if ($jobdesc == 'PEMETIK') {
            $komoditas = 1;
        }
        if ($jobdesc == 'PANEN KOPI') {
            $komoditas = 3;
        }
        if ($tglAwal > $tglAkhir) {
            return Redirect::back()->withErrors(['msg' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir']);
        }
        // Gunakan INNER JOIN (lebih cepat) dan tambahkan filter regional
        $data = DB::connection('pgsql_secondary')
            ->table('person_data')
            ->select('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama as nama_kebun')
            ->leftJoin('m_kebun', 'person_data.kebun_id', '=', 'm_kebun.id')
            ->whereNotNull('person_data.regional_id')
            ->orderBy('person_data.regional_id');
        if ($komoditas == 1) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Pemetik%')
                    ->orWhere('positionsdesc', 'like', '%PEMETIK%')
                    ->orWhere('positionsdesc', 'like', '%pemetik%');
            });
        }
        if ($komoditas == 2) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Penyadap%')
                    ->orWhere('positionsdesc', 'like', '%PENYADAP%')
                    ->orWhere('positionsdesc', 'like', '%penyadap%');
            });
        }
        if ($komoditas == 3) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Panen Kopi%')
                    ->orWhere('positionsdesc', 'like', '%PANEN KOPI%')
                    ->orWhere('positionsdesc', 'like', '%panen kopi%');
            });
        }
        if ($regional) {
            $data->where('person_data.regional_id', $regional);
        }
        // Gunakan pagination untuk data besar
        $allDatakebun = $data->groupBy('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama')
            ->get();
        $selectedRegional = $regional;
        $selectedKomoditas = $komoditas;
        $selectedKebun = $kebun;
        if ($regional != '' and $kebun == '') {
            $presensiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_presensi_kebun(?, ?, ?, ?) AS (
                    kebun_id integer, 
                    kebun varchar, 
                    kehadiran bigint, 
                    sakit bigint, 
                    cuti bigint, 
                    libur bigint, 
                    mangkir bigint, 
                    dll bigint, 
                    belum_hadir bigint, 
                    prosentase double precision, 
                    prosentase_kehadiran double precision, 
                    total_pegawai bigint
                )',
                [$jobdesc, $regional, $tglAwal, $tglAkhir]
            );
            $presensiDataRegional = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM public.fn_rekap_presensi_regional_sql(?, ?, ?) 
                WHERE regional_id = ?',
                [$jobdesc, $tglAwal, $tglAkhir, $regional]
            );
            // Jika hanya 1 row, langsung assign tanpa aggregate
            $totalData = !empty($presensiDataRegional) ? (array) $presensiDataRegional[0] : [];
            // dd($totalData);
        }
        if ($regional == '') {

            $presensiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM public.fn_rekap_presensi_regional_sql(?, ?, ?)',
                [$jobdesc, $tglAwal, $tglAkhir]

            );
            $totalData = $this->calculateTotalPresensi($presensiData);
        }
        if ($regional != '' and $kebun != '') {

            $presensiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_presensi_afdeling(?, ?, ?, ?) AS (
                    afdeling_id integer, 
                    afdeling varchar, 
                    kehadiran bigint, 
                    sakit bigint, 
                    cuti bigint, 
                    libur bigint, 
                    mangkir bigint, 
                    dll bigint, 
                    belum_hadir bigint, 
                    prosentase double precision, 
                    prosentase_kehadiran double precision, 
                    total_pegawai bigint
                )',
                [$jobdesc, $kebun, $tglAwal, $tglAkhir]
            );
            $presensiDataKebun = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_presensi_kebun(?, ?, ?, ?) AS (
                    kebun_id integer, 
                    kebun varchar, 
                    kehadiran bigint, 
                    sakit bigint, 
                    cuti bigint, 
                    libur bigint, 
                    mangkir bigint, 
                    dll bigint, 
                    belum_hadir bigint, 
                    prosentase double precision, 
                    prosentase_kehadiran double precision, 
                    total_pegawai bigint
                ) WHERE kebun_id = ?',
                [$jobdesc, $regional, $tglAwal, $tglAkhir, $kebun]
            );
            // Jika hanya 1 row setelah filter, langsung assign tanpa aggregate
            $totalData = !empty($presensiDataKebun) ? (array) $presensiDataKebun[0] : [];
        }

        // Hitung total untuk masing-masing kolom
        if (empty($totalData)) {
            return Redirect::back()->withErrors(['msg' => 'Data tidak ditemukan untuk filter yang dipilih']);
        }


        return view('pages/dfarm/dfarm_karet_presensi', compact('allDatakebun', 'selectedRegional', 'selectedKebun', 'selectedKomoditas', 'presensiData', 'totalData', 'tglAwal', 'tglAkhir', 'jobdesc'));
    }

    public function dfarmkaretpresensitabular()
    {
        $regional = $_GET['id_reg'] ?? '';
        $tglAwal = $_GET['tgl_awal'] ?? date('Y-m-d');
        $tglAkhir = $_GET['tgl_akhir'] ?? date('Y-m-d');
        $kebun = $_GET['kode_kebun'] ?? '';
        $jobdesc = $_GET['jobdesc'] ?? 'PENYADAP';
        $komoditas = 2;
        if ($jobdesc == 'PEMETIK') {
            $komoditas = 1;
        }
        if ($jobdesc == 'PANEN KOPI') {
            $komoditas = 3;
        }
        if ($tglAwal > $tglAkhir) {
            return Redirect::back()->withErrors(['msg' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir']);
        }
        // Gunakan INNER JOIN (lebih cepat) dan tambahkan filter regional
        $data = DB::connection('pgsql_secondary')
            ->table('person_data')
            ->select('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama as nama_kebun')
            ->leftJoin('m_kebun', 'person_data.kebun_id', '=', 'm_kebun.id')
            ->whereNotNull('person_data.regional_id')
            ->orderBy('person_data.regional_id');
        if ($komoditas == 1) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Pemetik%')
                    ->orWhere('positionsdesc', 'like', '%PEMETIK%')
                    ->orWhere('positionsdesc', 'like', '%pemetik%');
            });
        }
        if ($komoditas == 2) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Penyadap%')
                    ->orWhere('positionsdesc', 'like', '%PENYADAP%')
                    ->orWhere('positionsdesc', 'like', '%penyadap%');
            });
        }
        if ($komoditas == 3) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Panen Kopi%')
                    ->orWhere('positionsdesc', 'like', '%PANEN KOPI%')
                    ->orWhere('positionsdesc', 'like', '%panen kopi%');
            });
        }
        if ($regional) {
            $data->where('person_data.regional_id', $regional);
        }
        // Gunakan pagination untuk data besar
        $allDatakebun = $data->groupBy('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama')
            ->get();
        $selectedRegional = $regional;
        $selectedKomoditas = $komoditas;
        $selectedKebun = $kebun;
        if ($regional != '' and $kebun == '') {
            $presensiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_presensi_kebun(?, ?, ?, ?) AS (
                    kebun_id integer, 
                    kebun varchar, 
                    kehadiran bigint, 
                    sakit bigint, 
                    cuti bigint, 
                    libur bigint, 
                    mangkir bigint, 
                    dll bigint, 
                    belum_hadir bigint, 
                    prosentase double precision, 
                    prosentase_kehadiran double precision, 
                    total_pegawai bigint
                )',
                [$jobdesc, $regional, $tglAwal, $tglAkhir]
            );
            $presensiDataRegional = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM public.fn_rekap_presensi_regional_sql(?, ?, ?) 
                WHERE regional_id = ?',
                [$jobdesc, $tglAwal, $tglAkhir, $regional]
            );
            // Jika hanya 1 row, langsung assign tanpa aggregate
            $totalData = !empty($presensiDataRegional) ? (array) $presensiDataRegional[0] : [];

        }
        if ($regional == '') {

            $presensiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM public.fn_rekap_presensi_regional_sql(?, ?, ?)',
                [$jobdesc, $tglAwal, $tglAkhir]

            );
            $totalData = $this->calculateTotalPresensi($presensiData);
        }
        if ($regional != '' and $kebun != '') {

            $presensiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_presensi_afdeling(?, ?, ?, ?) AS (
                    afdeling_id integer, 
                    afdeling varchar, 
                    kehadiran bigint, 
                    sakit bigint, 
                    cuti bigint, 
                    libur bigint, 
                    mangkir bigint, 
                    dll bigint, 
                    belum_hadir bigint, 
                    prosentase double precision, 
                    prosentase_kehadiran double precision, 
                    total_pegawai bigint
                )',
                [$jobdesc, $kebun, $tglAwal, $tglAkhir]
            );
            $presensiDataKebun = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_presensi_kebun(?, ?, ?, ?) AS (
                    kebun_id integer, 
                    kebun varchar, 
                    kehadiran bigint, 
                    sakit bigint, 
                    cuti bigint, 
                    libur bigint, 
                    mangkir bigint, 
                    dll bigint, 
                    belum_hadir bigint, 
                    prosentase double precision, 
                    prosentase_kehadiran double precision, 
                    total_pegawai bigint
                ) WHERE kebun_id = ?',
                [$jobdesc, $regional, $tglAwal, $tglAkhir, $kebun]
            );
            // Jika hanya 1 row setelah filter, langsung assign tanpa aggregate
            $totalData = !empty($presensiDataKebun) ? (array) $presensiDataKebun[0] : [];
        }

        // Hitung total untuk masing-masing kolom
        if (empty($totalData)) {
            return Redirect::back()->withErrors(['msg' => 'Data tidak ditemukan untuk filter yang dipilih']);
        }


        return view('pages/dfarm/dfarm_karet_presensi_tabular', compact('allDatakebun', 'selectedRegional', 'selectedKebun', 'selectedKomoditas', 'presensiData', 'totalData', 'tglAwal', 'tglAkhir', 'jobdesc'));
    }

    /**
     * Hitung total untuk masing-masing kolom presensi
     * @param array $data Array of objects dengan semua kolom presensi
     * @return array Array dengan key berupa nama kolom dan value berupa total/rata-rata
     */
    private function calculateTotalPresensi($data)
    {
        if (empty($data)) {
            return [
                'kehadiran' => 0,
                'sakit' => 0,
                'cuti' => 0,
                'libur' => 0,
                'mangkir' => 0,
                'dll' => 0,
                'belum_hadir' => 0,
                'prosentase' => 0,
                'prosentase_kehadiran' => 0,
                'total_pegawai' => 0,
                'total_kebun' => 0
            ];
        }

        $totals = [
            'kehadiran' => 0,
            'sakit' => 0,
            'cuti' => 0,
            'libur' => 0,
            'mangkir' => 0,
            'dll' => 0,
            'belum_hadir' => 0,
            'prosentase' => 0,
            'prosentase_kehadiran' => 0,
            'total_pegawai' => 0,
        ];

        $count = count($data);

        foreach ($data as $item) {
            $totals['kehadiran'] += $item->kehadiran ?? 0;
            $totals['sakit'] += $item->sakit ?? 0;
            $totals['cuti'] += $item->cuti ?? 0;
            $totals['libur'] += $item->libur ?? 0;
            $totals['mangkir'] += $item->mangkir ?? 0;
            $totals['dll'] += $item->dll ?? 0;
            $totals['belum_hadir'] += $item->belum_hadir ?? 0;
            $totals['prosentase'] += floatval($item->prosentase ?? 0);
            $totals['prosentase_kehadiran'] += floatval($item->prosentase_kehadiran ?? 0);
            $totals['total_pegawai'] += $item->total_pegawai ?? 0;
        }

        // Hitung rata-rata untuk prosentase (bukan jumlah total)
        if ($count > 0) {
            $totals['prosentase'] = round($totals['prosentase'] / $count, 2);
            $totals['prosentase_kehadiran'] = round($totals['prosentase_kehadiran'] / $count, 2);
        }

        $totals['total_kebun'] = $count;

        return $totals;
    }
    private function calculateTotalPrestasi($data)
    {
        if (empty($data)) {
            return [
                'basah_latek' => 0,
                'basah_lump' => 0,
                'basah_scrab' => 0,
                'total_basah' => 0,
                'sheet' => 0,
                'compo' => 0,
                'scrap' => 0,
                'total_kering' => 0,
            ];
        }

        $totals = [
            'basah_latek' => 0,
            'basah_lump' => 0,
            'basah_scrab' => 0,
            'total_basah' => 0,
            'sheet' => 0,
            'compo' => 0,
            'scrap' => 0,
            'total_kering' => 0,
        ];

        $count = count($data);

        foreach ($data as $item) {
            $totals['basah_latek'] += $item->basah_latek ?? 0;
            $totals['basah_lump'] += $item->basah_lump ?? 0;
            $totals['basah_scrab'] += $item->basah_scrab ?? 0;
            $totals['total_basah'] += $item->total_basah ?? 0;
            $totals['sheet'] += $item->sheet ?? 0;
            $totals['compo'] += $item->compo ?? 0;
            $totals['scrap'] += $item->scrap ?? 0;
            $totals['total_kering'] += $item->total_kering ?? 0;
        }

        $totals['total_kebun'] = $count;

        return $totals;
    }
    private function calculateTotalPrestasiTeh($data)
    {
        if (empty($data)) {
            return [
                'panen_manual' => 0,
                'panen_gunting' => 0,
                'panen_mesin_group' => 0,
                'panen_mesin_individu' => 0,
                'total' => 0,
            ];
        }

        $totals = [
            'panen_manual' => 0,
            'panen_gunting' => 0,
            'panen_mesin_group' => 0,
            'panen_mesin_individu' => 0,
            'total' => 0,
        ];


        $count = count($data);

        foreach ($data as $item) {
            $totals['panen_manual'] += $item->panen_manual ?? 0;
            $totals['panen_gunting'] += $item->panen_gunting ?? 0;
            $totals['panen_mesin_group'] += $item->panen_mesin_group ?? 0;
            $totals['panen_mesin_individu'] += $item->panen_mesin_individu ?? 0;
            $totals['total'] += $item->total ?? 0;
        }

        $totals['total_kebun'] = $count;

        return $totals;
    }
    private function calculateTotalPrestasiKopi($data)
    {
        if (empty($data)) {
            return [
                'basah_merah' => 0,
                'basah_kuning' => 0,
                'basah_hijau' => 0,
                'basah_hitam' => 0,
                'total_basah' => 0,
                'kering_merah' => 0,
                'kering_kuning' => 0,
                'kering_hijau' => 0,
                'kering_hitam' => 0,
                'total_kering' => 0,
            ];
        }

        $totals = [
            'basah_merah' => 0,
            'basah_kuning' => 0,
            'basah_hijau' => 0,
            'basah_hitam' => 0,
            'total_basah' => 0,
            'kering_merah' => 0,
            'kering_kuning' => 0,
            'kering_hijau' => 0,
            'kering_hitam' => 0,
            'total_kering' => 0,
        ];

        $count = count($data);

        foreach ($data as $item) {
            $totals['basah_merah'] += $item->basah_merah ?? 0;
            $totals['basah_kuning'] += $item->basah_kuning ?? 0;
            $totals['basah_hijau'] += $item->basah_hijau ?? 0;
            $totals['basah_hitam'] += $item->basah_hitam ?? 0;
            $totals['total_basah'] += $item->total_basah ?? 0;
            $totals['kering_merah'] += $item->kering_merah ?? 0;
            $totals['kering_kuning'] += $item->kering_kuning ?? 0;
            $totals['kering_hijau'] += $item->kering_hijau ?? 0;
            $totals['kering_hitam'] += $item->kering_hitam ?? 0;
            $totals['total_kering'] += $item->total_kering ?? 0;
        }

        $totals['total_kebun'] = $count;

        return $totals;
    }

    private function calculateTotalPrestasiPemeliharaan($data)
    {
        if (empty($data)) {
            return [
                'hasil_pemeliharaan' => 0,
            ];
        }

        $totals = [
            'hasil_pemeliharaan' => 0,
        ];

        $count = count($data);

        foreach ($data as $item) {
            $totals['hasil_pemeliharaan'] += $item->hasil_pemeliharaan ?? 0;
        }

        $totals['total_kebun'] = $count;

        return $totals;
    }

    public function dfarmkaretproduksi()
    {
        $regional = $_GET['id_reg'] ?? '';
        $tglAwal = $_GET['tgl_awal'] ?? date('Y-m-d');
        $tglAkhir = $_GET['tgl_akhir'] ?? date('Y-m-d');
        $kebun = $_GET['kode_kebun'] ?? '';
        $jobdesc = $_GET['jobdesc'] ?? 'PENYADAP';
        $komoditas = 2;

        if ($tglAwal > $tglAkhir) {
            return Redirect::back()->withErrors(['msg' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir']);
        }
        // Gunakan INNER JOIN (lebih cepat) dan tambahkan filter regional
        $data = DB::connection('pgsql_secondary')
            ->table('person_data')
            ->select('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama as nama_kebun')
            ->leftJoin('m_kebun', 'person_data.kebun_id', '=', 'm_kebun.id')
            ->whereNotNull('person_data.regional_id')
            ->orderBy('person_data.regional_id');

        if ($komoditas == 2) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Penyadap%')
                    ->orWhere('positionsdesc', 'like', '%PENYADAP%')
                    ->orWhere('positionsdesc', 'like', '%penyadap%');
            });
        }

        if ($regional) {
            $data->where('person_data.regional_id', $regional);
        }
        // Gunakan pagination untuk data besar
        $allDatakebun = $data->groupBy('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama')
            ->get();
        $selectedRegional = $regional;
        $selectedKomoditas = $komoditas;
        $selectedKebun = $kebun;
        if ($regional != '' and $kebun == '') {
            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_kebun_fast(?, ?, ?, ?) AS (
                    id integer, 
                    nama varchar, 
                    basah_latek numeric, 
                    basah_lump numeric, 
                    basah_scrab numeric, 
                    total_basah numeric,
                    sheet numeric, 
                    compo numeric, 
                    scrap numeric, 
                    total_kering numeric
                )',
                [2, $regional, $tglAwal, $tglAkhir]
            );
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_kebun_lite(?, ?, ?, ?, ?, ?)',
                ['PENYADAP', $regional, '', 2, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasi($prestasiData);
            // dd($totalData);
        }
        if ($regional == '') {

            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_regional(?, ?, ?) AS (
                    id integer, 
                    nama varchar, 
                    basah_latek numeric, 
                    basah_lump numeric, 
                    basah_scrab numeric, 
                    total_basah numeric,
                    sheet numeric, 
                    compo numeric, 
                    scrap numeric, 
                    total_kering numeric
                )',
                [2, $tglAwal, $tglAkhir]
            );
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_regional_lite(?, ?, ?, ?, ?)',
                ['PENYADAP', '', 2, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasi($prestasiData);
        }
        if ($regional != '' and $kebun != '') {

            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_afdeling(?, ?, ?, ?) AS (
                    id integer, 
                    nama varchar, 
                    basah_latek numeric, 
                    basah_lump numeric, 
                    basah_scrab numeric, 
                    total_basah numeric,
                    sheet numeric, 
                    compo numeric, 
                    scrap numeric, 
                    total_kering numeric
                )',
                [2, $kebun, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasi($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_afdeling_lite(?, ?, ?, ?, ?)',
                ['PENYADAP', $kebun, 2, $tglAwal, $tglAkhir]
            );
        }

        // Hitung total untuk masing-masing kolom
        if (empty($totalData)) {
            return Redirect::back()->withErrors(['msg' => 'Data tidak ditemukan untuk filter yang dipilih']);
        }


        return view('pages/dfarm/dfarm_karet_produksi', compact('allDatakebun', 'selectedRegional', 'selectedKebun', 'selectedKomoditas', 'prestasiData', 'prestasiDataLite', 'totalData', 'tglAwal', 'tglAkhir', 'jobdesc'));
    }
    public function dfarmtehproduksi()
    {
        $regional = $_GET['id_reg'] ?? '';
        $tglAwal = $_GET['tgl_awal'] ?? date('Y-m-d');
        $tglAkhir = $_GET['tgl_akhir'] ?? date('Y-m-d');
        $kebun = $_GET['kode_kebun'] ?? '';
        $jobdesc = $_GET['jobdesc'] ?? 'PEMETIK';
        $komoditas = 1;

        if ($tglAwal > $tglAkhir) {
            return Redirect::back()->withErrors(['msg' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir']);
        }
        // Gunakan INNER JOIN (lebih cepat) dan tambahkan filter regional
        $data = DB::connection('pgsql_secondary')
            ->table('person_data')
            ->select('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama as nama_kebun')
            ->leftJoin('m_kebun', 'person_data.kebun_id', '=', 'm_kebun.id')
            ->whereNotNull('person_data.regional_id')
            ->orderBy('person_data.regional_id');

        if ($komoditas == 1) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Pemetik%')
                    ->orWhere('positionsdesc', 'like', '%PEMETIK%')
                    ->orWhere('positionsdesc', 'like', '%pemetik%');
            });
        }

        if ($regional) {
            $data->where('person_data.regional_id', $regional);
        }
        // Gunakan pagination untuk data besar
        $allDatakebun = $data->groupBy('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama')
            ->get();

        $selectedRegional = $regional;
        $selectedKomoditas = $komoditas;
        $selectedKebun = $kebun;
        if ($regional != '' and $kebun == '') {
            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_teh_kebun(?,?, ?) AS (
                    id integer, 
                    nama varchar, 
                    panen_manual numeric, 
                    panen_gunting numeric, 
                    panen_mesin_group numeric, 
                    panen_mesin_individu numeric,
                    total numeric
                )',
                [$regional, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiTeh($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_kebun_lite(?, ?, ?, ?, ?, ?)',
                ['PEMETIK', $regional, '', 1, $tglAwal, $tglAkhir]
            );
        }
        if ($regional == '') {

            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_teh_regional(?, ?) AS (
                    id integer, 
                    nama varchar, 
                    panen_manual numeric, 
                    panen_gunting numeric, 
                    panen_mesin_group numeric, 
                    panen_mesin_individu numeric,
                    total numeric
                )',
                [$tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiTeh($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_regional_lite(?, ?, ?, ?, ?)',
                ['PEMETIK', '', 1, $tglAwal, $tglAkhir]
            );
        }
        if ($regional != '' and $kebun != '') {

            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_teh_afdeling(?,?, ?) AS (
                    id integer, 
                    nama varchar, 
                    panen_manual numeric, 
                    panen_gunting numeric, 
                    panen_mesin_group numeric, 
                    panen_mesin_individu numeric,
                    total numeric
                )',
                [$kebun, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiTeh($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_afdeling_lite(?, ?, ?, ?, ?)',
                ['PEMETIK', $kebun, 1, $tglAwal, $tglAkhir]
            );
        }

        // Hitung total untuk masing-masing kolom
        if (empty($totalData)) {
            return Redirect::back()->withErrors(['msg' => 'Data tidak ditemukan untuk filter yang dipilih']);
        }


        return view('pages/dfarm/dfarm_teh_produksi', compact('allDatakebun', 'selectedRegional', 'selectedKebun', 'selectedKomoditas', 'prestasiData', 'prestasiDataLite', 'totalData', 'tglAwal', 'tglAkhir', 'jobdesc'));
    }
    public function dfarmkopiproduksi()
    {
        $regional = $_GET['id_reg'] ?? '';
        $tglAwal = $_GET['tgl_awal'] ?? date('Y-m-d');
        $tglAkhir = $_GET['tgl_akhir'] ?? date('Y-m-d');
        $kebun = $_GET['kode_kebun'] ?? '';
        $jobdesc = $_GET['jobdesc'] ?? 'PANEN KOPI';
        $komoditas = 3;

        if ($tglAwal > $tglAkhir) {
            return Redirect::back()->withErrors(['msg' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir']);
        }
        // Gunakan INNER JOIN (lebih cepat) dan tambahkan filter regional
        $data = DB::connection('pgsql_secondary')
            ->table('person_data')
            ->select('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama as nama_kebun')
            ->leftJoin('m_kebun', 'person_data.kebun_id', '=', 'm_kebun.id')
            ->whereNotNull('person_data.regional_id')
            ->orderBy('person_data.regional_id');

        if ($komoditas == 3) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Panen Kopi%')
                    ->orWhere('positionsdesc', 'like', '%PANEN KOPI%')
                    ->orWhere('positionsdesc', 'like', '%panen kopi%');
            });
        }

        if ($regional) {
            $data->where('person_data.regional_id', $regional);
        }
        // Gunakan pagination untuk data besar
        $allDatakebun = $data->groupBy('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama')
            ->get();

        $selectedRegional = $regional;
        $selectedKomoditas = $komoditas;
        $selectedKebun = $kebun;
        if ($regional != '' and $kebun == '') {
            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_kopi_kebun(?, ?, ?, ?) AS (
                    id integer, 
                    nama varchar, 
                    basah_merah numeric, 
                    basah_kuning numeric, 
                    basah_hijau numeric, 
                    basah_hitam numeric, 
                    total_basah numeric,
                    kering_merah numeric, 
                    kering_kuning numeric, 
                    kering_hijau numeric, 
                    kering_hitam numeric, 
                    total_kering numeric
                )',
                [$komoditas, $regional, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiKopi($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_kebun_lite(?, ?, ?, ?, ?, ?)',
                ['PANEN KOPI', $regional, '', 3, $tglAwal, $tglAkhir]
            );
        }
        if ($regional == '') {

            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_kopi_regional(?, ?, ?) AS (
                    id integer, 
                    nama varchar, 
                    basah_merah numeric, 
                    basah_kuning numeric, 
                    basah_hijau numeric, 
                    basah_hitam numeric, 
                    total_basah numeric,
                    kering_merah numeric, 
                    kering_kuning numeric, 
                    kering_hijau numeric, 
                    kering_hitam numeric, 
                    total_kering numeric
                )',
                [$komoditas, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiKopi($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_regional_lite(?, ?, ?, ?, ?)',
                ['PANEN KOPI', '', 3, $tglAwal, $tglAkhir]
            );
        }
        if ($regional != '' and $kebun != '') {

            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_kopi_afdeling(?, ?, ?, ?) AS (
                    id integer, 
                    nama varchar, 
                    basah_merah numeric, 
                    basah_kuning numeric, 
                    basah_hijau numeric, 
                    basah_hitam numeric, 
                    total_basah numeric,
                    kering_merah numeric, 
                    kering_kuning numeric, 
                    kering_hijau numeric, 
                    kering_hitam numeric, 
                    total_kering numeric
                )',
                [$komoditas, $kebun, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiKopi($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_afdeling_lite(?, ?, ?, ?, ?)',
                ['PANEN KOPI', $kebun, 3, $tglAwal, $tglAkhir]
            );
        }

        // Hitung total untuk masing-masing kolom
        if (empty($totalData)) {
            return Redirect::back()->withErrors(['msg' => 'Data tidak ditemukan untuk filter yang dipilih']);
        }


        return view('pages/dfarm/dfarm_kopi_produksi', compact('allDatakebun', 'selectedRegional', 'selectedKebun', 'selectedKomoditas', 'prestasiData', 'prestasiDataLite', 'totalData', 'tglAwal', 'tglAkhir', 'jobdesc'));
    }
    public function dfarmpemeliharaan()
    {
        $regional = $_GET['id_reg'] ?? '';
        $tglAwal = $_GET['tgl_awal'] ?? date('Y-m-d');
        $tglAkhir = $_GET['tgl_akhir'] ?? date('Y-m-d');
        $kebun = $_GET['kode_kebun'] ?? '';
        $jenis_aktivitas = $_GET['jenis_aktivitas'] ?? '19';
        $selectedaktivitas = $jenis_aktivitas;
        $komoditas = $_GET['komoditas'] ?? 1; // Default ke teh
        $datapemeliharaan = DB::connection('pgsql_secondary')
            ->table('m_jenis_aktivitas')
            ->where('comodity_id', $komoditas)
            ->where('jenis', 'pemeliharaan');
        $alldatapemeliharaan = $datapemeliharaan->get();
        if ($jenis_aktivitas) {
            $datapemeliharaan->where('id', $jenis_aktivitas);
        }
        $detaildatapemeliharaan = $datapemeliharaan->first();

        $jobdesc = $_GET['jobdesc'] ?? 'PEMETIK';


        if ($tglAwal > $tglAkhir) {
            return Redirect::back()->withErrors(['msg' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir']);
        }
        // Gunakan INNER JOIN (lebih cepat) dan tambahkan filter regional
        $data = DB::connection('pgsql_secondary')
            ->table('person_data')
            ->select('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama as nama_kebun')
            ->leftJoin('m_kebun', 'person_data.kebun_id', '=', 'm_kebun.id')
            ->whereNotNull('person_data.regional_id')
            ->orderBy('person_data.regional_id');

        if ($komoditas == 1) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Pemetik%')
                    ->orWhere('positionsdesc', 'like', '%PEMETIK%')
                    ->orWhere('positionsdesc', 'like', '%pemetik%');
            });
        }
        if ($komoditas == 2) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%penyadap%')
                    ->orWhere('positionsdesc', 'like', '%PENYADAP%')
                    ->orWhere('positionsdesc', 'like', '%penyadap%');
            });
        }
        if ($komoditas == 3) {
            $data->where(function ($query) {
                $query->where('positionsdesc', 'like', '%Panen Kopi%')
                    ->orWhere('positionsdesc', 'like', '%PANEN KOPI%')
                    ->orWhere('positionsdesc', 'like', '%panen kopi%');
            });
        }

        if ($regional) {
            $data->where('person_data.regional_id', $regional);
        }
        // Gunakan pagination untuk data besar
        $allDatakebun = $data->groupBy('person_data.kebun_id', 'person_data.regional_id', 'm_kebun.nama')
            ->get();

        $selectedRegional = $regional;
        $selectedKomoditas = $komoditas;
        $selectedKebun = $kebun;
        if ($regional != '' and $kebun == '') {
            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_pemeliharaan_kebun(?,?,?,?,?) AS (
                    id integer, 
                    nama varchar, 
                    hasil_pemeliharaan numeric
                )',
                [$komoditas, $jenis_aktivitas, $regional, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiPemeliharaan($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_kebun_lite(?, ?, ?, ?, ?, ?)',
                ['PEMELIHARAAN', $regional, '', $komoditas, $tglAwal, $tglAkhir]
            );
        }
        if ($regional == '') {

            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_pemeliharaan_regional(?, ?, ?, ?) AS (
                    id integer, 
                    nama varchar, 
                    hasil_pemeliharaan numeric
                )',
                [$komoditas, $jenis_aktivitas, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiPemeliharaan($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_regional_lite(?, ?, ?, ?, ?)',
                ['PEMELIHARAAN', '', $komoditas, $tglAwal, $tglAkhir]
            );
        }
        if ($regional != '' and $kebun != '') {

            $prestasiData = DB::connection('pgsql_secondary')->select(
                'SELECT * FROM fn_rekap_prestasi_pemeliharaan_afdeling(?,?,?,?,?) AS (
                    id integer, 
                    nama varchar, 
                    hasil_pemeliharaan numeric
                )',
                [$komoditas, $jenis_aktivitas, $kebun, $tglAwal, $tglAkhir]
            );
            $totalData = $this->calculateTotalPrestasiPemeliharaan($prestasiData);
            $prestasiDataLite = DB::connection('pgsql_secondary')->select(
                'SELECT nama, persen_input_presensi, persen_input_produksi 
                FROM fn_report_n1_karet_rekap_presensi_prestasi_afdeling_lite(?, ?, ?, ?, ?)',
                ['PEMELIHARAAN', $kebun, $komoditas, $tglAwal, $tglAkhir]
            );
        }

        // Hitung total untuk masing-masing kolom
        if (empty($totalData)) {
            return Redirect::back()->withErrors(['msg' => 'Data tidak ditemukan untuk filter yang dipilih']);
        }


        return view('pages/dfarm/dfarm_pemeliharaan', compact('allDatakebun', 'selectedRegional', 'selectedKebun', 'selectedKomoditas', 'selectedaktivitas', 'prestasiData', 'prestasiDataLite', 'totalData', 'tglAwal', 'tglAkhir', 'jobdesc', 'detaildatapemeliharaan', 'alldatapemeliharaan'));
    }
    public function dfarmtehold()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/7fba3d9e-d5ae-4f1a-91c6-22fe03e27029/page/p_wsn4ogdumd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function dfarmteh()
    {
        $linkiframe = '';
        return view('pages/dfarm/dfarm_teh_presensi');
    }
    public function dfarmkopi()
    {
        $linkiframe = '';
        return view('pages/dfarm/dfarm_kopi');
    }

    public function portalaplikasi()
    {
        // $linkiframe = 'https://portal.ptpn1.co.id/ ';
        return view('pages/portalaplikasi');
    }
    public function portallm()
    {
        // $linkiframe = 'https://portal.ptpn1.co.id/ ';
        return view('pages/portallm');
    }
    public function pengadaan()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/bbcf4582-ca61-4b4d-854f-530a830761dc/page/vJvXE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function amanah()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/e16183ff-54b1-4bc8-a0ff-49fc33a2e03e/page/ihnUE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function iot()
    {
        $linkiframe = 'http://iot-ptpn1.kotadigital.id/';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function prapengadaan()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/08f3056b-3989-4cda-8656-4b358839af74/page/p_nipa3c6qnd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function prosespengadaan()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/08f3056b-3989-4cda-8656-4b358839af74/page/jK0YE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function kontrakpengadaan()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/08f3056b-3989-4cda-8656-4b358839af74/page/p_a1szvbcrnd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function stokpengadaan()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/08f3056b-3989-4cda-8656-4b358839af74/page/p_00v9nkxjod';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function dashboardemisi()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/ef192397-646a-4137-b30a-0eabc62a9930/page/d0pYE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function soptea()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/b34767d5-a81e-499e-98de-367b7e8ccf46/page/p_9v3x2qkknd';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function skyview(Request $request)
    {
        // Jika ada ?link= dari skyview_table, gunakan itu; otherwise pakai default
        $linkiframe = $request->query('link', 'https://www.youtube.com/embed/76NgtK2Qz4w');
        return view('pages/skyview', compact('linkiframe'));
    }

    public function exec_summary()
    {
        $linkiframe = 'https://docs.google.com/presentation/d/1gtUYMn5TCy3u6Jc7KwFzhAX90zy7n0HMGASXYvov03Y/embed';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function gudangutilisasi()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/8dde5a31-7f44-4128-a71d-33586cf872ed/page/78vkF';
        $pinLocations = $this->fetchGudangPinFromSpreadsheet();
        $kapasitasMap = $this->fetchKapasitasFromNewSpreadsheet();
        $realStockUtilisasiMap = $this->fetchRealStockUtilisasiFromSpreadsheet();
        foreach ($pinLocations as &$pin) {
            $norm = preg_replace('/\s+/', '', mb_strtolower(trim((string) ($pin['unit_kebun'] ?? ''))));
            $pin['kapasitas'] = $kapasitasMap[$norm] ?? null;
            if (isset($realStockUtilisasiMap[$norm])) {
                $pin['real_stock'] = $realStockUtilisasiMap[$norm]['real_stock'] ?? null;
                $pin['utilisasi'] = $realStockUtilisasiMap[$norm]['utilisasi'] ?? null;
            } else {
                $pin['real_stock'] = null;
                $pin['utilisasi'] = null;
            }
        }
        unset($pin);
        $regionals = $this->uniqueSortedFromPins($pinLocations, 'regional');
        $unitKebuns = $this->uniqueSortedFromPins($pinLocations, 'unit_kebun');
        $jenisGudangs = $this->uniqueSortedFromPins($pinLocations, 'jenis_gudang');
        return view('pages/gudang_utilisasi', compact('linkiframe', 'pinLocations', 'regionals', 'unitKebuns', 'jenisGudangs'));
    }

    /**
     * Ambil data kapasitas dari spreadsheet baru (kolom Unit, Kapasitas/Kapsitas).
     * Return map: normalized_unit -> kapasitas (string), untuk sinkron dengan pin lama (unit kebun).
     */
    private function fetchKapasitasFromNewSpreadsheet(): array
    {
        $url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vS2r2LriHQZJLBvJt-_deCyqxlaw7gk3uc0txIXh_LUTbicR8ergKXxsoAdqFBTP1lTORXl6DBLUUVg/pub?gid=0&single=true&output=csv';
        $map = [];
        try {
            $response = Http::timeout(10)->get($url);
            if (!$response->successful()) {
                return $map;
            }
            $csv = $response->body();
            $csv = preg_replace('/^\xEF\xBB\xBF/', '', $csv);
            $csv = str_replace(["\r\n", "\r"], "\n", $csv);
            $lines = array_filter(array_map('trim', explode("\n", $csv)));
            if (count($lines) < 2) {
                return $map;
            }
            $headers = str_getcsv(array_shift($lines));
            $headers = array_map(function ($h) {
                return trim(strtolower((string) $h));
            }, $headers);
            $colUnit = null;
            $colKapasitas = null;
            foreach ($headers as $i => $h) {
                if ($h === 'unit') {
                    $colUnit = $i;
                }
                if ($h === 'kapasitas' || $h === 'kapsitas') {
                    $colKapasitas = $i;
                }
            }
            if ($colUnit === null || $colKapasitas === null) {
                return $map;
            }
            foreach ($lines as $line) {
                if ($line === '') {
                    continue;
                }
                $row = str_getcsv($line);
                $unit = isset($row[$colUnit]) ? trim((string) $row[$colUnit]) : '';
                $kapasitas = isset($row[$colKapasitas]) ? trim((string) $row[$colKapasitas]) : '';
                if ($unit !== '') {
                    $norm = preg_replace('/\s+/', '', mb_strtolower($unit));
                    $map[$norm] = $kapasitas !== '' ? $kapasitas : null;
                }
            }
        } catch (\Throwable $e) {
        }
        return $map;
    }

    /**
     * Ambil Real Stock dan Utilisasi dari spreadsheet (gid=1027423961).
     * Kolom: Unit, SUM of Stock Quantity on Period End, Utilisasi (%).
     * Return map: normalized_unit -> ['real_stock' => ..., 'utilisasi' => ...].
     */
    private function fetchRealStockUtilisasiFromSpreadsheet(): array
    {
        $url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vS2r2LriHQZJLBvJt-_deCyqxlaw7gk3uc0txIXh_LUTbicR8ergKXxsoAdqFBTP1lTORXl6DBLUUVg/pub?gid=1027423961&single=true&output=csv';
        $map = [];
        try {
            $response = Http::timeout(10)->get($url);
            if (!$response->successful()) {
                return $map;
            }
            $csv = $response->body();
            $csv = preg_replace('/^\xEF\xBB\xBF/', '', $csv);
            $csv = str_replace(["\r\n", "\r"], "\n", $csv);
            $lines = array_filter(array_map('trim', explode("\n", $csv)));
            if (count($lines) < 2) {
                return $map;
            }
            $headers = str_getcsv(array_shift($lines));
            $colUnit = null;
            $colStock = null;
            $colUtilisasi = null;
            foreach ($headers as $i => $h) {
                $hLower = trim(strtolower((string) $h));
                if ($hLower === 'unit') {
                    $colUnit = $i;
                }
                if (strpos($hLower, 'stock quantity') !== false) {
                    $colStock = $i;
                }
                if (strpos($hLower, 'utilisasi') !== false) {
                    $colUtilisasi = $i;
                }
            }
            if ($colUnit === null) {
                return $map;
            }
            foreach ($lines as $line) {
                if ($line === '') {
                    continue;
                }
                $row = str_getcsv($line);
                $unit = isset($row[$colUnit]) ? trim((string) $row[$colUnit]) : '';
                if ($unit === '') {
                    continue;
                }
                $norm = preg_replace('/\s+/', '', mb_strtolower($unit));
                $realStock = ($colStock !== null && isset($row[$colStock])) ? trim((string) $row[$colStock]) : null;
                $utilisasi = ($colUtilisasi !== null && isset($row[$colUtilisasi])) ? trim((string) $row[$colUtilisasi]) : null;
                $map[$norm] = ['real_stock' => $realStock !== '' ? $realStock : null, 'utilisasi' => $utilisasi !== '' ? $utilisasi : null];
            }
        } catch (\Throwable $e) {
        }
        return $map;
    }

    /**
     * Ambil nilai unik dari pin (regional, unit_kebun, atau jenis_gudang), trim, merge yang kembar (case-insensitive), urutkan.
     */
    private function uniqueSortedFromPins(array $pinLocations, string $key): array
    {
        $allowed = ['regional', 'unit_kebun', 'jenis_gudang'];
        $key = in_array($key, $allowed) ? $key : 'regional';
        $values = [];
        foreach ($pinLocations as $pin) {
            $v = isset($pin[$key]) ? trim((string) $pin[$key]) : '';
            if ($v !== '') {
                $k = mb_strtolower($v);
                if (!isset($values[$k])) {
                    $values[$k] = $v;
                }
            }
        }
        $list = array_values($values);
        sort($list, SORT_STRING);
        return $list;
    }

    /**
     * Ambil data lokasi gudang dari Google Spreadsheet (Lokasi Gudang PTPN I)
     * Kolom: regional, unit kebun, jenis gudang, latitude, longitude, LinkCCTV (opsional)
     */
    private function fetchGudangPinFromSpreadsheet(): array
    {
        $url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vT_BJjcONi0mkCMtW738XZ65GtljUO8S2kzxbf59pjZb5WY8nV_2Qwvd9mN-fQ53ZRQLb8FSgL2gR9D/pub?gid=0&single=true&output=csv';
        $pinLocations = [];

        try {
            $response = Http::timeout(10)->get($url);
            if (!$response->successful()) {
                return $pinLocations;
            }
            $csv = $response->body();
            $csv = preg_replace('/^\xEF\xBB\xBF/', '', $csv); // hapus UTF-8 BOM
            $csv = str_replace(["\r\n", "\r"], "\n", $csv);
            $lines = array_filter(array_map('trim', explode("\n", $csv)));
            if (count($lines) < 2) {
                return $pinLocations;
            }
            $headers = str_getcsv(array_shift($lines));
            $headers = array_map(function ($h) {
                return trim(strtolower((string) $h));
            }, $headers);
            $colIdx = [
                'regional' => null,
                'unit kebun' => null,
                'jenis gudang' => null,
                'latitude' => null,
                'longitude' => null,
                'linkcctv' => null,
            ];
            $aliases = [
                'lat' => 'latitude',
                'lng' => 'longitude',
                'long' => 'longitude',
                'unit' => 'unit kebun',
                'jenis' => 'jenis gudang',
                'link cctv' => 'linkcctv',
            ];
            foreach ($headers as $i => $h) {
                if (isset($colIdx[$h])) {
                    $colIdx[$h] = $i;
                } elseif (isset($aliases[$h])) {
                    $colIdx[$aliases[$h]] = $i;
                } elseif (preg_match('/^link\s*cctv$/i', $h)) {
                    $colIdx['linkcctv'] = $i;
                }
            }
            // Fallback: urutan kolom standar (Regional, Unit Kebun, Jenis Gudang, Latitude, Longitude)
            if ($colIdx['latitude'] === null || $colIdx['longitude'] === null) {
                $n = count($headers);
                if ($n >= 5) {
                    $colIdx['regional'] = 0;
                    $colIdx['unit kebun'] = 1;
                    $colIdx['jenis gudang'] = 2;
                    $colIdx['latitude'] = 3;
                    $colIdx['longitude'] = 4;
                }
            }
            $hasRequired = ($colIdx['latitude'] !== null && $colIdx['longitude'] !== null);
            if (!$hasRequired) {
                return $pinLocations;
            }
            foreach ($lines as $line) {
                if ($line === '') {
                    continue;
                }
                $row = str_getcsv($line);
                $latRaw = isset($row[$colIdx['latitude']]) ? trim($row[$colIdx['latitude']]) : '';
                $lngRaw = isset($row[$colIdx['longitude']]) ? trim($row[$colIdx['longitude']]) : '';
                // Normalisasi: koma sebagai pemisah desimal (format Indonesia) -> titik
                $lat = $latRaw === '' ? null : str_replace(',', '.', $latRaw);
                $lng = $lngRaw === '' ? null : str_replace(',', '.', $lngRaw);
                if ($lat === null || $lng === null || !is_numeric($lat) || !is_numeric($lng)) {
                    continue;
                }
                $lat = (float) $lat;
                $lng = (float) $lng;
                if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
                    continue;
                }
                // Abaikan koordinat di luar wilayah Indonesia (kurang lebih)
                if ($lat < -11 || $lat > 7 || $lng < 90 || $lng > 145) {
                    continue;
                }
                $regional = $colIdx['regional'] !== null && isset($row[$colIdx['regional']]) ? trim($row[$colIdx['regional']]) : '-';
                $unitKebun = $colIdx['unit kebun'] !== null && isset($row[$colIdx['unit kebun']]) ? trim($row[$colIdx['unit kebun']]) : '-';
                $jenisGudang = $colIdx['jenis gudang'] !== null && isset($row[$colIdx['jenis gudang']]) ? trim($row[$colIdx['jenis gudang']]) : '-';
                $linkCctv = $colIdx['linkcctv'] !== null && isset($row[$colIdx['linkcctv']]) ? trim($row[$colIdx['linkcctv']]) : '';

                // Cari foto kebun berdasarkan nama unit kebun di folder public/fotokebun/...
                $photoUrl = '';
                if ($unitKebun !== '-' && $unitKebun !== '') {
                    $unitNameRaw = trim($unitKebun);
                    $baseRoot = public_path('fotokebun');
                    if (is_dir($baseRoot)) {
                        $candidateDirs = [];
                        // 1) Langsung folder dengan nama persis unit kebun
                        $directDir = $baseRoot . DIRECTORY_SEPARATOR . $unitNameRaw;
                        if (is_dir($directDir)) {
                            $candidateDirs[] = $directDir;
                        }
                        // 2) Pola "Kebun_{UnitKebun}" (contoh: Kebun_cisaruni)
                        if (empty($candidateDirs)) {
                            $kebunDir1 = $baseRoot . DIRECTORY_SEPARATOR . ('Kebun_' . $unitNameRaw);
                            $kebunDir2 = $baseRoot . DIRECTORY_SEPARATOR . ('Kebun_' . ucfirst(strtolower($unitNameRaw)));
                            if (is_dir($kebunDir1)) {
                                $candidateDirs[] = $kebunDir1;
                            } elseif (is_dir($kebunDir2)) {
                                $candidateDirs[] = $kebunDir2;
                            }
                        }
                        // 3) Fallback: cari subfolder yang namanya mengandung unit kebun (di-normalisasi)
                        if (empty($candidateDirs)) {
                            $normalizedUnit = strtolower(preg_replace('/\s+/', '', $unitNameRaw));
                            $subdirs = glob($baseRoot . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
                            if ($subdirs !== false) {
                                foreach ($subdirs as $dir) {
                                    $name = strtolower(basename($dir));
                                    $normalizedName = str_replace([' ', '_', '-'], '', $name);
                                    if (strpos($normalizedName, $normalizedUnit) !== false) {
                                        $candidateDirs[] = $dir;
                                        break;
                                    }
                                }
                            }
                        }
                        if (!empty($candidateDirs)) {
                            $baseDir = $candidateDirs[0];
                            $patterns = ['*.jpg', '*.jpeg', '*.png', '*.webp', '*.JPG', '*.JPEG', '*.PNG', '*.WEBP'];
                            $files = [];
                            foreach ($patterns as $pattern) {
                                $found = glob($baseDir . DIRECTORY_SEPARATOR . $pattern);
                                if ($found !== false) {
                                    $files = array_merge($files, $found);
                                }
                            }
                            if (!empty($files)) {
                                $first = $files[0];
                                // Buat path relatif dari public path agar URL benar
                                $relative = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $first);
                                $relative = str_replace(DIRECTORY_SEPARATOR, '/', $relative);
                                $photoUrl = asset($relative);
                            }
                        }
                    }
                }

                $pinLocations[] = [
                    'lat' => $lat,
                    'lng' => $lng,
                    'regional' => $regional,
                    'unit_kebun' => $unitKebun,
                    'jenis_gudang' => $jenisGudang,
                    'link_cctv' => $linkCctv,
                    'photo_url' => $photoUrl,
                ];
            }
        } catch (\Throwable $e) {
            // tetap return array kosong jika gagal
        }
        return $pinLocations;
    }

    public function aigri()
    {

        return view('pages/aigr1');
    }

    public function gardai()
    {
        $linkiframe = 'https://stg-garda.ptpn1.co.id/monitoring/Y9ueuIO5YP2Tyy19xuL7';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function lm13()
    {
        $plantList = Plant::orderBy('plant', 'asc')->get();
        $regionalList = Plant::distinct()->orderBy('regional', 'asc')->get(['regional']);
        $tahunSekarang = (int) date('Y');
        $tahunList = range($tahunSekarang, $tahunSekarang + 9); // [2026, 2027, ..., 2035]

        return view('pages/lm13', compact('plantList', 'regionalList', 'tahunList', 'tahunSekarang'));
    }

    public function lm14()
    {

        $regionalList = Plant::distinct()->orderBy('regional', 'asc')->get(['regional']);
        $plantList = Plant::orderBy('plant', 'asc')->get();
        $tahunSekarang = (int) date('Y');
        $tahunList = range($tahunSekarang, $tahunSekarang + 9); // [2026, 2027, ..., 2035]

        return view('pages/lm14', compact('plantList', 'regionalList', 'tahunList', 'tahunSekarang'));
    }

    public function lm16()
    {
        $plantList = Plant::orderBy('plant', 'asc')->get();
        $regionalList = Plant::distinct()->orderBy('regional', 'asc')->get(['regional']);
        $tahunSekarang = (int) date('Y');
        $tahunList = range($tahunSekarang, $tahunSekarang + 9); // [2026, 2027, ..., 2035]

        return view('pages/lm16', compact('plantList', 'regionalList', 'tahunList', 'tahunSekarang'));
    }

    public function under_construction()
    {
        return view('pages/under-construction');
    }

}
