<?php
// database/seeders/UserFeatureSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class UserFeatureSeeder extends Seeder
{
    public function run(): void
    {
        // Turunkan rounds bcrypt agar seeding lebih cepat di remote DB
        Config::set('hashing.bcrypt.rounds', 4);
        // ── 1. Master fitur ──────────────────────────────────────────────────
        $featureDefs = [
            ['slug' => 'mrc',        'name' => 'MRC'],
            ['slug' => 'gis',        'name' => 'GIS'],
            ['slug' => 'lm',         'name' => 'LM'],
            ['slug' => 'aigr1',      'name' => 'AIGR1'],
            ['slug' => 'garda',      'name' => 'Garda AI'],
            ['slug' => 'skyview',    'name' => 'AGRO Skyview'],
            ['slug' => 'operasional','name' => 'Operasional'],
            ['slug' => 'aset',       'name' => 'Asset'],
            ['slug' => 'finansial',  'name' => 'Finansial'],
            ['slug' => 'hr',         'name' => 'Human Resource'],
            ['slug' => 'sales',      'name' => 'Sales'],
            ['slug' => 'legal',      'name' => 'Legal & Agraria'],
            ['slug' => 'progress',   'name' => 'Capaian Progres'],
            ['slug' => 'pengadaan',  'name' => 'Pengadaan'],
            ['slug' => 'carbon',     'name' => 'Carbon'],
            ['slug' => 'warehouse',  'name' => 'Warehouse'],
        ];

        foreach ($featureDefs as $feat) {
            DB::table('features')->updateOrInsert(
                ['slug' => $feat['slug']],
                ['name' => $feat['name'], 'updated_at' => now(), 'created_at' => now()]
            );
        }

        // Helper: get feature id by slug
        $featureId = fn(string $slug) => DB::table('features')->where('slug', $slug)->value('id');

        // ── 2. Users + hak akses ─────────────────────────────────────────────
        // Format: [ username, password, role, plant, regional, [features...] ]
        $users = [
            ['admin',              'Nusantara@1',          'admin',      null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','operasional','aset','finansial','hr','sales','legal','progress','pengadaan','carbon','warehouse']],

            ['superadmin',         'Nusantara1@!',         'superadmin', null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','operasional','aset','finansial','hr','sales','legal','progress','pengadaan','carbon','warehouse']],

            ['mrc',                'Nusantara@1',          'viewer',     null, null,
                ['mrc','lm','skyview','warehouse']],

            ['dksk',               'dksk@4121',            'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','operasional','aset','sales','progress','warehouse']],

            ['dkat',               'dkat@5234',            'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','operasional','aset','finansial','progress','warehouse']],

            ['dpsb',               'dpsb@6452',            'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','hr','progress','warehouse']],

            ['dmas1',              'dmas1@7865',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','aset','finansial','progress','warehouse']],

            ['dmas2',              'dmas2@8965',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','aset','finansial','progress','warehouse']],

            ['dpak',               'dpak@9012',            'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','progress','warehouse']],

            ['dpaj',               'dpaj@10112',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','progress','warehouse']],

            ['dmrs',               'dmrs@11546',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','progress','carbon','warehouse']],

            ['dmps',               'dmps@12657',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','progress','carbon','warehouse']],

            ['dhkm',               'dhkm@13567',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','aset','finansial','legal','progress','carbon','warehouse']],

            ['dpti',               'dpti@14234',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','progress','pengadaan','warehouse']],

            ['dpsk',               'dpsk@15123',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','progress','warehouse']],

            ['pmo',                'pmo@16765',            'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','operasional','aset','finansial','hr','sales','legal','progress','pengadaan','carbon','warehouse']],

            ['ti',                 'Nusantara@1',          'admin',      null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','operasional','aset','finansial','hr','sales','legal','progress','pengadaan','carbon','warehouse']],

            ['holding',            'Nusantara@1',          'viewer',     null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','hr','progress','carbon','warehouse']],

            ['pmn',                'pmn@19465',            'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','progress','warehouse']],

            ['dspi',               'dspi@20768',           'admin',      null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','operasional','aset','finansial','hr','sales','legal','progress','pengadaan','carbon','warehouse']],

            ['dktb',               'dktb@21543',           'manager',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','hr','progress','carbon','warehouse']],

            ['dspr',               'dspr@22098',           'viewer',     null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','warehouse']],

            ['dipb',               'dipb@23768',           'viewer',     null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','warehouse']],

            ['dhkl',               'dhkl@24765',           'viewer',     null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','warehouse']],

            ['dosg',               'dosg@25765',           'viewer',     null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','finansial','hr','warehouse']],

            ['direksi',            'direksiNusantara@1',   'direksi',    null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','operasional','aset','finansial','hr','sales','legal','progress','pengadaan','carbon','warehouse']],

            ['dekom',              'Nusantara@1',          'dekom',      null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','warehouse']],

            ['pemasaran_holding',  'pemasaranhold@1',      'viewer',     null, null,
                ['mrc','gis','lm','aigr1','garda','skyview','sales','warehouse']],

            ['kaligua',            'Kaligua@1',            'viewer',     'kaligua', null,
                ['skyview','warehouse']],
        ];

        foreach ($users as [$username, $password, $role, $plant, $regional, $featureSlugs]) {
            // Upsert user
            DB::table('users')->updateOrInsert(
                ['username' => $username],
                [
                    'password'   => Hash::make($password),
                    'role'       => $role,
                    'plant'      => $plant,
                    'regional'   => $regional,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $userId = DB::table('users')->where('username', $username)->value('id');

            // Hapus pivot lama lalu insert baru
            DB::table('user_feature')->where('user_id', $userId)->delete();

            foreach ($featureSlugs as $slug) {
                $fid = $featureId($slug);
                if ($fid) {
                    DB::table('user_feature')->insert([
                        'user_id'    => $userId,
                        'feature_id' => $fid,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->command->info('✅ Seeded ' . count($users) . ' users, 16 features, dan pivot hak akses.');
    }
}
