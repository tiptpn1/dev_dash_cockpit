<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PageController extends Controller
{
    public function overview()
    {
        $user = Auth::guard('custom')->user();
        $username = $user->username;
        if($username!='mrc'){
            return view('pages/overviewnew');
        }
        else{
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

    public function sla()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/5d2ef7fa-99cf-44bc-97a1-ad3866a43285/page/ihnUE';
        return view('pages/overview_page', compact('linkiframe'));
    }

    public function dfarmkaret()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/719192ff-2e4c-4680-a6f1-ad1591eac05c/page/p_wsn4ogdumd';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function dfarmteh()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/7fba3d9e-d5ae-4f1a-91c6-22fe03e27029/page/p_wsn4ogdumd';
        return view('pages/overview_page', compact('linkiframe'));
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
            if (! $response->successful()) {
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
                if (! isset($values[$k])) {
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
     * Kolom: regional, unit kebun, jenis gudang, latitude, longitude
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
            ];
            $aliases = [
                'lat' => 'latitude',
                'lng' => 'longitude',
                'long' => 'longitude',
                'unit' => 'unit kebun',
                'jenis' => 'jenis gudang',
            ];
            foreach ($headers as $i => $h) {
                if (isset($colIdx[$h])) {
                    $colIdx[$h] = $i;
                } elseif (isset($aliases[$h])) {
                    $colIdx[$aliases[$h]] = $i;
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
                $pinLocations[] = [
                    'lat' => $lat,
                    'lng' => $lng,
                    'regional' => $colIdx['regional'] !== null && isset($row[$colIdx['regional']]) ? trim($row[$colIdx['regional']]) : '-',
                    'unit_kebun' => $colIdx['unit kebun'] !== null && isset($row[$colIdx['unit kebun']]) ? trim($row[$colIdx['unit kebun']]) : '-',
                    'jenis_gudang' => $colIdx['jenis gudang'] !== null && isset($row[$colIdx['jenis gudang']]) ? trim($row[$colIdx['jenis gudang']]) : '-',
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


}
