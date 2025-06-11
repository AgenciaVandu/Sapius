<?php

namespace App\Http\Controllers\Registro;

use App\Models\Registro\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Registro\CursoProgramado;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Registro\CursoProgramadoController as Curso;
use Conekta\Conekta;
use Conekta\Order;
use DateTime;
use DateInterval;
use App\Mail\TarjetaEmail;
use App\Mail\OxxoEmail;
use Mail;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscripcion $inscripcion)
    {
        //
    }

    public function inscripcion($curso_programado_id){
        $curso = CursoProgramado::with('Curso')->where('id',$curso_programado_id)->first();
        return view('registro.inscripcion')->with('curso',$curso);
    }

    public function pago(Request $request, $curso_id){

            /* dd($request); */
            //Codigo para crear la referencia de la transaccion ya sea con tarjeta o en oxxo
            //$order = new Order;
            $cursoProgramado = CursoProgramado::with('Curso')->where('id',$curso_id)->first();
            $curso = $cursoProgramado->Curso;
            /* try {
            if($request->tipo_cobro == "tarjeta"){
                $order = $this->payment($request,$curso);
                $this->correoTarjeta($order);
            }else if($request->tipo_cobro == "oxxo"){
                $order = $this->paymentOxxo($request);
                $this->correoOxxo($order);
            }else{
                //tipo_cobro no definido
            }
            } catch (\Throwable $th) {

            } */

            //***********Validar si previamente el alumno fue inscrito*******************

            /* if(is_null ($order->id) == false){ */
            $inscripcion = New Inscripcion();

            $inscripcion->user_id = Auth::user()->id;
            $inscripcion->curso_programado_id = $curso_id;
            $inscripcion->referencia = null;
            $inscripcion->tipo_pago = null;
            $inscripcion->clave = null;

            $inscripcion->save();
        /*      } */
            $send = new Curso;
            return redirect()->route('alumno.home');
        }


    public function correoTarjeta($orden)
    {
        $datos = [
            'monto' => ($orden->amount/100),
            'referencia' => $orden->id
        ];
        $mail = Mail::to(Auth::user()->email)->cc(config('mail.to_support'));
        //$mail = Mail::to('eduardoica_@hotmail.com');
        $m = new TarjetaEmail($datos);
        $mail->send($m);

    }

    public function correoOxxo($orden)
    {
        $datos = [
            'monto' => 500,
            'referencia' => 1234567890
        ];
        $mail = Mail::to(Auth::user()->email)->cc(config('mail.to_support'));
        //$mail = Mail::to('eduardoica_@hotmail.com');
        $m = new OxxoEmail($datos);
        $mail->send($m);

    }
}
