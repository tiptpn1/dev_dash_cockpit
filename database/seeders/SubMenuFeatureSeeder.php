<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMenuFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subMenuFeatures = [
            // Operasional
            ['slug' => 'operasional_amanah',       'name' => 'Operasional - AMANAH'],
            ['slug' => 'operasional_dfarm',        'name' => 'Operasional - DFarm PTPN I'],
            ['slug' => 'operasional_cctv',         'name' => 'Operasional - CCTV'],
            ['slug' => 'operasional_onfarmkaret',  'name' => 'Operasional - On Farm Karet'],
            ['slug' => 'operasional_onfarmteh',    'name' => 'Operasional - On Farm Teh'],
            ['slug' => 'operasional_onfarmkopi',   'name' => 'Operasional - On Farm Kopi'],
            ['slug' => 'operasional_offfarmkaret', 'name' => 'Operasional - Off Farm Karet'],
            ['slug' => 'operasional_offfarmteh',   'name' => 'Operasional - Off Farm Teh'],
            ['slug' => 'operasional_offfarmkopi',  'name' => 'Operasional - Off Farm Kopi'],
            ['slug' => 'operasional_sdmpenyadap',  'name' => 'Operasional - Monitoring SDM Penyadap'],

            // PICA
            ['slug' => 'pica_kuadran',             'name' => 'PICA - Kuadran Problem'],
            ['slug' => 'pica_corrective',          'name' => 'PICA - List Corrective Actions'],

            // Warehouse
            ['slug' => 'warehouse_gudang',         'name' => 'Warehouse - Gudang Utilisasi'],

            // Sales
            ['slug' => 'sales_overview',           'name' => 'Sales - Overview Sales'],
            ['slug' => 'sales_comodities',         'name' => 'Sales - Comodities Sales'],
            ['slug' => 'sales_tea_inventory',      'name' => 'Sales - Tea Inventory'],
            ['slug' => 'sales_rubber_delivery',    'name' => 'Sales - Rubber Delivery'],
            ['slug' => 'sales_crm',                'name' => 'Sales - CRM'],
            ['slug' => 'sales_sonia',              'name' => 'Sales - SONIA'],

            // Aset
            ['slug' => 'aset_peta',                'name' => 'Asset - Peta'],
            ['slug' => 'aset_recovery',            'name' => 'Asset - Recovery'],
            ['slug' => 'aset_optimalisasi',        'name' => 'Asset - Optimalisasi'],
            ['slug' => 'aset_divestasi',           'name' => 'Asset - Divestasi'],

            // Finansial
            ['slug' => 'finansial_console',        'name' => 'Finansial - Consolidate'],
            ['slug' => 'finansial_parent',         'name' => 'Finansial - Parent Only'],
            ['slug' => 'finansial_ratio',          'name' => 'Finansial - Rasio Keuangan'],
            ['slug' => 'finansial_executive',      'name' => 'Finansial - Executive Dashboard'],
            ['slug' => 'finansial_sub',            'name' => 'Finansial - Subsidiary'],

            // HR
            ['slug' => 'hr_demographics',          'name' => 'HR - Demographics'],
            ['slug' => 'hr_dev',                   'name' => 'HR - Learning & Development'],
            ['slug' => 'hr_revenue',               'name' => 'HR - Revenue & Cost'],
            ['slug' => 'hr_demographic',           'name' => 'HR - Demographic'],
            ['slug' => 'hr_sgna',                  'name' => 'HR - SGnA'],

            // Legal
            ['slug' => 'legal_tax',                'name' => 'Legal - Tax Relaxation'],
            ['slug' => 'legal_agraria',            'name' => 'Legal - Agraria'],

            // Progress
            ['slug' => 'progress_sla',             'name' => 'Progress - SLA'],

            // Pengadaan
            ['slug' => 'pengadaan_pra',            'name' => 'Pengadaan - Pra Pengadaan'],
            ['slug' => 'pengadaan_proses',         'name' => 'Pengadaan - Proses Pengadaan'],
            ['slug' => 'pengadaan_kontrak',        'name' => 'Pengadaan - Kontrak Pengadaan'],
            ['slug' => 'pengadaan_stok',           'name' => 'Pengadaan - Stok Pengadaan'],

            // Carbon
            ['slug' => 'carbon_emisi',             'name' => 'Carbon - Dashboard Emisi'],

            // GIS
            ['slug' => 'gis_areal',                'name' => 'GIS - Areal'],
            ['slug' => 'gis_ndvi',                 'name' => 'GIS - NDVI'],
            ['slug' => 'gis_cuaca',                'name' => 'GIS - Cuaca'],

            // Skyview
            ['slug' => 'skyview_table',            'name' => 'Skyview - AGRO Skyview Table'],
            ['slug' => 'skyview_exec',             'name' => 'Skyview - Exec Summary'],

            // Laporan Manajemen (LM)
            ['slug' => 'lm_13',                    'name' => 'LM - LM13'],
            ['slug' => 'lm_14',                    'name' => 'LM - LM14'],
            ['slug' => 'lm_16',                    'name' => 'LM - LM16'],
            ['slug' => 'lm_34',                    'name' => 'LM - LM34'],
            ['slug' => 'lm_62',                    'name' => 'LM - LM62'],

            // Pemasaran Karet
            ['slug' => 'pemasaran_karet_sales',    'name' => 'Sales & Operation - Karet'],
        ];

        foreach ($subMenuFeatures as $feat) {
            DB::table('features')->updateOrInsert(
                ['slug' => $feat['slug']],
                ['name' => $feat['name'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
