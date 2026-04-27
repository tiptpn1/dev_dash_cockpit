<?php

namespace App\Http\Controllers;

use BigQuery;
use Illuminate\Http\Request;

class BigQueryController extends Controller
{
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
        }
        if ($bulan >= 10 && $bulan < 12) {
            $bulan = '0' . $bulan;
        }
        $tahun_periode = $tahun . $bulan;
        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.$nama_sp`(
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )
            
            ";

            // 1. Buat query config
            $queryConfig = BigQuery::query($query);

            // 2. Set location (INI PENTING 🔥)
            $queryConfig->location('asia-southeast2');

            // 3. Jalankan query
            $queryResults = BigQuery::runQuery($queryConfig);

            // 4. Ambil hasil
            // BigQuery mengembalikan typed objects (Numeric, Date, dll) — konversi ke scalar
            $bqValue = function ($val) {
                if (is_null($val))
                    return null;
                if (is_scalar($val))
                    return $val;
                // Numeric / BigNumeric / Date / Time / Timestamp — semua punya get() atau __toString()
                if (method_exists($val, 'get'))
                    return $val->get();
                return (string) $val;
            };

            $rows = [];
            foreach ($queryResults->rows() as $row) {
                $rowArr = [];
                foreach ($row as $key => $val) {
                    $rowArr[$key] = $bqValue($val);
                }
                $rows[] = $rowArr;
            }

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
        }
        if ($bulan >= 10 && $bulan < 12) {
            $bulan = '0' . $bulan;
        }
        $tahun_periode = $tahun . $bulan;
        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.$nama_sp`(
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )
            
            ";

            // 1. Buat query config
            $queryConfig = BigQuery::query($query);

            // 2. Set location (INI PENTING 🔥)
            $queryConfig->location('asia-southeast2');

            // 3. Jalankan query
            $queryResults = BigQuery::runQuery($queryConfig);

            // 4. Ambil hasil
            // BigQuery mengembalikan typed objects (Numeric, Date, dll) — konversi ke scalar
            $bqValue = function ($val) {
                if (is_null($val))
                    return null;
                if (is_scalar($val))
                    return $val;
                // Numeric / BigNumeric / Date / Time / Timestamp — semua punya get() atau __toString()
                if (method_exists($val, 'get'))
                    return $val->get();
                return (string) $val;
            };

            $rows = [];
            foreach ($queryResults->rows() as $row) {
                $rowArr = [];
                foreach ($row as $key => $val) {
                    $rowArr[$key] = $bqValue($val);
                }
                $rows[] = $rowArr;
            }

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
        }
        if ($bulan >= 10 && $bulan < 12) {
            $bulan = '0' . $bulan;
        }
        $tahun_periode = $tahun . $bulan;
        try {
            $query = "
            CALL `dashboard-cockpit.data_dash.$nama_sp`(
                '$region',
                '$plant',
                '$tahun',
                '$bulan'
            )
            
            ";

            // 1. Buat query config
            $queryConfig = BigQuery::query($query);

            // 2. Set location (INI PENTING 🔥)
            $queryConfig->location('asia-southeast2');

            // 3. Jalankan query
            $queryResults = BigQuery::runQuery($queryConfig);

            // 4. Ambil hasil
            // BigQuery mengembalikan typed objects (Numeric, Date, dll) — konversi ke scalar
            $bqValue = function ($val) {
                if (is_null($val))
                    return null;
                if (is_scalar($val))
                    return $val;
                // Numeric / BigNumeric / Date / Time / Timestamp — semua punya get() atau __toString()
                if (method_exists($val, 'get'))
                    return $val->get();
                return (string) $val;
            };

            $rows = [];
            foreach ($queryResults->rows() as $row) {
                $rowArr = [];
                foreach ($row as $key => $val) {
                    $rowArr[$key] = $bqValue($val);
                }
                $rows[] = $rowArr;
            }

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
