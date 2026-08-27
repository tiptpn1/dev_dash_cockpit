<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SidebarNavigationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan semua menu induk (parent) terdaftar di tabel features
        $parents = [
            'operasional'     => ['name' => 'Operasional', 'icon' => 'fa-solid fa-gears', 'sort_order' => 20],
            'pica'            => ['name' => 'PICA', 'icon' => 'fa-solid fa-clipboard-list', 'sort_order' => 30],
            'warehouse'       => ['name' => 'Warehouse', 'icon' => 'fa-solid fa-warehouse', 'sort_order' => 40],
            'sales'           => ['name' => 'Sales', 'icon' => 'fa-solid fa-chart-line', 'sort_order' => 50],
            'aset'            => ['name' => 'Asset', 'icon' => 'fa-solid fa-building', 'sort_order' => 60],
            'finansial'       => ['name' => 'Finansial', 'icon' => 'fa-solid fa-coins', 'sort_order' => 70],
            'hr'              => ['name' => 'Human Resource', 'icon' => 'fa-solid fa-users', 'sort_order' => 80],
            'legal'           => ['name' => 'Legal & Agraria', 'icon' => 'fa-solid fa-scale-balanced', 'sort_order' => 90],
            'progress'        => ['name' => 'Capaian Progres', 'icon' => 'fa-solid fa-chart-line', 'sort_order' => 100],
            'pengadaan'       => ['name' => 'Pengadaan', 'icon' => 'fa-solid fa-cart-shopping', 'sort_order' => 110],
            'carbon'          => ['name' => 'Carbon', 'icon' => 'fa-solid fa-smog', 'sort_order' => 120],
            'gis'             => ['name' => 'GIS', 'icon' => 'fa-solid fa-map-location-dot', 'sort_order' => 130],
            'skyview'         => ['name' => 'AGRO Skyview', 'icon' => 'fa-solid fa-map-location-dot', 'sort_order' => 140],
            'lm'              => ['name' => 'Laporan Manajemen', 'icon' => 'fa-solid fa-book', 'sort_order' => 150],
            'pemasaran_karet' => ['name' => 'Sales & Operation', 'icon' => 'fa-solid fa-book', 'sort_order' => 200],
            'management'      => ['name' => 'System Management', 'icon' => 'fa-solid fa-cogs', 'sort_order' => 210],
        ];

        foreach ($parents as $slug => $data) {
            DB::table('features')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'sort_order' => $data['sort_order'],
                    'is_sidebar' => true,
                    'is_active' => true,
                    'parent_id' => null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Helper function untuk mengambil ID fitur berdasarkan slug
        $getFeatureId = fn($slug) => DB::table('features')->where('slug', $slug)->value('id');

        // 2. Hubungkan Sub-Menu ke Parent dan isi URL, Icon, & Sort Order
        $children = [
            // Operasional
            'operasional_amanah'       => ['name' => 'Operasional - AMANAH', 'parent' => 'operasional', 'url' => '/amanah', 'icon' => 'fa-solid fa-building', 'order' => 1],
            'operasional_dfarm'        => ['name' => 'Operasional - DFarm PTPN I', 'parent' => 'operasional', 'url' => '/dfarmkaret', 'icon' => 'fa-solid fa-seedling', 'order' => 2],
            'operasional_cctv'         => ['name' => 'Operasional - CCTV', 'parent' => 'operasional', 'url' => 'https://cctv.ptpn1.co.id/index.php?token=QMekBGJyEv4kFk8tscWzEV2xXFxUWfqvQ2poIDqb1z2LaDJiJzJrGwveJ7DLxz76', 'icon' => 'fa-solid fa-video', 'order' => 3],
            'operasional_onfarmkaret'  => ['name' => 'Operasional - On Farm Karet', 'parent' => 'operasional', 'url' => '/onfarmkaret', 'icon' => 'fa-solid fa-seedling', 'order' => 4],
            'operasional_onfarmteh'    => ['name' => 'Operasional - On Farm Teh', 'parent' => 'operasional', 'url' => '/onfarmteh', 'icon' => 'fa-solid fa-leaf', 'order' => 5],
            'operasional_onfarmkopi'   => ['name' => 'Operasional - On Farm Kopi', 'parent' => 'operasional', 'url' => '/onfarmkopi', 'icon' => 'fa-solid fa-mug-hot', 'order' => 6],
            'operasional_offfarmkaret' => ['name' => 'Operasional - Off Farm Karet', 'parent' => 'operasional', 'url' => '/offfarmkaret', 'icon' => 'fa-solid fa-industry', 'order' => 7],
            'operasional_offfarmteh'   => ['name' => 'Operasional - Off Farm Teh', 'parent' => 'operasional', 'url' => '/offfarmteh', 'icon' => 'fa-solid fa-leaf', 'order' => 8],
            'operasional_offfarmkopi'  => ['name' => 'Operasional - Off Farm Kopi', 'parent' => 'operasional', 'url' => '/offfarmkopi', 'icon' => 'fa-solid fa-mug-hot', 'order' => 9],
            'operasional_sdmpenyadap'  => ['name' => 'Operasional - Monitoring SDM Penyadap', 'parent' => 'operasional', 'url' => '/sdmpenyadap', 'icon' => 'fa-solid fa-users', 'order' => 10],

            // PICA
            'pica_kuadran'             => ['name' => 'PICA - Kuadran Problem', 'parent' => 'pica', 'url' => '/pica/kuadran-problem-identifications', 'icon' => 'fa-solid fa-table-cells-large', 'order' => 1],
            'pica_corrective'          => ['name' => 'PICA - List Corrective Actions', 'parent' => 'pica', 'url' => '/pica/list-corrective-actions', 'icon' => 'fa-solid fa-list-check', 'order' => 2],

            // Sales
            'sales_overview'           => ['name' => 'Sales - Overview Sales', 'parent' => 'sales', 'url' => '/overview_sales', 'icon' => 'fa-solid fa-chart-bar', 'order' => 1],
            'sales_comodities'         => ['name' => 'Sales - Comodities Sales', 'parent' => 'sales', 'url' => '/sales_comodities', 'icon' => 'fa-solid fa-boxes-stacked', 'order' => 2],
            'sales_tea_inventory'      => ['name' => 'Sales - Tea Inventory', 'parent' => 'sales', 'url' => '/soptea', 'icon' => 'fa-solid fa-mug-hot', 'order' => 3],
            'sales_rubber_delivery'    => ['name' => 'Sales - Rubber Delivery', 'parent' => 'sales', 'url' => '/penjualan_karet', 'icon' => 'fa-solid fa-tree', 'order' => 4],
            'sales_crm'                => ['name' => 'Sales - CRM', 'parent' => 'sales', 'url' => '/crm', 'icon' => 'fa-solid fa-tree', 'order' => 5],
            'sales_sonia'              => ['name' => 'Sales - SONIA', 'parent' => 'sales', 'url' => 'DYNAMIC_SONIA_URL', 'icon' => 'fa-solid fa-store', 'order' => 6],
            'aset_peta'                => ['name' => 'Asset - Peta', 'parent' => 'aset', 'url' => '/asset_peta', 'icon' => 'fa-solid fa-map', 'order' => 1],
            'aset_recovery'            => ['name' => 'Asset - Recovery', 'parent' => 'aset', 'url' => '/asset_recovery', 'icon' => 'fa-solid fa-rotate', 'order' => 2],
            'aset_optimalisasi'        => ['name' => 'Asset - Optimalisasi', 'parent' => 'aset', 'url' => '/asset_optimalisasi', 'icon' => 'fa-solid fa-chart-pie', 'order' => 3],
            'aset_divestasi'           => ['name' => 'Asset - Divestasi', 'parent' => 'aset', 'url' => '/asset_divestasi', 'icon' => 'fa-solid fa-hand-holding-dollar', 'order' => 4],

            // Finansial
            'finansial_console'        => ['name' => 'Finansial - Consolidate', 'parent' => 'finansial', 'url' => '/fin_console', 'icon' => 'fa-solid fa-layer-group', 'order' => 1],
            'finansial_parent'         => ['name' => 'Finansial - Parent Only', 'parent' => 'finansial', 'url' => '/fin_parent', 'icon' => 'fa-solid fa-building', 'order' => 2],
            'finansial_ratio'          => ['name' => 'Finansial - Rasio Keuangan', 'parent' => 'finansial', 'url' => '/fin_ratio', 'icon' => 'fa-solid fa-building', 'order' => 3],
            'finansial_executive'      => ['name' => 'Finansial - Executive Dashboard', 'parent' => 'finansial', 'url' => '/fin_executive', 'icon' => 'fa-solid fa-building', 'order' => 4],
            'finansial_sub'            => ['name' => 'Finansial - Subsidiary', 'parent' => 'finansial', 'url' => '/fin_sub', 'icon' => 'fa-solid fa-sitemap', 'order' => 5],

            // HR
            'hr_demographics'          => ['name' => 'HR - Demographics', 'parent' => 'hr', 'url' => '/hr_demographics', 'icon' => 'fa-solid fa-user-group', 'order' => 1],
            'hr_dev'                   => ['name' => 'HR - Learning & Development', 'parent' => 'hr', 'url' => '/hr_dev', 'icon' => 'fa-solid fa-graduation-cap', 'order' => 2],
            'hr_revenue'               => ['name' => 'HR - Revenue & Cost', 'parent' => 'hr', 'url' => '/hr_revenue', 'icon' => 'fa-solid fa-money-bill-trend-up', 'order' => 3],
            'hr_demographic'           => ['name' => 'HR - Demographic', 'parent' => 'hr', 'url' => '/hr_demographic', 'icon' => 'fa-solid fa-user-group', 'order' => 4],
            'hr_sgna'                  => ['name' => 'HR - SGnA', 'parent' => 'hr', 'url' => '/hr_sgna', 'icon' => 'fa-solid fa-user-group', 'order' => 5],

            // Legal
            'legal_tax'                => ['name' => 'Legal - Tax Relaxation', 'parent' => 'legal', 'url' => '/agraria_tax', 'icon' => 'fa-solid fa-percent', 'order' => 1],
            'legal_agraria'            => ['name' => 'Legal - Agraria', 'parent' => 'legal', 'url' => '/agraria', 'icon' => 'fa-solid fa-file-contract', 'order' => 2],

            // Progress
            'progress_sla'             => ['name' => 'Progress - SLA', 'parent' => 'progress', 'url' => '/sla', 'icon' => 'fa-solid fa-clock', 'order' => 1],

            // Pengadaan
            'pengadaan_pra'            => ['name' => 'Pengadaan - Pra Pengadaan', 'parent' => 'pengadaan', 'url' => '/prapengadaan', 'icon' => 'fa-solid fa-clipboard-check', 'order' => 1],
            'pengadaan_proses'         => ['name' => 'Pengadaan - Proses Pengadaan', 'parent' => 'pengadaan', 'url' => '/prosespengadaan', 'icon' => 'fa-solid fa-spinner', 'order' => 2],
            'pengadaan_kontrak'        => ['name' => 'Pengadaan - Kontrak Pengadaan', 'parent' => 'pengadaan', 'url' => '/kontrakpengadaan', 'icon' => 'fa-solid fa-file-signature', 'order' => 3],
            'pengadaan_stok'           => ['name' => 'Pengadaan - Stok Pengadaan', 'parent' => 'pengadaan', 'url' => '/stokpengadaan', 'icon' => 'fa-solid fa-boxes-stacked', 'order' => 4],

            // Carbon
            'carbon_emisi'             => ['name' => 'Carbon - Dashboard Emisi', 'parent' => 'carbon', 'url' => '/dashboardemisi', 'icon' => 'fa-solid fa-smog', 'order' => 1],

            // GIS
            'gis_areal'                => ['name' => 'GIS - Areal', 'parent' => 'gis', 'url' => 'https://gis.ptpn1.co.id/tree.php?id=0&token=eofkp4456432oewkf465oew#', 'icon' => 'fa-solid fa-map', 'order' => 1],
            'gis_ndvi'                 => ['name' => 'GIS - NDVI', 'parent' => 'gis', 'url' => 'http://gis.ptpn1.co.id/mbtiles/tree5.php?id=0&token=eofkp4456432oewkf465oew', 'icon' => 'fa-solid fa-satellite-dish', 'order' => 2],
            'gis_cuaca'                => ['name' => 'GIS - Cuaca', 'parent' => 'gis', 'url' => 'http://aset-dives-dev.ptpn1.co.id/weather?token=234kjjlksflk8y98ksafdklj23', 'icon' => 'fa-solid fa-cloud-sun', 'order' => 3],

            // Skyview
            'skyview_table'            => ['name' => 'Skyview - AGRO Skyview Table', 'parent' => 'skyview', 'url' => '/skyview-table', 'icon' => 'fa-solid fa-map-location-dot', 'order' => 1],
            'skyview_exec'             => ['name' => 'Skyview - Exec Summary', 'parent' => 'skyview', 'url' => '/exec_summary', 'icon' => 'fa-solid fa-map-location-dot', 'order' => 2],

            // LM
            'lm_13'                    => ['name' => 'LM - LM13', 'parent' => 'lm', 'url' => '/lm13', 'icon' => 'fa-solid fa-book-open', 'order' => 1],
            'lm_14'                    => ['name' => 'LM - LM14', 'parent' => 'lm', 'url' => '/lm14', 'icon' => 'fa-solid fa-book-open', 'order' => 2],
            'lm_16'                    => ['name' => 'LM - LM16', 'parent' => 'lm', 'url' => '/lm16', 'icon' => 'fa-solid fa-book-open', 'order' => 3],
            'lm_34'                    => ['name' => 'LM - LM34', 'parent' => 'lm', 'url' => '/lm34_tab', 'icon' => 'fa-solid fa-book-open', 'order' => 4],
            'lm_62'                    => ['name' => 'LM - LM62', 'parent' => 'lm', 'url' => '/lm62', 'icon' => 'fa-solid fa-book-open', 'order' => 5],

            // Sales & Operation
            'pemasaran_karet_sales'    => ['name' => 'Sales & Operation - Karet', 'parent' => 'pemasaran_karet', 'url' => '/sales_operational_karet', 'icon' => 'fa-solid fa-book-open', 'order' => 1],

            // System Management
            'management_users'         => ['name' => 'User Management', 'parent' => 'management', 'url' => '/management/users', 'icon' => 'fa-solid fa-users', 'order' => 1],
            'management_features'      => ['name' => 'Feature Management', 'parent' => 'management', 'url' => '/management/features', 'icon' => 'fa-solid fa-cube', 'order' => 2],
            'management_features_dictionary' => ['name' => 'Kamus Fitur', 'parent' => 'management', 'url' => '/management/features/dictionary', 'icon' => 'fa-solid fa-book-bookmark', 'order' => 3],
            'management_access'        => ['name' => 'Access Management', 'parent' => 'management', 'url' => '/management/access', 'icon' => 'fa-solid fa-shield-halved', 'order' => 4],
            'management_lastlogin'     => ['name' => 'Last Login', 'parent' => 'management', 'url' => '/management/lastlogin', 'icon' => 'fa-solid fa-clock-rotate-left', 'order' => 5],

            // Standalone top-level menus (No parent)
            'mrc'                      => ['name' => 'MRC', 'parent' => null, 'url' => '/mrc', 'icon' => 'fa-solid fa-calendar-days', 'order' => 10],
            'aigr1'                    => ['name' => 'AIGR1', 'parent' => null, 'url' => '/aigri', 'icon' => 'fa-solid fa-robot', 'order' => 160],
            'garda'                    => ['name' => 'Garda AI', 'parent' => null, 'url' => '/gardai', 'icon' => 'fa-solid fa-fire-flame-curved', 'order' => 170],
            'portalaplikasi'           => ['name' => 'Portal Aplikasi', 'parent' => null, 'url' => '/portalaplikasi', 'icon' => 'fa-solid fa-th-large', 'order' => 180],
            'evaluasi_aplikasi'        => ['name' => 'Evaluasi Aplikasi', 'parent' => null, 'url' => '/evaluasi-aplikasi', 'icon' => 'fa-solid fa-clipboard-check', 'order' => 190],
        ];

        foreach ($children as $slug => $data) {
            $parentId = null;
            if ($data['parent']) {
                $parentId = $getFeatureId($data['parent']);
            }

            DB::table('features')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'parent_id' => $parentId,
                    'url' => $data['url'],
                    'icon' => $data['icon'],
                    'sort_order' => $data['order'],
                    'is_sidebar' => true,
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Set is_sidebar ke false untuk fitur yang tidak ada di sidebar
        DB::table('features')->where('slug', 'warehouse')->update(['is_sidebar' => false]);
    }
}
