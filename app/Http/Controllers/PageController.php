<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $linkiframe = 'https://aset.ptpn1.co.id/C_peta_aset?username=tamu_1&token=aWaKWj2S8jnawejkjwkjekajwkejakww';
        return view('pages/overview_page', compact('linkiframe'));
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

    
}
