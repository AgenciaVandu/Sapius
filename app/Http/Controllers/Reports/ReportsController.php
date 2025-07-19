<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Registro\Inscripcion;
use Openpay\Data\Openpay;

class ReportsController extends Controller
{
    public function index(){
        return view('admin.reports.index');
    }


    public function inscriptions(){
        $inscriptions = Inscripcion::where('referencia','!=', 'null')->orderBy('id', 'desc')->paginate(10);

        return view('admin.reports.inscriptions', compact('inscriptions'));
    }

    public function showInscription($id){

        Openpay::setProductionMode(true);
        $openpay = Openpay::getInstance(config('openpay.merchant_id'), config('openpay.private_key'), config('openpay.currency'), config('openpay.ip'));

        $charge = $openpay->charges->get($id);
        /* dd($charge); */
        return view('admin.reports.showInscription', ['charge' => $charge]);
    }
}
