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
        // $linkiframe = 'https://lookerstudio.google.com/embed/reporting/0c40fa91-90ba-474a-becc-f1b48ccd7553/page/p_fjvzqqpxmd';
        $linkiframe = 'https://datastudio.google.com/embed/reporting/b17761d1-5bbe-42f5-bf3f-d036385e7b0c/page/p_fjvzqqpxmd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function onfarmteh()
    {
        $linkiframe = 'https://datastudio.google.com/embed/reporting/e825898d-0a18-4e28-a258-9b4e83aff7b1/page/p_hsaddeiwmd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function onfarmkopi()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/107ef939-e0ce-4084-a50b-a9d526a368bc/page/p_ee90olr1md';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function offfarmkaret()
    {
        $linkiframe = 'https://datastudio.google.com/embed/reporting/b3d7816f-810b-4609-9d64-2db9bd818301/page/p_y59zpdpxmd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function offfarmteh()
    {
        $linkiframe = 'https://datastudio.google.com/embed/reporting/f0f0edeb-4e91-4306-910e-64389351f433/page/p_o6yw3alxmd';
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
    public function sapaEvaluasi()
    {
        return view('pages/dfarm/sapa_evaluasi');
    }
    public function bpdEvaluasi()
    {
        $db_bidang = DB::connection('pgsql_bpd')
            ->table('m_bidang as mb')
            ->select(
                'mb.nama as nama_bidang',
                'mb.id'
            )
            ->Where('is_deleted','FALSE')
            ->get();
        $tglAwal = date('Y-m-d');
        $tglAkhir = date('Y-m-d');
        $bidangData = $this->getBidangWithStatus($tglAwal, $tglAkhir);
        // dd($bidangData);
        return view('pages/dfarm/bpd_evaluasi', compact('bidangData', 'db_bidang'));
    }
    public function SelectListBpdBiaya(Request $request)
    {
        $param1 = '';
        $param2 = '';
        $param3 = '';

        // Start with a clean query instance
        $query = DB::connection('pgsql_bpd')->query();

        // Use fromRaw directly on the query builder instance, NOT the connection
        $query->fromRaw("fn_list_bpd_biaya(?, ?, ?) as pd", [$param1, $param2, $param3]);

        if ($request->has('tgl_awal') && $request->has('tgl_akhir')) {
            $query->whereBetween('tgl_berangkat', [$request->input('tgl_awal'), $request->input('tgl_akhir')]);
        }

        if ($request->has('bidang_id')) {
            $query->where('id_bidang', $request->input('bidang_id'));
        }

        if ($request->filled('nama_pegawai')) {
            $namaSearch = '%' . $request->input('nama_pegawai') . '%';

            // Bungkus di dalam fungsi closure agar menghasilkan: AND (nama_pegawai ILIKE ... OR nama_rombongan ILIKE ...)
            $query->where(function ($q) use ($namaSearch) {
                $q->where('pd.nama_pegawai', 'ilike', $namaSearch)
                ->orWhere('pd.nama_rombongan', 'ilike', $namaSearch)
                ->orWhere('pd.nomor', 'ilike', $namaSearch); // Pastikan orWhere huruf kecil
            });
        }

        if ($request->has('keterangan')) {
            $keperluanSearch = '%' . $request->input('keterangan') . '%';

            // Bungkus di dalam fungsi closure agar menghasilkan: AND (keperluan ILIKE ... OR tujuan ILIKE ...)
            $query->where(function ($q) use ($keperluanSearch) {
                $q->where('keperluan', 'ilike', $keperluanSearch)
                ->orWhere('tujuan', 'ilike', $keperluanSearch)
                ->orWhere('lokasi_kota', 'ilike', $keperluanSearch); // Pastikan orWhere huruf kecil
            });
        }

        $data = $query->orderBy('nomor', 'desc')
            ->get();

        return response()->json($data);
    }


    /**
     * Get data bidang dengan status SPPD dan BPD
     * @param string $tglAwal Tanggal awal filter (format: Y-m-d)
     * @param string $tglAkhir Tanggal akhir filter (format: Y-m-d)
     * @param string|null $bidangId ID bidang untuk filter spesifik
     * @param string|null $branchId ID branch untuk filter
     * @return array Array of bidang dengan status count
     */
    private function getBidangWithStatus($tglAwal = '', $tglAkhir = '', $bidangId = '', $branchId = '')
    {
        // Jika parameter kosong, gunakan default
        if (!$tglAwal)
            $tglAwal = '';
        if (!$tglAkhir)
            $tglAkhir = '';

        $query = DB::connection('pgsql_bpd')
            ->table('m_bidang as mb')
            ->select(
                'mb.nama as nama_bidang',
                'mb.id',
                DB::raw("COALESCE(sppd_draft.total, 0) as sppd_draft"),
                DB::raw("COALESCE(sppd_pengajuan.total, 0) as sppd_pengajuan"),
                DB::raw("COALESCE(sppd_disetujui.total, 0) as sppd_disetujui"),
                DB::raw("COALESCE(sppd_revisi.total, 0) as sppd_revisi"),
                DB::raw("COALESCE(bpd_draft.total, 0) as bpd_draft"),
                DB::raw("COALESCE(bpd_pengajuan.total, 0) as bpd_pengajuan"),
                DB::raw("COALESCE(bpd_disetujui.total, 0) as bpd_disetujui"),
                DB::raw("COALESCE(bpd_revisi.total, 0) as bpd_revisi")
            )
            // SPPD Draft
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('surat_perjalanan_dinas as spd')
                    ->join('m_pegawai as mp', 'spd.id_pegawai', '=', 'mp.id')
                    ->select('mp.id_bidang', DB::raw('COUNT(*) as total'))
                    ->where('spd.status', '0')
                    ->where(function ($query) use ($tglAwal, $tglAkhir) {
                        if ($tglAwal)
                            $query->where('spd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $query->where('spd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->where(function ($query) use ($branchId) {
                        if ($branchId)
                            $query->where('spd.id_branch', $branchId);
                    })
                    ->whereRaw('COALESCE(spd.is_deleted, false) = false')
                    ->groupBy('mp.id_bidang'),
                'sppd_draft',
                'mb.id',
                '=',
                'sppd_draft.id_bidang'
            )
            // SPPD Pengajuan
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('surat_perjalanan_dinas as spd')
                    ->join('m_pegawai as mp', 'spd.id_pegawai', '=', 'mp.id')
                    ->select('mp.id_bidang', DB::raw('COUNT(*) as total'))
                    ->where('spd.status', '1')
                    ->where(function ($query) use ($tglAwal, $tglAkhir) {
                        if ($tglAwal)
                            $query->where('spd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $query->where('spd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->where(function ($query) use ($branchId) {
                        if ($branchId)
                            $query->where('spd.id_branch', $branchId);
                    })
                    ->whereRaw('COALESCE(spd.is_deleted, false) = false')
                    ->groupBy('mp.id_bidang'),
                'sppd_pengajuan',
                'mb.id',
                '=',
                'sppd_pengajuan.id_bidang'
            )
            // SPPD Disetujui
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('surat_perjalanan_dinas as spd')
                    ->join('m_pegawai as mp', 'spd.id_pegawai', '=', 'mp.id')
                    ->select('mp.id_bidang', DB::raw('COUNT(*) as total'))
                    ->where('spd.status', '2')
                    ->where(function ($query) use ($tglAwal, $tglAkhir) {
                        if ($tglAwal)
                            $query->where('spd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $query->where('spd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->where(function ($query) use ($branchId) {
                        if ($branchId)
                            $query->where('spd.id_branch', $branchId);
                    })
                    ->whereRaw('COALESCE(spd.is_deleted, false) = false')
                    ->groupBy('mp.id_bidang'),
                'sppd_disetujui',
                'mb.id',
                '=',
                'sppd_disetujui.id_bidang'
            )
            // SPPD Revisi
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('surat_perjalanan_dinas as spd')
                    ->join('m_pegawai as mp', 'spd.id_pegawai', '=', 'mp.id')
                    ->select('mp.id_bidang', DB::raw('COUNT(*) as total'))
                    ->where('spd.status', '3')
                    ->where(function ($query) use ($tglAwal, $tglAkhir) {
                        if ($tglAwal)
                            $query->where('spd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $query->where('spd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->where(function ($query) use ($branchId) {
                        if ($branchId)
                            $query->where('spd.id_branch', $branchId);
                    })
                    ->whereRaw('COALESCE(spd.is_deleted, false) = false')
                    ->groupBy('mp.id_bidang'),
                'sppd_revisi',
                'mb.id',
                '=',
                'sppd_revisi.id_bidang'
            )
            // BPD Draft
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('perjalanan_dinas as pd')
                    ->join('perjalanan_dinas_pegawai as pdp', 'pd.id', '=', 'pdp.id_perjalanan_dinas')
                    ->join('m_pegawai as mp', 'pdp.id_pegawai', '=', 'mp.id')
                    ->select('mp.id_bidang', DB::raw('COUNT(*) as total'))
                    ->where('pd.status', '0')
                    ->where(function ($query) use ($tglAwal, $tglAkhir) {
                        if ($tglAwal)
                            $query->where('pd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $query->where('pd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->where(function ($query) use ($branchId) {
                        if ($branchId)
                            $query->where('pd.id_branch', $branchId);
                    })
                    ->whereRaw('COALESCE(pd.is_deleted, false) = false')
                    ->groupBy('mp.id_bidang'),
                'bpd_draft',
                'mb.id',
                '=',
                'bpd_draft.id_bidang'
            )
            // BPD Pengajuan
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('perjalanan_dinas as pd')
                    ->join('perjalanan_dinas_pegawai as pdp', 'pd.id', '=', 'pdp.id_perjalanan_dinas')
                    ->join('m_pegawai as mp', 'pdp.id_pegawai', '=', 'mp.id')
                    ->select('mp.id_bidang', DB::raw('COUNT(*) as total'))
                    ->where('pd.status', '1')
                    ->where(function ($query) use ($tglAwal, $tglAkhir) {
                        if ($tglAwal)
                            $query->where('pd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $query->where('pd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->where(function ($query) use ($branchId) {
                        if ($branchId)
                            $query->where('pd.id_branch', $branchId);
                    })
                    ->whereRaw('COALESCE(pd.is_deleted, false) = false')
                    ->groupBy('mp.id_bidang'),
                'bpd_pengajuan',
                'mb.id',
                '=',
                'bpd_pengajuan.id_bidang'
            )
            // BPD Disetujui
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('perjalanan_dinas as pd')
                    ->join('perjalanan_dinas_pegawai as pdp', 'pd.id', '=', 'pdp.id_perjalanan_dinas')
                    ->join('m_pegawai as mp', 'pdp.id_pegawai', '=', 'mp.id')
                    ->select('mp.id_bidang', DB::raw('COUNT(*) as total'))
                    ->where('pd.status', '2')
                    ->where(function ($query) use ($tglAwal, $tglAkhir) {
                        if ($tglAwal)
                            $query->where('pd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $query->where('pd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->where(function ($query) use ($branchId) {
                        if ($branchId)
                            $query->where('pd.id_branch', $branchId);
                    })
                    ->whereRaw('COALESCE(pd.is_deleted, false) = false')
                    ->groupBy('mp.id_bidang'),
                'bpd_disetujui',
                'mb.id',
                '=',
                'bpd_disetujui.id_bidang'
            )
            // BPD Revisi
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('perjalanan_dinas as pd')
                    ->join('perjalanan_dinas_pegawai as pdp', 'pd.id', '=', 'pdp.id_perjalanan_dinas')
                    ->join('m_pegawai as mp', 'pdp.id_pegawai', '=', 'mp.id')
                    ->select('mp.id_bidang', DB::raw('COUNT(*) as total'))
                    ->where('pd.status', '3')
                    ->where(function ($query) use ($tglAwal, $tglAkhir) {
                        if ($tglAwal)
                            $query->where('pd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $query->where('pd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->where(function ($query) use ($branchId) {
                        if ($branchId)
                            $query->where('pd.id_branch', $branchId);
                    })
                    ->whereRaw('COALESCE(pd.is_deleted, false) = false')
                    ->groupBy('mp.id_bidang'),
                'bpd_revisi',
                'mb.id',
                '=',
                'bpd_revisi.id_bidang'
            )
            ->where('mb.is_deleted', false);

        // Apply bidang filter jika ada
        if ($bidangId) {
            $query->where('mb.id', $bidangId);
        }

        $data = $query->orderBy('mb.nama')->get();
        return $data;
    }

    public function getBidangStatusApi()
    {
        try {
            $tglAwal = request()->get('tgl_awal', '');
            $tglAkhir = request()->get('tgl_akhir', '');
            $bidangId = request()->get('bidang_id', '');
            $branchId = request()->get('branch_id', '');

            // Validate dates if provided
            if ($tglAwal && !$this->isValidDate($tglAwal)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format tanggal awal tidak valid (gunakan format Y-m-d)'
                ], 400);
            }
            if ($tglAkhir && !$this->isValidDate($tglAkhir)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format tanggal akhir tidak valid (gunakan format Y-m-d)'
                ], 400);
            }

            // Get data
            $bidangData = $this->getBidangWithStatus($tglAwal, $tglAkhir, $bidangId, $branchId);

            return response()->json([
                'success' => true,
                'data' => $bidangData,
                'count' => count($bidangData)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function isValidDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * Get biaya dan anggaran per bidang
     * @param string $tglAwal Tanggal awal filter (format: Y-m-d)
     * @param string $tglAkhir Tanggal akhir filter (format: Y-m-d)
     * @param string $bidangId ID bidang untuk filter spesifik (optional)
     * @return \Illuminate\Support\Collection Array of bidang dengan biaya, anggaran, dan sisa anggaran
     */
    private function getBiayaAnggaranBidang($tglAwal = '', $tglAkhir = '', $bidangId = '')
    {
        $tahunAnggaran = date('Y');

        $query = DB::connection('pgsql_bpd')
            ->table('m_bidang as mb')
            ->select(
                'ab.id as id_anggaran',
                'mb.id as id_bidang',
                'mb.nama as bidang',
                DB::raw("COALESCE(biaya_summary.total_biaya, 0) as total_biaya"),
                DB::raw("COALESCE(ab.anggaran, 0) as anggaran"),
                DB::raw("COALESCE(ab.anggaran, 0) - COALESCE(biaya_summary.total_biaya, 0) as sisa_anggaran")
            )
            ->leftJoin('m_anggaran_bidang as ab', function ($join) use ($tahunAnggaran) {
                $join->on('mb.id', '=', 'ab.id_bidang')
                    ->where('ab.tahun_anggaran', '=', $tahunAnggaran);
            })
            ->leftJoinSub(
                DB::connection('pgsql_bpd')
                    ->table('m_pegawai as mp')
                    ->leftJoin('perjalanan_dinas_pegawai as pdp', 'pdp.id_pegawai', '=', 'mp.id')
                    ->leftJoin('perjalanan_dinas as pd', function ($join) use ($tglAwal, $tglAkhir) {
                        $join->on('pd.id', '=', 'pdp.id_perjalanan_dinas')
                            ->where('pd.id_jenis_perjalanan_dinas', '=', 'true');
                        if ($tglAwal)
                            $join->whereDate('pd.tgl_berangkat', '>=', $tglAwal);
                        if ($tglAkhir)
                            $join->whereDate('pd.tgl_berangkat', '<=', $tglAkhir);
                    })
                    ->leftJoin('perjalanan_dinas_biaya as pdb', function ($join) {
                        $join->on('pdp.id', '=', 'pdb.id_bpd_pegawai')
                            ->where('pdb.is_deleted', false);
                    })
                    ->whereNotNull('pd.id')
                    ->select('mp.id_bidang', DB::raw('SUM(pdb.nominal::numeric) as total_biaya'))
                    ->groupBy('mp.id_bidang'),
                'biaya_summary',
                'mb.id',
                '=',
                'biaya_summary.id_bidang'
            )
            ->where('mb.nama', '!=', null)
            ->where(DB::raw('COALESCE(mb.is_deleted, false)'), false)
            ->when($bidangId, function ($query) use ($bidangId) {
                return $query->where('mb.id', $bidangId);
            })
            ->groupBy('mb.id', 'mb.nama', 'ab.id', 'ab.anggaran', 'biaya_summary.total_biaya')
            ->havingRaw("COALESCE(biaya_summary.total_biaya, 0) > 0 OR COALESCE(ab.anggaran, 0) > 0")
            ->orderBy('mb.nama');

        return $query->get();
    }

    public function getBiayaAnggaranApi()
    {
        try {
            $tglAwal = request()->get('tgl_awal', '');
            $tglAkhir = request()->get('tgl_akhir', '');
            $bidangId = request()->get('bidang_id', '');

            // Validate dates if provided
            if ($tglAwal && !$this->isValidDate($tglAwal)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format tanggal awal tidak valid (gunakan format Y-m-d)'
                ], 400);
            }
            if ($tglAkhir && !$this->isValidDate($tglAkhir)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format tanggal akhir tidak valid (gunakan format Y-m-d)'
                ], 400);
            }

            // Get data
            $biayaData = $this->getBiayaAnggaranBidang($tglAwal, $tglAkhir, $bidangId);

            return response()->json([
                'success' => true,
                'data' => $biayaData,
                'count' => count($biayaData)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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
    public function ajax_dfarmtehproduksi(Request $request)
    {
        // Validate input parameters
        $request->validate([
            'id_reg' => 'nullable|string',
            'tgl_awal' => 'nullable|date_format:Y-m-d',
            'tgl_akhir' => 'nullable|date_format:Y-m-d',
            'kode_kebun' => 'nullable|string',
            'jobdesc' => 'nullable|string',
        ]);

        $regional = $request->input('id_reg', '');
        $tglAwal = $request->input('tgl_awal', date('Y-m-d'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $kebun = $request->input('kode_kebun', '');
        $jobdesc = $request->input('jobdesc', 'PEMETIK');
        $komoditas = 1;

        if ($tglAwal > $tglAkhir) {
            return response()->json(['error' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir'], 400);
        }

        // Initialize variables
        $prestasiData = [];
        $prestasiDataLite = [];
        $totalData = [];

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
        if (empty($prestasiData) || empty($totalData)) {
            return response()->json([
                'error' => 'Data tidak ditemukan untuk filter yang dipilih',
                'success' => false
            ], 404);
        }

        $dataoutput = [
            'success' => true,
            'allDatakebun' => $allDatakebun,
            'selectedRegional' => $selectedRegional,
            'selectedKebun' => $selectedKebun,
            'selectedKomoditas' => $selectedKomoditas,
            'prestasiData' => $prestasiData,
            'prestasiDataLite' => $prestasiDataLite,
            'totalData' => $totalData,
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
            'jobdesc' => $jobdesc
        ];

        return response()->json($dataoutput, 200)
            ->header('Content-Type', 'application/json; charset=utf-8');
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
    public function ajax_dfarmkopiproduksi(Request $request)
    {
        // Validate input parameters
        $request->validate([
            'id_reg' => 'nullable|string',
            'tgl_awal' => 'nullable|date_format:Y-m-d',
            'tgl_akhir' => 'nullable|date_format:Y-m-d',
            'kode_kebun' => 'nullable|string',
            'jobdesc' => 'nullable|string',
        ]);

        $regional = $request->input('id_reg', '');
        $tglAwal = $request->input('tgl_awal', date('Y-m-d'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $kebun = $request->input('kode_kebun', '');
        $jobdesc = $request->input('jobdesc', 'PANEN KOPI');
        $komoditas = 3;

        if ($tglAwal > $tglAkhir) {
            return response()->json(['error' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir'], 400);
        }

        // Initialize variables
        $prestasiData = [];
        $prestasiDataLite = [];
        $totalData = [];

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
        if (empty($prestasiData) || empty($totalData)) {
            return response()->json([
                'error' => 'Data tidak ditemukan untuk filter yang dipilih',
                'success' => false
            ], 404);
        }

        $dataoutput = [
            'success' => true,
            'allDatakebun' => $allDatakebun,
            'selectedRegional' => $selectedRegional,
            'selectedKebun' => $selectedKebun,
            'selectedKomoditas' => $selectedKomoditas,
            'prestasiData' => $prestasiData,
            'prestasiDataLite' => $prestasiDataLite,
            'totalData' => $totalData,
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
            'jobdesc' => $jobdesc
        ];

        return response()->json($dataoutput, 200)
            ->header('Content-Type', 'application/json; charset=utf-8');
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
    public function ajax_dfarmpemeliharaan(Request $request)
    {
        // Validate input parameters
        $request->validate([
            'id_reg' => 'nullable|string',
            'tgl_awal' => 'nullable|date_format:Y-m-d',
            'tgl_akhir' => 'nullable|date_format:Y-m-d',
            'kode_kebun' => 'nullable|string',
            'jenis_aktivitas' => 'nullable|string',
            'jobdesc' => 'nullable|string',
        ]);

        $regional = $request->input('id_reg', '');
        $tglAwal = $request->input('tgl_awal', date('Y-m-d'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $kebun = $request->input('kode_kebun', '');
        $jenis_aktivitas = $request->input('jenis_aktivitas', '19');
        $jobdesc = $request->input('jobdesc', 'PEMELIHARAAN');
        $komoditas = $request->input('komoditas', 1);

        if ($tglAwal > $tglAkhir) {
            return response()->json(['error' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir'], 400);
        }

        // Initialize variables
        $prestasiData = [];
        $prestasiDataLite = [];
        $totalData = [];

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
        if (empty($prestasiData) || empty($totalData)) {
            return response()->json([
                'error' => 'Data tidak ditemukan untuk filter yang dipilih',
                'success' => false
            ], 404);
        }

        $dataoutput = [
            'success' => true,
            'allDatakebun' => $allDatakebun,
            'selectedRegional' => $selectedRegional,
            'selectedKebun' => $selectedKebun,
            'selectedKomoditas' => $selectedKomoditas,
            'prestasiData' => $prestasiData,
            'prestasiDataLite' => $prestasiDataLite,
            'totalData' => $totalData,
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
            'jobdesc' => $jobdesc,
            'jenis_aktivitas' => $jenis_aktivitas
        ];

        return response()->json($dataoutput, 200)
            ->header('Content-Type', 'application/json; charset=utf-8');
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

    public function lm34()
    {
        $plantList = Plant::orderBy('plant', 'asc')->get();
        $regionalList = Plant::distinct()->orderBy('regional', 'asc')->get(['regional']);
        $tahunSekarang = (int) date('Y');
        $tahunList = range($tahunSekarang, $tahunSekarang + 9); // [2026, 2027, ..., 2035]

        return view('pages/lm34', compact('plantList', 'regionalList', 'tahunList', 'tahunSekarang'));
    }

    public function lm34_tab()
    {
        $plantList = Plant::orderBy('plant', 'asc')->get();
        $regionalList = Plant::distinct()->orderBy('regional', 'asc')->get(['regional']);
        $tahunSekarang = (int) date('Y');
        $tahunList = range($tahunSekarang, $tahunSekarang + 9); // [2026, 2027, ..., 2035]

        return view('pages/lm34_tab', compact('plantList', 'regionalList', 'tahunList', 'tahunSekarang'));
    }

    public function lm62()
    {
        $plantList = Plant::orderBy('plant', 'asc')->get();
        $regionalList = Plant::distinct()->orderBy('regional', 'asc')->get(['regional']);
        $tahunSekarang = (int) date('Y');
        $tahunList = range($tahunSekarang, $tahunSekarang + 9); // [2026, 2027, ..., 2035]

        return view('pages/lm62', compact('plantList', 'regionalList', 'tahunList', 'tahunSekarang'));
    }

    public function under_construction()
    {
        return view('pages/under-construction');
    }

    public function evaluasi_aplikasi()
    {
        // Deteksi akses via token URL — locked ke HRIS readonly
        $tokenMode = session('url_token_valid') === true;
        return view('pages/evaluasi', compact('tokenMode'));
    }

    private const HRIS_REGIONAL_FILTER = 'SuppCo HO';

    /** Jenis absen yang dihitung sebagai absensi */
    private const HRIS_JENIS_ABSENSI = ['WFO', 'WFH', 'IZIN', 'DINAS'];

    public function evaluasi_hris_data(Request $request)
    {
        $periode = $request->get('periode', date('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format periode tidak valid (gunakan YYYY-MM).',
            ], 400);
        }

        [$tahun, $bulan] = array_map('intval', explode('-', $periode));

        try {
            $rows = $this->fetchRekapAbsenHrisByDivisi($tahun, $bulan);
            $summary = $this->fetchRekapAbsenRegionalSummary($tahun, $bulan);

            return response()->json([
                'status' => 'success',
                'periode' => $periode,
                'regional' => self::HRIS_REGIONAL_FILTER,
                'total' => count($rows),
                'summary' => $summary,
                'data' => $rows,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function evaluasi_hris_detail(Request $request)
    {
        $periode = $request->get('periode', date('Y-m'));
        $divisi = trim((string) $request->get('divisi', ''));

        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format periode tidak valid (gunakan YYYY-MM).',
            ], 400);
        }

        if ($divisi === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter divisi wajib diisi.',
            ], 400);
        }

        [$tahun, $bulan] = array_map('intval', explode('-', $periode));

        try {
            $rows = $this->fetchRekapAbsenHrisByPegawai($tahun, $bulan, $divisi);

            return response()->json([
                'status' => 'success',
                'periode' => $periode,
                'divisi' => $divisi,
                'regional' => self::HRIS_REGIONAL_FILTER,
                'total' => count($rows),
                'data' => $rows,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function evaluasi_hris_divisi(Request $request)
    {
        $periode = $request->get('periode', date('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format periode tidak valid (gunakan YYYY-MM).',
            ], 400);
        }

        try {
            $rows = $this->fetchDivisiList(self::HRIS_REGIONAL_FILTER);

            return response()->json([
                'status' => 'success',
                'periode' => $periode,
                'regional' => self::HRIS_REGIONAL_FILTER,
                'data' => $rows,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function evaluasi_hris_harian(Request $request)
    {
        $periode = $request->get('periode', date('Y-m'));
        $divisi = trim((string) $request->get('divisi', ''));
        $tanggal = trim((string) $request->get('tanggal', ''));

        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format periode tidak valid (gunakan YYYY-MM).',
            ], 400);
        }

        if ($tanggal !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format tanggal tidak valid (gunakan YYYY-MM-DD).',
            ], 400);
        }

        if ($tanggal === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter tanggal wajib diisi.',
            ], 400);
        }

        [$tahun, $bulan] = array_map('intval', explode('-', $periode));
        $periodePrefix = sprintf('%04d-%02d', $tahun, $bulan);
        if (strpos($tanggal, $periodePrefix) !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tanggal harus berada dalam periode yang dipilih.',
            ], 400);
        }

        try {
            $rows = $this->fetchAbsenHarian($tahun, $bulan, $divisi, $tanggal);

            // Filter by status if requested
            $status = trim((string) $request->get('status', ''));
            if ($status !== '') {
                $rows = array_values(array_filter($rows, function ($row) use ($status) {
                    $isBelumAbsen = ($row->checkin_time === '-' && $row->checkout_time === '-');
                    if (strtolower($status) === 'sudah') {
                        return !$isBelumAbsen;
                    } elseif (strtolower($status) === 'belum') {
                        return $isBelumAbsen;
                    }
                    return true;
                }));
            }

            return response()->json([
                'status' => 'success',
                'periode' => $periode,
                'divisi' => $divisi,
                'tanggal' => $tanggal,
                'regional' => self::HRIS_REGIONAL_FILTER,
                'total' => count($rows),
                'data' => $rows,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function periodeYmToHris(int $tahun, int $bulan): string
    {
        return str_pad((string) $bulan, 2, '0', STR_PAD_LEFT) . $tahun;
    }

    private function hrisUsesImportData(string $periodeHris): bool
    {
        $importCount = DB::connection('hris')
            ->selectOne('SELECT COUNT(*) AS c FROM absensi_import WHERE periode = ?', [$periodeHris]);

        return ($importCount->c ?? 0) > 0;
    }

    private function fetchDivisiList(string $regional): array
    {
        return DB::connection('hris')->select("
            SELECT DISTINCT TRIM(divisi) AS divisi
            FROM pegawai
            WHERE TRIM(regional) = ?
              AND NULLIF(TRIM(divisi), '') IS NOT NULL
              AND (penugasan_mutasi_ke IS NULL OR TRIM(penugasan_mutasi_ke) = '')
              AND (status_ckp IS NULL OR status_ckp != 'Ya')
            ORDER BY divisi ASC
        ", [$regional]);
    }

    private function fetchRekapAbsenHrisByDivisi(int $tahun, int $bulan): array
    {
        $periodeHris = $this->periodeYmToHris($tahun, $bulan);

        if ($this->hrisUsesImportData($periodeHris)) {
            return $this->fetchRekapAbsenFromImport($periodeHris);
        }

        return $this->fetchRekapAbsenFromAbsensi($periodeHris);
    }

    private function fetchRekapAbsenRegionalSummary(int $tahun, int $bulan): ?object
    {
        $periodeHris = $this->periodeYmToHris($tahun, $bulan);

        if ($this->hrisUsesImportData($periodeHris)) {
            return $this->fetchRegionalSummaryFromImport($periodeHris);
        }

        return $this->fetchRegionalSummaryFromAbsensi($periodeHris);
    }

    private function fetchRegionalSummaryFromImport(string $periodeHris): ?object
    {
        $regional = self::HRIS_REGIONAL_FILTER;

        $rows = DB::connection('hris')->select("
            SELECT
                COUNT(DISTINCT p.pegawai_id) AS jumlah_pegawai,
                ROUND(AVG(b.hari_kerja), 0) AS hari_kerja,
                ROUND(AVG(
                    CASE WHEN COALESCE(b.hari_kerja, 0) > 0
                    THEN COALESCE(att.check_in, 0) / b.hari_kerja * 100
                    ELSE 0 END
                ), 1) AS persentase_kehadiran
            FROM pegawai p
            LEFT JOIN (
                SELECT
                    pegawai_id,
                    SUM(CASE WHEN checkin_time IS NULL OR TRIM(checkin_time) = '' THEN 0 ELSE 1 END) AS check_in
                FROM absensi_import
                WHERE periode = ?
                GROUP BY pegawai_id
            ) att ON p.pegawai_id = att.pegawai_id
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE TRIM(p.regional) = ?
              AND NULLIF(TRIM(p.divisi), '') IS NOT NULL
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
        ", [$periodeHris, $periodeHris, $regional]);

        return $this->formatRegionalSummary($rows[0] ?? null);
    }

    private function fetchRegionalSummaryFromAbsensi(string $periodeHris): ?object
    {
        $regional = self::HRIS_REGIONAL_FILTER;

        $rows = DB::connection('hris')->select("
            SELECT
                COUNT(DISTINCT p.pegawai_id) AS jumlah_pegawai,
                ROUND(AVG(b.hari_kerja), 0) AS hari_kerja,
                ROUND(AVG(
                    CASE WHEN COALESCE(b.hari_kerja, 0) > 0
                    THEN COALESCE(att.check_in, 0) / b.hari_kerja * 100
                    ELSE 0 END
                ), 1) AS persentase_kehadiran
            FROM pegawai p
            LEFT JOIN (
                SELECT pegawai_id, COUNT(DISTINCT DATE(jam)) AS check_in
                FROM absensi
                WHERE DATE_FORMAT(jam, '%m%Y') = ?
                GROUP BY pegawai_id
            ) att ON p.pegawai_id = att.pegawai_id
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE TRIM(p.regional) = ?
              AND NULLIF(TRIM(p.divisi), '') IS NOT NULL
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
        ", [$periodeHris, $periodeHris, $regional]);

        return $this->formatRegionalSummary($rows[0] ?? null);
    }

    private function formatRegionalSummary(?object $row): ?object
    {
        if (!$row || ($row->jumlah_pegawai ?? 0) == 0) {
            return null;
        }

        return (object) [
            'divisi' => 'RATA-RATA KESELURUHAN — ' . self::HRIS_REGIONAL_FILTER,
            'hari_kerja' => $row->hari_kerja,
            'jumlah_pegawai' => $row->jumlah_pegawai,
            'persentase_kehadiran' => $row->persentase_kehadiran,
            'is_summary' => true,
        ];
    }

    private function fetchRekapAbsenHrisByPegawai(int $tahun, int $bulan, string $divisi): array
    {
        $periodeHris = $this->periodeYmToHris($tahun, $bulan);

        if ($this->hrisUsesImportData($periodeHris)) {
            return $this->fetchDetailAbsenFromImport($periodeHris, $divisi);
        }

        return $this->fetchDetailAbsenFromAbsensi($periodeHris, $divisi);
    }

    private function fetchAbsenHarian(int $tahun, int $bulan, string $divisi, string $tanggal): array
    {
        $periodeHris = $this->periodeYmToHris($tahun, $bulan);

        if ($this->hrisUsesImportData($periodeHris)) {
            return $this->fetchHarianFromImport($periodeHris, $divisi, $tanggal);
        }

        return $this->fetchHarianFromAbsensi($periodeHris, $divisi, $tanggal);
    }

    private function fetchRekapAbsenFromImport(string $periodeHris): array
    {
        $regional = self::HRIS_REGIONAL_FILTER;

        $sql = "
            SELECT
                TRIM(p.divisi) AS divisi,
                MAX(b.hari_kerja) AS hari_kerja,
                COUNT(DISTINCT p.pegawai_id) AS jumlah_pegawai,
                ROUND(AVG(
                    CASE WHEN COALESCE(b.hari_kerja, 0) > 0
                    THEN COALESCE(att.check_in, 0) / b.hari_kerja * 100
                    ELSE 0 END
                ), 1) AS persentase_kehadiran
            FROM pegawai p
            LEFT JOIN (
                SELECT
                    pegawai_id,
                    SUM(CASE WHEN checkin_time IS NULL OR TRIM(checkin_time) = '' THEN 0 ELSE 1 END) AS check_in
                FROM absensi_import
                WHERE periode = ?
                GROUP BY pegawai_id
            ) att ON p.pegawai_id = att.pegawai_id
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE TRIM(p.regional) = ?
              AND NULLIF(TRIM(p.divisi), '') IS NOT NULL
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
            GROUP BY TRIM(p.divisi)
            ORDER BY divisi ASC
        ";

        return DB::connection('hris')->select($sql, [$periodeHris, $periodeHris, $regional]);
    }

    private function fetchRekapAbsenFromAbsensi(string $periodeHris): array
    {
        $regional = self::HRIS_REGIONAL_FILTER;

        $sql = "
            SELECT
                TRIM(p.divisi) AS divisi,
                MAX(b.hari_kerja) AS hari_kerja,
                COUNT(DISTINCT p.pegawai_id) AS jumlah_pegawai,
                ROUND(AVG(
                    CASE WHEN COALESCE(b.hari_kerja, 0) > 0
                    THEN COALESCE(att.check_in, 0) / b.hari_kerja * 100
                    ELSE 0 END
                ), 1) AS persentase_kehadiran
            FROM pegawai p
            LEFT JOIN (
                SELECT pegawai_id, COUNT(DISTINCT DATE(jam)) AS check_in
                FROM absensi
                WHERE DATE_FORMAT(jam, '%m%Y') = ?
                GROUP BY pegawai_id
            ) att ON p.pegawai_id = att.pegawai_id
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE TRIM(p.regional) = ?
              AND NULLIF(TRIM(p.divisi), '') IS NOT NULL
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
            GROUP BY TRIM(p.divisi)
            ORDER BY divisi ASC
        ";

        return DB::connection('hris')->select($sql, [$periodeHris, $periodeHris, $regional]);
    }

    private function fetchDetailAbsenFromImport(string $periodeHris, string $divisi): array
    {
        $regional = self::HRIS_REGIONAL_FILTER;

        $sql = "
            SELECT
                p.pegawai_id,
                COALESCE(NULLIF(TRIM(p.nik), ''), '-') AS pegawai_nik,
                p.nama,
                p.jabatan,
                b.hari_kerja,
                COALESCE(att.absensi, 0) AS absensi,
                COALESCE(att.cnt_wfo, 0) AS cnt_wfo,
                COALESCE(att.cnt_wfh, 0) AS cnt_wfh,
                COALESCE(att.cnt_izin, 0) AS cnt_izin,
                COALESCE(att.cnt_dinas, 0) AS cnt_dinas,
                ROUND(
                    CASE WHEN COALESCE(b.hari_kerja, 0) > 0
                    THEN COALESCE(att.absensi, 0) / b.hari_kerja * 100
                    ELSE 0 END, 1
                ) AS persentase_kehadiran,
                CASE WHEN COALESCE(att.absensi, 0) = 0 THEN 1 ELSE 0 END AS belum_absen
            FROM pegawai p
            LEFT JOIN (
                SELECT
                    pegawai_id,
                    SUM(CASE WHEN UPPER(TRIM(jenis_absen)) IN ('WFO', 'WFH', 'IZIN', 'DINAS') THEN 1 ELSE 0 END) AS absensi,
                    SUM(CASE WHEN UPPER(TRIM(jenis_absen)) = 'WFO' THEN 1 ELSE 0 END) AS cnt_wfo,
                    SUM(CASE WHEN UPPER(TRIM(jenis_absen)) = 'WFH' THEN 1 ELSE 0 END) AS cnt_wfh,
                    SUM(CASE WHEN UPPER(TRIM(jenis_absen)) IN ('IZIN', 'IJIN') THEN 1 ELSE 0 END) AS cnt_izin,
                    SUM(CASE WHEN UPPER(TRIM(jenis_absen)) = 'DINAS' THEN 1 ELSE 0 END) AS cnt_dinas
                FROM absensi_import
                WHERE periode = ?
                GROUP BY pegawai_id
            ) att ON p.pegawai_id = att.pegawai_id
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE TRIM(p.regional) = ?
              AND TRIM(p.divisi) = ?
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
            ORDER BY belum_absen DESC, persentase_kehadiran ASC, p.nama ASC
        ";

        return DB::connection('hris')->select($sql, [$periodeHris, $periodeHris, $regional, $divisi]);
    }

    private function fetchDetailAbsenFromAbsensi(string $periodeHris, string $divisi): array
    {
        $regional = self::HRIS_REGIONAL_FILTER;

        $sql = "
            SELECT
                p.pegawai_id,
                COALESCE(NULLIF(TRIM(p.nik), ''), '-') AS pegawai_nik,
                p.nama,
                p.jabatan,
                b.hari_kerja,
                COALESCE(att.absensi, 0) AS absensi,
                COALESCE(att.cnt_wfo, 0) AS cnt_wfo,
                COALESCE(att.cnt_wfh, 0) AS cnt_wfh,
                COALESCE(att.cnt_izin, 0) AS cnt_izin,
                COALESCE(att.cnt_dinas, 0) AS cnt_dinas,
                ROUND(
                    CASE WHEN COALESCE(b.hari_kerja, 0) > 0
                    THEN COALESCE(att.absensi, 0) / b.hari_kerja * 100
                    ELSE 0 END, 1
                ) AS persentase_kehadiran,
                CASE WHEN COALESCE(att.absensi, 0) = 0 THEN 1 ELSE 0 END AS belum_absen
            FROM pegawai p
            LEFT JOIN (
                SELECT
                    pegawai_id,
                    COUNT(DISTINCT CASE WHEN UPPER(TRIM(jenis_absen)) IN ('WFO', 'WFH', 'IZIN', 'DINAS') THEN DATE(jam) END) AS absensi,
                    COUNT(DISTINCT CASE WHEN UPPER(TRIM(jenis_absen)) = 'WFO' THEN DATE(jam) END) AS cnt_wfo,
                    COUNT(DISTINCT CASE WHEN UPPER(TRIM(jenis_absen)) = 'WFH' THEN DATE(jam) END) AS cnt_wfh,
                    COUNT(DISTINCT CASE WHEN UPPER(TRIM(jenis_absen)) IN ('IZIN', 'IJIN') THEN DATE(jam) END) AS cnt_izin,
                    COUNT(DISTINCT CASE WHEN UPPER(TRIM(jenis_absen)) = 'DINAS' THEN DATE(jam) END) AS cnt_dinas
                FROM absensi
                WHERE DATE_FORMAT(jam, '%m%Y') = ?
                GROUP BY pegawai_id
            ) att ON p.pegawai_id = att.pegawai_id
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE TRIM(p.regional) = ?
              AND TRIM(p.divisi) = ?
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
            ORDER BY belum_absen DESC, persentase_kehadiran ASC, p.nama ASC
        ";

        return DB::connection('hris')->select($sql, [$periodeHris, $periodeHris, $regional, $divisi]);
    }

    private function fetchHarianFromImport(string $periodeHris, string $divisi, string $tanggal): array
    {
        $regional = self::HRIS_REGIONAL_FILTER;

        $divisiCondition = $divisi !== '' ? 'AND TRIM(p.divisi) = ?' : '';

        $sql = "
            SELECT
                p.nama,
                COALESCE(NULLIF(TRIM(p.nik), ''), '-') AS pegawai_nik,
                TRIM(p.divisi) AS divisi,
                p.jabatan,
                ? AS tanggal,
                COALESCE(NULLIF(TRIM(ai.hari_kerja), ''), CAST(b.hari_kerja AS CHAR), '-') AS hari_kerja,
                COALESCE(NULLIF(TRIM(ai.checkin_time), ''), '-') AS checkin_time,
                COALESCE(NULLIF(TRIM(ai.checkout_time), ''), '-') AS checkout_time,
                COALESCE(ai.checkin_lat, '') AS latitude,
                COALESCE(ai.checkin_long, '') AS longitude,
                COALESCE(NULLIF(TRIM(ai.alamat), ''), NULLIF(TRIM(ai.psa), ''), '-') AS lokasi,
                COALESCE(NULLIF(TRIM(ai.jenis_absen), ''), '-') AS jenis_absen,
                COALESCE(NULLIF(TRIM(ai.mood_in), ''), '-') AS mood_masuk,
                COALESCE(NULLIF(TRIM(ai.mood_out), ''), '-') AS mood_pulang
            FROM pegawai p
            LEFT JOIN absensi_import ai
                ON ai.pegawai_id = p.pegawai_id
                AND ai.tanggal_date = ?
                AND ai.periode = ?
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE TRIM(p.regional) = ?
              AND NULLIF(TRIM(p.divisi), '') IS NOT NULL
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
              {$divisiCondition}
            ORDER BY p.divisi ASC, p.nama ASC
        ";

        $params = [$tanggal, $tanggal, $periodeHris, $periodeHris, $regional];
        if ($divisi !== '')
            $params[] = $divisi;

        return DB::connection('hris')->select($sql, $params);
    }

    private function fetchHarianFromAbsensi(string $periodeHris, string $divisi, string $tanggal): array
    {
        $regional = self::HRIS_REGIONAL_FILTER;

        $divisiCondition = $divisi !== '' ? 'AND TRIM(p.divisi) = ?' : '';

        $sql = "
            SELECT
                p.nama,
                COALESCE(NULLIF(TRIM(p.nik), ''), '-') AS pegawai_nik,
                TRIM(p.divisi) AS divisi,
                p.jabatan,
                ? AS tanggal,
                CAST(COALESCE(b.hari_kerja, 0) AS CHAR) AS hari_kerja,
                COALESCE(DATE_FORMAT(MIN(a.jam), '%H:%i:%s'), '-') AS checkin_time,
                COALESCE(
                    CASE WHEN COUNT(a.jam) > 1 THEN DATE_FORMAT(MAX(a.jam), '%H:%i:%s') ELSE '-' END,
                    '-'
                ) AS checkout_time,
                COALESCE(MAX(a.latitude), '') AS latitude,
                COALESCE(MAX(a.longitude), '') AS longitude,
                COALESCE(MAX(NULLIF(TRIM(a.alamat), '')), '-') AS lokasi,
                COALESCE(NULLIF(GROUP_CONCAT(DISTINCT a.jenis_absen ORDER BY a.jenis_absen SEPARATOR ', '), ''), '-') AS jenis_absen,
                COALESCE(NULLIF(TRIM(pp.mood_masuk), ''), '-') AS mood_masuk,
                COALESCE(NULLIF(TRIM(pp.mood_pulang), ''), '-') AS mood_pulang
            FROM pegawai p
            LEFT JOIN absensi a
                ON a.pegawai_id = p.pegawai_id
                AND DATE(a.jam) = ?
            LEFT JOIN presensi_pegawai pp
                ON pp.id_pegawai = p.pegawai_id
                AND pp.tanggal = ?
                AND pp.periode = ?
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE TRIM(p.regional) = ?
              AND NULLIF(TRIM(p.divisi), '') IS NOT NULL
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
              {$divisiCondition}
            GROUP BY p.pegawai_id, p.nama, p.nik, p.jabatan, b.hari_kerja, p.divisi, pp.mood_masuk, pp.mood_pulang
            ORDER BY p.divisi ASC, p.nama ASC
        ";

        $params = [$tanggal, $tanggal, $tanggal, $periodeHris, $periodeHris, $regional];
        if ($divisi !== '')
            $params[] = $divisi;

        return DB::connection('hris')->select($sql, $params);
    }

    public function evaluasi_hris_regional_list()
    {
        return response()->json([
            'status' => 'success',
            'data' => self::HRIS_REGIONAL_FILTER,
        ]);
    }

    public function evaluasi_hris_pegawai_list(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $regional = trim((string) $request->get('regional', ''));

        if (strlen($search) < 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Minimal 3 huruf untuk pencarian',
            ], 400);
        }

        try {
            $sql = "
                SELECT
                    p.pegawai_id,
                    p.nama,
                    p.nik,
                    p.divisi,
                    p.jabatan
                FROM pegawai p
                WHERE TRIM(p.regional) = ?
                  AND (p.nama LIKE ? OR p.nik LIKE ?)
                  AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
                  AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
                ORDER BY p.nama ASC
                LIMIT 20
            ";

            $searchPattern = '%' . $search . '%';
            $rows = DB::connection('hris')->select($sql, [$regional, $searchPattern, $searchPattern]);

            return response()->json([
                'status' => 'success',
                'data' => $rows,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function evaluasi_hris_perkaryawan(Request $request)
    {
        $pegawai_id = trim((string) $request->get('pegawai_id', ''));
        $tanggal_awal = trim((string) $request->get('tanggal_awal', ''));
        $tanggal_akhir = trim((string) $request->get('tanggal_akhir', ''));
        $periode = $request->get('periode', date('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format periode tidak valid (gunakan YYYY-MM).',
            ], 400);
        }

        if ($pegawai_id === '' || $tanggal_awal === '' || $tanggal_akhir === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter pegawai_id, tanggal_awal, dan tanggal_akhir wajib diisi.',
            ], 400);
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_awal) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_akhir)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format tanggal tidak valid (gunakan YYYY-MM-DD).',
            ], 400);
        }

        [$tahun, $bulan] = array_map('intval', explode('-', $periode));
        $periodePrefix = sprintf('%04d-%02d', $tahun, $bulan);

        if (strpos($tanggal_awal, $periodePrefix) !== 0 || strpos($tanggal_akhir, $periodePrefix) !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tanggal harus berada dalam periode yang dipilih.',
            ], 400);
        }

        try {
            $regional = self::HRIS_REGIONAL_FILTER;
            $periodeHris = $this->periodeYmToHris($tahun, $bulan);

            if ($this->hrisUsesImportData($periodeHris)) {
                $rows = $this->fetchPerKaryawanFromImport($periodeHris, $pegawai_id, $tanggal_awal, $tanggal_akhir, $regional);
            } else {
                $rows = $this->fetchPerKaryawanFromAbsensi($periodeHris, $pegawai_id, $tanggal_awal, $tanggal_akhir, $regional);
            }

            return response()->json([
                'status' => 'success',
                'periode' => $periode,
                'pegawai_id' => $pegawai_id,
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
                'total' => count($rows),
                'data' => $rows,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function fetchPerKaryawanFromAbsensi(string $periodeHris, string $pegawai_id, string $tanggal_awal, string $tanggal_akhir, string $regional): array
    {
        $sql = "
            SELECT
                p.nama,
                COALESCE(NULLIF(TRIM(p.nik), ''), '-') AS pegawai_nik,
                p.jabatan,
                DATE(a.jam) AS tanggal,
                CAST(COALESCE(b.hari_kerja, 0) AS CHAR) AS hari_kerja,
                COALESCE(DATE_FORMAT(MIN(a.jam), '%H:%i:%s'), '-') AS checkin_time,
                COALESCE(
                    CASE WHEN COUNT(a.jam) > 1 THEN DATE_FORMAT(MAX(a.jam), '%H:%i:%s') ELSE '-' END,
                    '-'
                ) AS checkout_time,
                COALESCE(MAX(a.latitude), '') AS latitude,
                COALESCE(MAX(a.longitude), '') AS longitude,
                COALESCE(MAX(NULLIF(TRIM(a.alamat), '')), '-') AS lokasi,
                COALESCE(NULLIF(GROUP_CONCAT(DISTINCT a.jenis_absen ORDER BY a.jenis_absen SEPARATOR ', '), ''), '-') AS jenis_absen,
                COALESCE(NULLIF(TRIM(pp.mood_masuk), ''), '-') AS mood_masuk,
                COALESCE(NULLIF(TRIM(pp.mood_pulang), ''), '-') AS mood_pulang
            FROM pegawai p
            LEFT JOIN absensi a
                ON a.pegawai_id = p.pegawai_id
                AND DATE(a.jam) BETWEEN ? AND ?
            LEFT JOIN presensi_pegawai pp
                ON pp.id_pegawai = p.pegawai_id
                AND pp.tanggal = DATE(a.jam)
                AND pp.periode = ?
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE p.pegawai_id = ?
              AND TRIM(p.regional) = ?
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
            GROUP BY p.pegawai_id, p.nama, p.nik, p.jabatan, DATE(a.jam), b.hari_kerja, pp.mood_masuk, pp.mood_pulang
            ORDER BY DATE(a.jam) DESC
        ";

        return DB::connection('hris')->select($sql, [
            $tanggal_awal,
            $tanggal_akhir,
            $periodeHris,
            $periodeHris,
            $pegawai_id,
            $regional,
        ]);
    }

    private function fetchPerKaryawanFromImport(string $periodeHris, string $pegawai_id, string $tanggal_awal, string $tanggal_akhir, string $regional): array
    {
        $sql = "
            SELECT
                p.nama,
                COALESCE(NULLIF(TRIM(p.nik), ''), '-') AS pegawai_nik,
                p.jabatan,
                ai.tanggal_date AS tanggal,
                COALESCE(NULLIF(TRIM(ai.hari_kerja), ''), CAST(b.hari_kerja AS CHAR), '-') AS hari_kerja,
                COALESCE(NULLIF(TRIM(ai.checkin_time), ''), '-') AS checkin_time,
                COALESCE(NULLIF(TRIM(ai.checkout_time), ''), '-') AS checkout_time,
                COALESCE(ai.checkin_lat, '') AS latitude,
                COALESCE(ai.checkin_long, '') AS longitude,
                COALESCE(NULLIF(TRIM(ai.alamat), ''), NULLIF(TRIM(ai.psa), ''), '-') AS lokasi,
                COALESCE(NULLIF(TRIM(ai.jenis_absen), ''), '-') AS jenis_absen,
                COALESCE(NULLIF(TRIM(ai.mood_in), ''), '-') AS mood_masuk,
                COALESCE(NULLIF(TRIM(ai.mood_out), ''), '-') AS mood_pulang
            FROM pegawai p
            LEFT JOIN absensi_import ai
                ON ai.pegawai_id = p.pegawai_id
                AND ai.tanggal_date BETWEEN ? AND ?
                AND ai.periode = ?
            LEFT JOIN absensi_periode b
                ON p.regional_kode = b.regional_kode
                AND p.area_kode = b.area_kode
                AND b.periode = ?
            WHERE p.pegawai_id = ?
              AND TRIM(p.regional) = ?
              AND (p.penugasan_mutasi_ke IS NULL OR TRIM(p.penugasan_mutasi_ke) = '')
              AND (p.status_ckp IS NULL OR p.status_ckp != 'Ya')
            ORDER BY ai.tanggal_date DESC
        ";

        return DB::connection('hris')->select($sql, [
            $tanggal_awal,
            $tanggal_akhir,
            $periodeHris,
            $periodeHris,
            $pegawai_id,
            $regional,
        ]);
    }

}
