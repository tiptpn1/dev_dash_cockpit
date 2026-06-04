<?php

namespace App\Http\Controllers;

use BigQuery;
use Illuminate\Http\Request;

class BigQueryController extends Controller
{
    /**
     * Jalankan BigQuery CALL stored procedure dan ambil hasilnya dari child jobs.
     *
     * Penjelasan:
     * - BigQuery::runQuery() → crash "Undefined array key schema" karena CALL berjalan
     *   sebagai "script job" dan schema tidak tersedia di response synchronous.
     * - Solusi: gunakan startQuery() (job-based), tunggu selesai, lalu ambil hasil
     *   dari CHILD JOBS karena script/CALL menyimpan hasil SELECT di child job terakhir.
     */
    private function runBigQueryCall(string $query): array
    {
        $projectId = config('bigquery.projectId', 'dashboard-cockpit');
        $location = 'asia-southeast2';

        // 1. Jalankan CALL sebagai job
        $jobConfig = BigQuery::query($query);
        $jobConfig->location($location);
        $job = BigQuery::startQuery($jobConfig);

        // 2. Tunggu parent job selesai
        $job->waitUntilComplete();

        // 3. Cek error
        $jobInfo = $job->info();
        if (isset($jobInfo['status']['errorResult'])) {
            throw new \RuntimeException(
                $jobInfo['status']['errorResult']['message'] ?? 'BigQuery job failed'
            );
        }

        // 4. Helper konversi nilai BigQuery → PHP scalar
        $bqValue = function ($val) use (&$bqValue) {
            if (is_null($val))
                return null;
            if (is_scalar($val))
                return $val;
            if (is_array($val))
                return array_map($bqValue, $val);
            if (method_exists($val, 'get'))
                return $val->get();
            return (string) $val;
        };

        // 5. Coba ambil hasil dari parent job terlebih dahulu
        //    (berlaku untuk query SELECT biasa yang berjalan via startQuery)
        $parentQR = $job->queryResults();
        $parentInfo = $parentQR->info();

        if (isset($parentInfo['schema']['fields'])) {
            $rows = [];
            foreach ($parentQR->rows() as $row) {
                $rowArr = [];
                foreach ($row as $key => $val) {
                    $rowArr[$key] = $bqValue($val);
                }
                $rows[] = $rowArr;
            }
            return $rows;
        }

        // 6. Jika parent job tidak punya schema (kasus CALL/script job),
        //    iterasi child jobs untuk cari SELECT result-nya.
        //
        //    BigQuery mengembalikan child jobs dalam urutan eksekusi (yang pertama
        //    dijalankan = pertama di list). Statement SELECT terakhir dalam prosedur
        //    adalah child job TERAKHIR. Oleh karena itu kita kumpulkan SEMUA child
        //    jobs dulu, lalu iterasi seluruhnya sambil terus meng-overwrite $finalRows
        //    — sehingga hasil akhirnya adalah output dari SELECT TERAKHIR prosedur.
        $parentJobId = $job->id();

        $childJobs = BigQuery::jobs([
            'parentJobId' => $parentJobId,
            'location' => $location,
            'projectId' => $projectId,
        ]);

        // Kumpulkan semua child jobs ke array agar bisa diiterasi seluruhnya
        $allChildJobs = [];
        foreach ($childJobs as $childJob) {
            $allChildJobs[] = $childJob;
        }

        // Iterasi semua child jobs; simpan hasil dari SETIAP child job yang punya rows.
        // Dengan selalu meng-overwrite, $finalRows akan berisi hasil dari child job
        // terakhir yang menghasilkan data — yaitu final SELECT dari stored procedure.
        $finalRows = [];

        foreach ($allChildJobs as $childJob) {
            try {
                $childQR = $childJob->queryResults();
                $childInfo = $childQR->info();

                // Skip child job yang tidak punya schema (DML, DDL, SET, dsb.)
                if (!isset($childInfo['schema']['fields'])) {
                    continue;
                }

                $tempRows = [];
                foreach ($childQR->rows() as $row) {
                    $rowArr = [];
                    foreach ($row as $key => $val) {
                        $rowArr[$key] = $bqValue($val);
                    }
                    $tempRows[] = $rowArr;
                }

                // Overwrite dengan hasil terbaru — yang terakhir adalah output akhir
                if (!empty($tempRows)) {
                    $finalRows = $tempRows;
                }
            } catch (\Throwable $e) {
                // Child job non-SELECT bisa throw error — skip
                continue;
            }
        }

        return $finalRows;
    }

    // ── LM13 ─────────────────────────────────────────────────────────────────

    public function get_data_lm13(Request $request)
    {
        $komoditi = strtolower($request->komoditi);
        $nama_sp = '';
        if ($komoditi == 'kr') {
            $nama_sp = 'sp_laporan_lm13_karet';
        } else if ($komoditi == 'th') {
            $nama_sp = 'sp_laporan_lm13_teh';
        } else if ($komoditi == 'kp') {
            $nama_sp = 'sp_laporan_lm13_kopi';
        }

        if (empty($nama_sp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Komoditi tidak valid. Pilih salah satu Komoditi',
            ], 400);
        }

        $region = $request->region;
        $plant = $request->plant;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($bulan < 10) {
            $bulan = '00' . $bulan;
        } elseif ($bulan >= 10 && $bulan <= 12) {
            $bulan = '0' . $bulan;
        }

        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.$nama_sp`(
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )";

            $rows = $this->runBigQueryCall($query);

            return response()->json([
                'status' => 'success',
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

    // ── LM14 ─────────────────────────────────────────────────────────────────

    public function get_data_lm14(Request $request)
    {
        $komoditi = strtolower($request->komoditi);
        $nama_sp = '';
        if ($komoditi == 'kr') {
            $nama_sp = 'sp_laporan_lm14_karet';
        } else if ($komoditi == 'th') {
            $nama_sp = 'sp_laporan_lm14_teh';
        } else if ($komoditi == 'kp') {
            $nama_sp = 'sp_laporan_lm14_kopi';
        }

        if (empty($nama_sp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Komoditi tidak valid. Pilih salah satu Komoditi',
            ], 400);
        }

        $region = $request->region;
        $plant = $request->plant;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($bulan < 10) {
            $bulan = '00' . $bulan;
        } elseif ($bulan >= 10 && $bulan <= 12) {
            $bulan = '0' . $bulan;
        }

        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.$nama_sp`(
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )";

            $rows = $this->runBigQueryCall($query);

            return response()->json([
                'status' => 'success',
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

    // ── LM16 ─────────────────────────────────────────────────────────────────

    public function get_data_lm16(Request $request)
    {
        $komoditi = strtolower($request->komoditi);
        $nama_sp = '';
        if ($komoditi == 'kr') {
            $nama_sp = 'sp_laporan_lm16_karet';
        } else if ($komoditi == 'th') {
            $nama_sp = 'sp_laporan_lm16_teh';
        } else if ($komoditi == 'kp') {
            $nama_sp = 'sp_laporan_lm16_kopi';
        }

        if (empty($nama_sp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Komoditi tidak valid. Pilih salah satu Komoditi',
            ], 400);
        }

        $region = $request->region;
        $plant = $request->plant;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($bulan < 10) {
            $bulan = '00' . $bulan;
        } elseif ($bulan >= 10 && $bulan <= 12) {
            $bulan = '0' . $bulan;
        }

        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.$nama_sp`(
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )";

            $rows = $this->runBigQueryCall($query);

            return response()->json([
                'status' => 'success',
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

    // ── LM34 ─────────────────────────────────────────────────────────────────

    public function get_data_lm34(Request $request)
    {
        $komoditi = strtolower($request->komoditi);
        $nama_komoditi = '';
        if ($komoditi == 'kr') {
            $nama_komoditi = 'karet';
        } else if ($komoditi == 'th') {
            $nama_komoditi = 'teh';
        } else if ($komoditi == 'kp') {
            $nama_komoditi = 'kopi';
        }

        $region = $request->region;
        $plant = $request->plant;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($bulan < 10) {
            $bulan = '00' . $bulan;
        } elseif ($bulan >= 10 && $bulan <= 12) {
            $bulan = '0' . $bulan;
        }

        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.sp_laporan_lm34`(
                '$nama_komoditi',
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )";

            $rows = $this->runBigQueryCall($query);

            return response()->json([
                'status' => 'success',
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

    // ── LM34 by Negara ───────────────────────────────────────────────────────

    public function get_data_lm34_by_negara(Request $request)
    {
        $komoditi = strtolower($request->komoditi);
        $nama_komoditi = '';
        if ($komoditi == 'kr') {
            $nama_komoditi = 'karet';
        } else if ($komoditi == 'th') {
            $nama_komoditi = 'teh';
        } else if ($komoditi == 'kp') {
            $nama_komoditi = 'kopi';
        }

        $region = $request->region;
        $plant = $request->plant;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($bulan < 10) {
            $bulan = '00' . $bulan;
        } elseif ($bulan >= 10 && $bulan <= 12) {
            $bulan = '0' . $bulan;
        }

        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.sp_laporan_lm34_by_negara`(
                '$nama_komoditi',
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )";

            $rows = $this->runBigQueryCall($query);

            return response()->json([
                'status' => 'success',
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

    // ── LM34 by Customer ─────────────────────────────────────────────────────

    public function get_data_lm34_by_customer(Request $request)
    {
        $komoditi = strtolower($request->komoditi);
        $region = $request->region;
        $plant = $request->plant;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($bulan < 10) {
            $bulan = '00' . $bulan;
        } elseif ($bulan >= 10 && $bulan <= 12) {
            $bulan = '0' . $bulan;
        }

        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.sp_laporan_lm34_by_customer`(
                '$komoditi',
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )";

            $rows = $this->runBigQueryCall($query);

            return response()->json([
                'status' => 'success',
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

    public function get_data_lm62(Request $request)
    {
        $komoditi = strtolower($request->komoditi);
        $region = $request->region;
        $plant = $request->plant;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($bulan < 10) {
            $bulan = '00' . $bulan;
        } elseif ($bulan >= 10 && $bulan <= 12) {
            $bulan = '0' . $bulan;
        }

        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.sp_laporan_lm62`(
                '$komoditi',
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )";

            $rows = $this->runBigQueryCall($query);

            return response()->json([
                'status' => 'success',
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

}
