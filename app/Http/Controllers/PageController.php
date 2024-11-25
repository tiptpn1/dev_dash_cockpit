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
        return view('pages/overviewnew');
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
    public function asset_recovery()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/f61c7bcb-c5e4-4f98-ac6d-1c28c30de378/page/joCQE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function asset_optimalisasi()
    {
        $linkiframe = 'https://aset.ptpn1.co.id/C_dashboard_katalog?username=tamu_1&token=aWaKWj2S8jnawejkjwkjekajwkejakww';
        return view('pages/overview_page', compact('linkiframe'));
    }
    public function asset_divestasi()
    {
        $linkiframe = 'https://lookerstudio.google.com/embed/reporting/9e0d8865-4fb9-48bf-946e-08a8ff1e45f5/page/NrNUE';
        return view('pages/overview_page', compact('linkiframe'));
    }
    
    public function portalaplikasi()
    {
        // $linkiframe = 'https://portal.ptpn1.co.id/ ';
        return view('pages/portalaplikasi');
    }

    
}
