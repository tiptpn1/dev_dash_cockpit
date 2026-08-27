<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FeatureManagementController extends Controller
{
    /**
     * Display a listing of features
     */
    public function index(Request $request): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        $query = Feature::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $features = $query->paginate(5);
        return view('management.features.index', compact('features'));
    }

    /**
     * Export features to Excel
     */
    public function export(Request $request)
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        $query = Feature::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $features = $query->get();

        $fileName = 'Export_Manajemen_Fitur_' . date('Y-m-d_His') . '.xls';

        $headers = [
            "Content-type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($features) {
            echo '<table border="1">';
            echo '<tr style="background-color: #16A34A; color: #FFFFFF;">';
            echo '<th>No.</th><th>Slug</th><th>Nama Fitur</th><th>Created At</th>';
            echo '</tr>';

            foreach ($features as $index => $feature) {
                echo '<tr>';
                echo '<td style="text-align: center;">' . ($index + 1) . '</td>';
                echo '<td>' . htmlspecialchars($feature->slug) . '</td>';
                echo '<td>' . htmlspecialchars($feature->name) . '</td>';
                echo '<td>' . htmlspecialchars($feature->created_at ? $feature->created_at->format('Y-m-d H:i:s') : '-') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new feature
     */
    public function create(): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }
        return view('management.features.create');
    }

    /**
     * Store a newly created feature
     */
    public function store(Request $request): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        $validated = $request->validate([
            'slug' => 'required|unique:features,slug|min:2|max:50|alpha_dash',
            'name' => 'required|string|max:100',
        ]);

        Feature::create($validated);

        return redirect()->route('management.features.index')
            ->with('success', 'Feature berhasil ditambahkan');
    }

    /**
     * Show the form for editing a feature
     */
    public function edit(Feature $feature): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }
        return view('management.features.edit', compact('feature'));
    }

    /**
     * Update the specified feature
     */
    public function update(Request $request, Feature $feature): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        $validated = $request->validate([
            'slug' => 'required|unique:features,slug,' . $feature->id . '|min:2|max:50|alpha_dash',
            'name' => 'required|string|max:100',
        ]);

        $feature->update($validated);

        return redirect()->route('management.features.index')
            ->with('success', 'Feature berhasil diupdate');
    }

    /**
     * Delete the specified feature
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        // Hapus relasi dengan users
        $feature->users()->detach();
        $feature->delete();

        return redirect()->route('management.features.index')
            ->with('success', 'Feature berhasil dihapus');
    }

    /**
     * Display the feature dictionary
     */
    public function dictionary(Request $request): View
    {
        if (!auth('custom')->user() || !auth('custom')->user()->hasFeature('management_features')) {
            abort(403, 'Akses ditolak: Anda tidak memiliki fitur Feature Management.');
        }

        $dictionary = [
            [
                'no' => 1,
                'category' => 'MRC',
                'position' => 'Utama (Direct)',
                'name' => 'MRC',
                'slug' => 'mrc',
                'url' => '/mrc',
                'route_name' => 'mrc',
                'source' => 'Looker Studio',
                'description' => 'Dashboard Management Reporting Cockpit'
            ],
            [
                'no' => 2,
                'category' => 'Operasional',
                'position' => 'Operasional -> AMANAH',
                'name' => 'Operasional - AMANAH',
                'slug' => 'operasional_amanah',
                'url' => '/amanah',
                'route_name' => 'amanah',
                'source' => 'Looker Studio',
                'description' => 'Dashboard AMANAH terintegrasi'
            ],
            [
                'no' => 3,
                'category' => 'Operasional',
                'position' => 'Operasional -> DFarm PTPN I',
                'name' => 'Operasional - DFarm PTPN I',
                'slug' => 'operasional_dfarm',
                'url' => '/dfarmkaret',
                'route_name' => 'dfarmkaretpresensi',
                'source' => 'Looker Studio',
                'description' => 'Dashboard DFarm Presensi & Produksi Karet'
            ],
            [
                'no' => 4,
                'category' => 'Operasional',
                'position' => 'Operasional -> CCTV',
                'name' => 'Operasional - CCTV',
                'slug' => 'operasional_cctv',
                'url' => 'https://cctv.ptpn1.co.id/...',
                'route_name' => '-',
                'source' => 'Situs Eksternal',
                'description' => 'Monitoring CCTV PTPN I (dilengkapi legacy fallback ke slug cctv)'
            ],
            [
                'no' => 5,
                'category' => 'Operasional',
                'position' => 'Operasional -> On Farm Karet',
                'name' => 'Operasional - On Farm Karet',
                'slug' => 'operasional_onfarmkaret',
                'url' => '/onfarmkaret',
                'route_name' => 'onfarmkaret',
                'source' => 'Looker Studio',
                'description' => 'Dashboard visualisasi data on-farm karet'
            ],
            [
                'no' => 6,
                'category' => 'Operasional',
                'position' => 'Operasional -> On Farm Teh',
                'name' => 'Operasional - On Farm Teh',
                'slug' => 'operasional_onfarmteh',
                'url' => '/onfarmteh',
                'route_name' => 'onfarmteh',
                'source' => 'Looker Studio',
                'description' => 'Dashboard visualisasi data on-farm teh'
            ],
            [
                'no' => 7,
                'category' => 'Operasional',
                'position' => 'Operasional -> On Farm Kopi',
                'name' => 'Operasional - On Farm Kopi',
                'slug' => 'operasional_onfarmkopi',
                'url' => '/onfarmkopi',
                'route_name' => 'onfarmkopi',
                'source' => 'Looker Studio',
                'description' => 'Dashboard visualisasi data on-farm kopi'
            ],
            [
                'no' => 8,
                'category' => 'Operasional',
                'position' => 'Operasional -> Off Farm Karet',
                'name' => 'Operasional - Off Farm Karet',
                'slug' => 'operasional_offfarmkaret',
                'url' => '/offfarmkaret',
                'route_name' => 'offfarmkaret',
                'source' => 'Looker Studio',
                'description' => 'Dashboard visualisasi data pengolahan pabrik karet'
            ],
            [
                'no' => 9,
                'category' => 'Operasional',
                'position' => 'Operasional -> Off Farm Teh',
                'name' => 'Operasional - Off Farm Teh',
                'slug' => 'operasional_offfarmteh',
                'url' => '/offfarmteh',
                'route_name' => 'offfarmteh',
                'source' => 'Looker Studio',
                'description' => 'Dashboard visualisasi data pengolahan pabrik teh'
            ],
            [
                'no' => 10,
                'category' => 'Operasional',
                'position' => 'Operasional -> Off Farm Kopi',
                'name' => 'Operasional - Off Farm Kopi',
                'slug' => 'operasional_offfarmkopi',
                'url' => '/offfarmkopi',
                'route_name' => 'offfarmkopi',
                'source' => 'Looker Studio',
                'description' => 'Dashboard visualisasi data pengolahan pabrik kopi'
            ],
            [
                'no' => 11,
                'category' => 'PICA',
                'position' => 'PICA -> Kuadran Problem',
                'name' => 'PICA - Kuadran Problem',
                'slug' => 'pica_kuadran',
                'url' => '/pica/kuadran-problem-identifications',
                'route_name' => 'pica.kuadran_problem_identifications',
                'source' => 'Looker Studio',
                'description' => 'Matriks kuadran problem identifications'
            ],
            [
                'no' => 12,
                'category' => 'PICA',
                'position' => 'PICA -> List Corrective Actions',
                'name' => 'PICA - List Corrective Actions',
                'slug' => 'pica_corrective',
                'url' => '/pica/list-corrective-actions',
                'route_name' => 'pica.list_corrective_actions',
                'source' => 'Looker Studio',
                'description' => 'Laporan progress tindakan perbaikan'
            ],
            [
                'no' => 13,
                'category' => 'Warehouse',
                'position' => 'Utama (Direct)',
                'name' => 'Warehouse - Gudang Utilisasi',
                'slug' => 'warehouse_gudang',
                'url' => '/gudangutilisasi',
                'route_name' => 'gudangutilisasi',
                'source' => 'Looker Studio',
                'description' => 'Dashboard utilisasi ruang gudang regional (dilengkapi legacy fallback ke slug warehouse)'
            ],
            [
                'no' => 14,
                'category' => 'Sales',
                'position' => 'Sales -> Overview Sales',
                'name' => 'Sales - Overview Sales',
                'slug' => 'sales_overview',
                'url' => '/overview_sales',
                'route_name' => 'overview_sales',
                'source' => 'Looker Studio',
                'description' => 'Overview penjualan korporat'
            ],
            [
                'no' => 15,
                'category' => 'Sales',
                'position' => 'Sales -> Comodities Sales',
                'name' => 'Sales - Comodities Sales',
                'slug' => 'sales_comodities',
                'url' => '/sales_comodities',
                'route_name' => 'sales_comodities',
                'source' => 'Looker Studio',
                'description' => 'Dashboard penjualan berbasis komoditas'
            ],
            [
                'no' => 16,
                'category' => 'Sales',
                'position' => 'Sales -> Tea Inventory',
                'name' => 'Sales - Tea Inventory',
                'slug' => 'sales_tea_inventory',
                'url' => '/soptea',
                'route_name' => 'soptea',
                'source' => 'Looker Studio',
                'description' => 'Stok teh dan SOP komoditas teh'
            ],
            [
                'no' => 17,
                'category' => 'Sales',
                'position' => 'Sales -> Rubber Delivery',
                'name' => 'Sales - Rubber Delivery',
                'slug' => 'sales_rubber_delivery',
                'url' => '/penjualan_karet',
                'route_name' => 'penjualan_karet',
                'source' => 'Looker Studio',
                'description' => 'Pengiriman dan realisasi penjualan karet'
            ],
            [
                'no' => 18,
                'category' => 'Sales',
                'position' => 'Sales -> CRM',
                'name' => 'Sales - CRM',
                'slug' => 'sales_crm',
                'url' => '/crm',
                'route_name' => 'crm_dashboard',
                'source' => 'Looker Studio',
                'description' => 'Manajemen hubungan pelanggan / customer'
            ],
            [
                'no' => 19,
                'category' => 'Sales',
                'position' => 'Sales -> SONIA',
                'name' => 'Sales - SONIA',
                'slug' => 'sales_sonia',
                'url' => 'https://sonia.ptpn1.co.id/...',
                'route_name' => '-',
                'source' => 'Situs Eksternal (SSO)',
                'description' => 'Sistem Operasional Niaga Terintegrasi (dilengkapi legacy fallback ke slug sonia)'
            ],
            [
                'no' => 20,
                'category' => 'Asset',
                'position' => 'Asset -> Peta',
                'name' => 'Asset - Peta',
                'slug' => 'aset_peta',
                'url' => '/asset_peta',
                'route_name' => 'asset_peta',
                'source' => 'Looker Studio',
                'description' => 'Pemetaan aset wilayah PTPN I'
            ],
            [
                'no' => 21,
                'category' => 'Asset',
                'position' => 'Asset -> Recovery',
                'name' => 'Asset - Recovery',
                'slug' => 'aset_recovery',
                'url' => '/asset_recovery',
                'route_name' => 'asset_recovery',
                'source' => 'Looker Studio',
                'description' => 'Pemulihan dan optimalisasi status aset'
            ],
            [
                'no' => 22,
                'category' => 'Asset',
                'position' => 'Asset -> Optimalisasi',
                'name' => 'Asset - Optimalisasi',
                'slug' => 'aset_optimalisasi',
                'url' => '/asset_optimalisasi',
                'route_name' => 'asset_optimalisasi',
                'source' => 'Looker Studio',
                'description' => 'Strategi pendayagunaan aset'
            ],
            [
                'no' => 23,
                'category' => 'Asset',
                'position' => 'Asset -> Divestasi',
                'name' => 'Asset - Divestasi',
                'slug' => 'aset_divestasi',
                'url' => '/asset_divestasi',
                'route_name' => 'asset_divestasi',
                'source' => 'Looker Studio',
                'description' => 'Dashboard status divestasi aset'
            ],
            [
                'no' => 24,
                'category' => 'Finansial',
                'position' => 'Finansial -> Consolidate',
                'name' => 'Finansial - Consolidate',
                'slug' => 'finansial_console',
                'url' => '/fin_console',
                'route_name' => 'fin_console',
                'source' => 'Looker Studio',
                'description' => 'Konsolidasi laporan keuangan korporasi'
            ],
            [
                'no' => 25,
                'category' => 'Finansial',
                'position' => 'Finansial -> Parent Only',
                'name' => 'Finansial - Parent Only',
                'slug' => 'finansial_parent',
                'url' => '/fin_parent',
                'route_name' => 'fin_parent',
                'source' => 'Looker Studio',
                'description' => 'Laporan keuangan perusahaan induk'
            ],
            [
                'no' => 26,
                'category' => 'Finansial',
                'position' => 'Finansial -> Rasio Keuangan',
                'name' => 'Finansial - Rasio Keuangan',
                'slug' => 'finansial_ratio',
                'url' => '/fin_ratio',
                'route_name' => 'fin_ratio',
                'source' => 'Looker Studio',
                'description' => 'Dashboard analisis rasio keuangan'
            ],
            [
                'no' => 27,
                'category' => 'Finansial',
                'position' => 'Finansial -> Executive Dashboard',
                'name' => 'Finansial - Executive Dashboard',
                'slug' => 'finansial_executive',
                'url' => '/fin_executive',
                'route_name' => 'fin_executive',
                'source' => 'Looker Studio',
                'description' => 'Dashboard eksekutif ringkasan finansial'
            ],
            [
                'no' => 28,
                'category' => 'Finansial',
                'position' => 'Finansial -> Subsidiary',
                'name' => 'Finansial - Subsidiary',
                'slug' => 'finansial_sub',
                'url' => '/fin_sub',
                'route_name' => 'fin_sub',
                'source' => 'Looker Studio',
                'description' => 'Laporan keuangan anak perusahaan'
            ],
            [
                'no' => 29,
                'category' => 'Human Resource',
                'position' => 'HR -> Demographics (Dashboard)',
                'name' => 'HR - Demographics',
                'slug' => 'hr_demographics',
                'url' => '/hr_demographics',
                'route_name' => 'hr_demographics',
                'source' => 'Looker Studio',
                'description' => 'Visualisasi demografi karyawan'
            ],
            [
                'no' => 30,
                'category' => 'Human Resource',
                'position' => 'HR -> Learning & Development',
                'name' => 'HR - Learning & Development',
                'slug' => 'hr_dev',
                'url' => '/hr_dev',
                'route_name' => 'hr_dev',
                'source' => 'Looker Studio',
                'description' => 'Monitoring L&D dan pelatihan karyawan'
            ],
            [
                'no' => 31,
                'category' => 'Human Resource',
                'position' => 'HR -> Revenue & Cost',
                'name' => 'HR - Revenue & Cost',
                'slug' => 'hr_revenue',
                'url' => '/hr_revenue',
                'route_name' => 'hr_revenue',
                'source' => 'Looker Studio',
                'description' => 'Analisis biaya karyawan terhadap revenue'
            ],
            [
                'no' => 32,
                'category' => 'Human Resource',
                'position' => 'HR -> Demographic (Aplikasi)',
                'name' => 'HR - Demographic',
                'slug' => 'hr_demographic',
                'url' => '/hr_demographic',
                'route_name' => 'hr_demographic',
                'source' => 'Aplikasi Lokal',
                'description' => 'Data detail demografi lokal internal'
            ],
            [
                'no' => 33,
                'category' => 'Human Resource',
                'position' => 'HR -> SGnA',
                'name' => 'HR - SGnA',
                'slug' => 'hr_sgna',
                'url' => '/hr_sgna',
                'route_name' => 'hr_sgna',
                'source' => 'Looker Studio',
                'description' => 'Dashboard beban penjualan, umum, dan administrasi'
            ],
            [
                'no' => 34,
                'category' => 'Legal',
                'position' => 'Legal -> Tax Relaxation BPHTB 0%',
                'name' => 'Legal - Tax Relaxation',
                'slug' => 'legal_tax',
                'url' => '/agraria_tax',
                'route_name' => 'agraria_tax',
                'source' => 'Looker Studio',
                'description' => 'Relaksasi pajak BPHTB 0%'
            ],
            [
                'no' => 35,
                'category' => 'Legal',
                'position' => 'Legal -> Agraria',
                'name' => 'Legal - Agraria',
                'slug' => 'legal_agraria',
                'url' => '/agraria',
                'route_name' => 'agraria',
                'source' => 'Looker Studio',
                'description' => 'Status tanah dan sertifikat HGU/agraria'
            ],
            [
                'no' => 36,
                'category' => 'Capaian Progres',
                'position' => 'Capaian Progres -> SLA',
                'name' => 'Progress - SLA',
                'slug' => 'progress_sla',
                'url' => '/sla',
                'route_name' => 'sla',
                'source' => 'Looker Studio',
                'description' => 'Kinerja dan SLA tim TI'
            ],
            [
                'no' => 37,
                'category' => 'Pengadaan',
                'position' => 'Pengadaan -> Pra Pengadaan',
                'name' => 'Pengadaan - Pra Pengadaan',
                'slug' => 'pengadaan_pra',
                'url' => '/prapengadaan',
                'route_name' => 'prapengadaan',
                'source' => 'Looker Studio',
                'description' => 'Rencana dan tahapan awal pengadaan'
            ],
            [
                'no' => 38,
                'category' => 'Pengadaan',
                'position' => 'Pengadaan -> Proses Pengadaan',
                'name' => 'Pengadaan - Proses Pengadaan',
                'slug' => 'pengadaan_proses',
                'url' => '/prosespengadaan',
                'route_name' => 'prosespengadaan',
                'source' => 'Looker Studio',
                'description' => 'Monitoring proses pengadaan barang/jasa'
            ],
            [
                'no' => 39,
                'category' => 'Pengadaan',
                'position' => 'Pengadaan -> Kontrak Pengadaan',
                'name' => 'Pengadaan - Kontrak Pengadaan',
                'slug' => 'pengadaan_kontrak',
                'url' => '/kontrakpengadaan',
                'route_name' => 'kontrakpengadaan',
                'source' => 'Looker Studio',
                'description' => 'Monitoring penyusunan dan tanda tangan kontrak'
            ],
            [
                'no' => 40,
                'category' => 'Pengadaan',
                'position' => 'Pengadaan -> Stok Pengadaan',
                'name' => 'Pengadaan - Stok Pengadaan',
                'slug' => 'pengadaan_stok',
                'url' => '/stokpengadaan',
                'route_name' => 'stokpengadaan',
                'source' => 'Looker Studio',
                'description' => 'Realisasi stok barang pengadaan regional'
            ],
            [
                'no' => 41,
                'category' => 'Carbon',
                'position' => 'Carbon -> Dashboard Emisi',
                'name' => 'Carbon - Dashboard Emisi',
                'slug' => 'carbon_emisi',
                'url' => '/dashboardemisi',
                'route_name' => 'dashboardemisi',
                'source' => 'Looker Studio',
                'description' => 'Pantauan emisi gas rumah kaca'
            ],
            [
                'no' => 42,
                'category' => 'GIS',
                'position' => 'GIS -> PETA',
                'name' => 'GIS - Areal',
                'slug' => 'gis_areal',
                'url' => 'https://gis.ptpn1.co.id/...',
                'route_name' => '-',
                'source' => 'Situs Eksternal',
                'description' => 'WebGIS peta areal komoditas'
            ],
            [
                'no' => 43,
                'category' => 'GIS',
                'position' => 'GIS -> NDVI',
                'name' => 'GIS - NDVI',
                'slug' => 'gis_ndvi',
                'url' => 'http://gis.ptpn1.co.id/...',
                'route_name' => '-',
                'source' => 'Situs Eksternal',
                'description' => 'Pemantauan indeks vegetasi satelit'
            ],
            [
                'no' => 44,
                'category' => 'GIS',
                'position' => 'GIS -> CUACA',
                'name' => 'GIS - Cuaca',
                'slug' => 'gis_cuaca',
                'url' => 'http://aset-dives-dev.ptpn1.co.id/...',
                'route_name' => '-',
                'source' => 'Situs Eksternal',
                'description' => 'Monitoring cuaca regional'
            ],
            [
                'no' => 45,
                'category' => 'AGRO Skyview',
                'position' => 'AGRO Skyview -> AGRO Skyview Table',
                'name' => 'Skyview - AGRO Skyview Table',
                'slug' => 'skyview_table',
                'url' => '/skyview-table',
                'route_name' => 'skyview_table',
                'source' => 'Aplikasi Lokal (CRUD)',
                'description' => 'Manajemen data penerbangan drone & peta udara'
            ],
            [
                'no' => 46,
                'category' => 'AGRO Skyview',
                'position' => 'AGRO Skyview -> Exec Summary',
                'name' => 'Skyview - Exec Summary',
                'slug' => 'skyview_exec',
                'url' => '/exec_summary',
                'route_name' => 'exec_summary',
                'source' => 'Looker Studio',
                'description' => 'Ringkasan eksekutif AGRO Skyview'
            ],
            [
                'no' => 47,
                'category' => 'Laporan Manajemen',
                'position' => 'Laporan Manajemen -> LM13',
                'name' => 'LM - LM13',
                'slug' => 'lm_13',
                'url' => '/lm13',
                'route_name' => 'lm13',
                'source' => 'Looker Studio',
                'description' => 'Laporan manajemen LM13'
            ],
            [
                'no' => 48,
                'category' => 'Laporan Manajemen',
                'position' => 'Laporan Manajemen -> LM14',
                'name' => 'LM - LM14',
                'slug' => 'lm_14',
                'url' => '/lm14',
                'route_name' => 'lm14',
                'source' => 'Looker Studio',
                'description' => 'Laporan manajemen LM14'
            ],
            [
                'no' => 49,
                'category' => 'Laporan Manajemen',
                'position' => 'Laporan Manajemen -> LM16',
                'name' => 'LM - LM16',
                'slug' => 'lm_16',
                'url' => '/lm16',
                'route_name' => 'lm16',
                'source' => 'Looker Studio',
                'description' => 'Laporan manajemen LM16'
            ],
            [
                'no' => 50,
                'category' => 'Laporan Manajemen',
                'position' => 'Laporan Manajemen -> LM34',
                'name' => 'LM - LM34',
                'slug' => 'lm_34',
                'url' => '/lm34_tab',
                'route_name' => 'lm34_tab',
                'source' => 'Looker Studio',
                'description' => 'Laporan manajemen LM34'
            ],
            [
                'no' => 51,
                'category' => 'Laporan Manajemen',
                'position' => 'Laporan Manajemen -> LM62',
                'name' => 'LM - LM62',
                'slug' => 'lm_62',
                'url' => '/lm62',
                'route_name' => 'lm62',
                'source' => 'Looker Studio',
                'description' => 'Laporan manajemen LM62'
            ],
            [
                'no' => 52,
                'category' => 'Sales & Operation',
                'position' => 'Sales & Operation -> Karet',
                'name' => 'Sales & Operation - Karet',
                'slug' => 'pemasaran_karet_sales',
                'url' => '/sales_operational_karet',
                'route_name' => 'sales_operational_karet',
                'source' => 'Looker Studio',
                'description' => 'Realisasi penjualan operasional karet'
            ],
            [
                'no' => 53,
                'category' => 'AIGR1',
                'position' => 'Utama (Direct)',
                'name' => 'AIGR1',
                'slug' => 'aigr1',
                'url' => '/portalaplikasi',
                'route_name' => 'portalaplikasi',
                'source' => 'Aplikasi Lokal',
                'description' => 'Menu aplikasi AIGR1'
            ],
            [
                'no' => 54,
                'category' => 'Garda AI',
                'position' => 'Utama (Direct)',
                'name' => 'Garda AI',
                'slug' => 'garda',
                'url' => 'https://gardaprep.holding-perkebunan.com/',
                'route_name' => '-',
                'source' => 'Situs Eksternal',
                'description' => 'Portal AI Garda Holding Perkebunan'
            ],
            [
                'no' => 55,
                'category' => 'Portal Aplikasi',
                'position' => 'Utama (Direct)',
                'name' => 'Portal Aplikasi',
                'slug' => 'portalaplikasi',
                'url' => '/portalaplikasi',
                'route_name' => 'portalaplikasi',
                'source' => 'Aplikasi Lokal',
                'description' => 'Menu Portal Aplikasi'
            ],
            [
                'no' => 56,
                'category' => 'Evaluasi Aplikasi',
                'position' => 'Utama (Direct)',
                'name' => 'Evaluasi Aplikasi',
                'slug' => 'evaluasi_aplikasi',
                'url' => 'https://evaluasi-aplikasi.ptpn1.co.id/',
                'route_name' => '-',
                'source' => 'Situs Eksternal',
                'description' => 'Sistem evaluasi aplikasi PTPN I'
            ],
            [
                'no' => 57,
                'category' => 'System Management',
                'position' => 'System Management -> User',
                'name' => 'User Management',
                'slug' => 'management_users',
                'url' => '/management/users',
                'route_name' => 'management.users.index',
                'source' => 'Aplikasi Lokal',
                'description' => 'Manajemen data user dan pembuatan akun baru'
            ],
            [
                'no' => 58,
                'category' => 'System Management',
                'position' => 'System Management -> Fitur',
                'name' => 'Feature Management',
                'slug' => 'management_features',
                'url' => '/management/features',
                'route_name' => 'management.features.index',
                'source' => 'Aplikasi Lokal',
                'description' => 'Manajemen pendaftaran slug fitur baru dan Kamus Fitur'
            ],
            [
                'no' => 59,
                'category' => 'System Management',
                'position' => 'System Management -> Hak Akses / Last Login',
                'name' => 'Access Management',
                'slug' => 'management_access',
                'url' => '/management/access',
                'route_name' => 'management.access.index',
                'source' => 'Aplikasi Lokal',
                'description' => 'Manajemen otorisasi hak akses user ke fitur dan pantauan log login terakhir'
            ]
        ];

        // All distinct categories before filtering
        $allCategories = array_unique(array_column($dictionary, 'category'));
        sort($allCategories);

        // Filter by category if requested
        $selectedCategory = $request->input('category');
        if ($selectedCategory) {
            $dictionary = array_values(array_filter($dictionary, function($item) use ($selectedCategory) {
                return $item['category'] === $selectedCategory;
            }));
        }

        // Search by slug/name if requested
        $search = $request->input('search');
        if ($search) {
            $dictionary = array_values(array_filter($dictionary, function($item) use ($search) {
                return stripos($item['slug'], $search) !== false ||
                       stripos($item['name'], $search) !== false ||
                       stripos($item['description'], $search) !== false;
            }));
        }

        return view('management.features.dictionary', compact('dictionary', 'allCategories', 'selectedCategory'));
    }
}
