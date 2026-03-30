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

class ApiController extends Controller
{
    public static function get_data_kebun()
    {
        $regional = $_GET['id_reg'] ?? null;
        $komoditas = $_GET['komoditas'] ?? 2;
        
        // Gunakan INNER JOIN (lebih cepat) dan tambahkan filter regional
        $data = DB::connection('pgsql_secondary')
            ->table('person_data')
            ->select('person_data.kebun_id', 'person_data.regional_id','m_kebun.nama as nama_kebun')
            ->leftJoin('m_kebun', 'person_data.kebun_id', '=', 'm_kebun.id')
            ->whereNotNull('person_data.regional_id')
            ->orderBy('person_data.regional_id');
        if ($komoditas==1) {
            $data->where(function($query) {
                $query->where('positionsdesc', 'like', '%Pemetik%')
                      ->orWhere('positionsdesc', 'like', '%PEMETIK%')
                      ->orWhere('positionsdesc', 'like', '%pemetik%');
            });
        }
        if ($komoditas==2) {
            $data->where(function($query) {
                $query->where('positionsdesc', 'like', '%Penyadap%')
                      ->orWhere('positionsdesc', 'like', '%PENYADAP%')
                      ->orWhere('positionsdesc', 'like', '%penyadap%');
            });
        }
        if ($komoditas==3) {
            $data->where(function($query) {
                $query->where('positionsdesc', 'like', '%Kopi%')
                      ->orWhere('positionsdesc', 'like', '%KOPI%')
                      ->orWhere('positionsdesc', 'like', '%kopi%');
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
        
        return([
            'data' => $allDatakebun,
            'selected_regional' => $selectedRegional,
            'selected_komoditas' => $selectedKomoditas
        ]);
    }

}
