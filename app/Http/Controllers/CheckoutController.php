<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Openpay\Data\Openpay;
use Openpay\Data\OpenpayApiRequestError;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\Inscripcion;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Registro\CursoProgramadoController as Curso;
use App\Mail\TarjetaEmail;
use App\Models\Registro\Descuento;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function createCheckout($curso_id)
    {
        $curso = CursoProgramado::with('Curso')->where('id',$curso_id)->first();
        $user = auth()->user();
        return view('alumno.checkout', compact('curso','user'));
    }


    public function processPay(Request $request)
    {
        /* dd(config('openpay.sandbox')); */
        if (config('openpay.sandbox') == false) {
            Openpay::setProductionMode(true);
        }
        $openpay = Openpay::getInstance(config('openpay.merchant_id'), config('openpay.private_key'), config('openpay.currency'), config('openpay.ip'));

        /* dd($request->all()); */

        $customer = [
            'name' => $request->user_name,
            'last_name' => $request->user_lastname,
            'phone_number' => $request->user_phone,
            'email' => $request->user_email,
        ];

        $chargeData = [
            'method' => 'card',
            'source_id' => $request->token_id,
            'amount' => $request->curso_precio, // formato númerico con hasta dos dígitos decimales.
            'currency' => 'MXN',
            'description' => $request->curso_descripcion,
            'device_session_id' => $request->deviceIdHiddenFieldName,
            'order_id' => $request->curso_id . '-' . auth()->id() . '-' . rand(100, 999),
            "redirect_url" => route('inscripcion.pago', $request->curso_id),
            "use_3d_secure" => "true",
            'customer' => $customer
        ];
        /* return $chargeData; */

        try {
            $charge = $openpay->charges->create($chargeData);
            $redirectUrl = $charge->payment_method->url;

            // 🔁 Redirige al usuario para completar la autenticación 3D Secure
            return redirect($redirectUrl);


        } catch (\Exception $e) {
            // Verifica si es una excepción de Openpay
            if ($e instanceof \Openpay\Data\OpenpayApiRequestError ||
                $e instanceof \Openpay\Data\OpenpayApiTransactionError ||
                $e instanceof \Openpay\Data\OpenpayApiAuthError ||
                $e instanceof \Openpay\Data\OpenpayApiConnectionError) {

                // Accede a los métodos de Openpay
                $code = method_exists($e, 'getErrorCode') ? $e->getErrorCode() : 'Desconocido';
                $description = method_exists($e, 'getDescription') ? $e->getDescription() : $e->getMessage();

                return redirect()->route('errors.payment')->with([
                    'error' => $description,
                    'code' => $code,
                ]);
            }

            // Si no es de Openpay, maneja el error general
            return redirect()->route('errors.payment')->with([
                'error' => $e->getMessage(),
                'code' => $e->getCode(), // este es el "code" general de PHP, no el error_code de Openpay
            ]);
                }

    }

    public function pago(Request $request, $curso_id){
            if (session('descuento') == 100) {
                $cursoProgramado = CursoProgramado::with('Curso')->where('id',$curso_id)->first();

                $descuento = null;
                if (session()->has('cupon')) {
                    $descuento = Descuento::where('clave', session('cupon'))
                        ->where('curso_programado_id', $curso_id)
                        ->where('activo', 'si')
                        ->first();
                    $descuento->limite = $descuento->limite - 1;
                    $descuento->save();
                }

                $curso = $cursoProgramado->Curso;

                $inscripcion = New Inscripcion();

                $inscripcion->user_id = Auth::user()->id;
                $inscripcion->curso_programado_id = $curso_id;
                $inscripcion->referencia = 'Cupon de descuento';
                $inscripcion->tipo_pago = 'Cupon de 100%';
                $inscripcion->clave = session()->has('cupon') ? session('cupon') : null;

                $inscripcion->save();
                //Eliminar la variable de session cupon y descuento
                session()->forget('cupon');
                session()->forget('descuento');

                $datos = [
                        'identificador' => $cursoProgramado->identificador,
                        'precio' => $cursoProgramado->precio,
                        'id_carge' => $inscripcion->id,
                        'name_alumno' => auth()->user()->nombre,
                    ];

                    $mail = Mail::to(Auth::user()->email)->cc(config('mail.to_support'));
                    $m = new TarjetaEmail($datos);
                    $mail->send($m);

                return redirect()->route('checkout.payout.approved', $inscripcion->id);
            }else{
                /* return $_GET['id']; */
            $id_carge = $_GET['id'];
            /* dd(config('openpay.sandbox')); */
                if (config('openpay.sandbox') == false) {
                    Openpay::setProductionMode(true);
                }
                $openpay = Openpay::getInstance(config('openpay.merchant_id'), config('openpay.private_key'), config('openpay.currency'), config('openpay.ip'));
                $charge = $openpay->charges->get($id_carge);

                if ($charge->status === 'completed') {
                    $cursoProgramado = CursoProgramado::with('Curso')->where('id',$curso_id)->first();

                    $descuento = null;
                    if (session()->has('cupon')) {
                        $descuento = Descuento::where('clave', session('cupon'))
                            ->where('curso_programado_id', $curso_id)
                            ->where('activo', 'si')
                            ->first();
                        $descuento->limite = $descuento->limite - 1;
                        $descuento->save();
                    }

                    $curso = $cursoProgramado->Curso;

                    $inscripcion = New Inscripcion();

                    $inscripcion->user_id = Auth::user()->id;
                    $inscripcion->curso_programado_id = $curso_id;
                    $inscripcion->referencia = $id_carge;
                    $inscripcion->tipo_pago = 'Pasarela Openpay';
                    $inscripcion->clave = session()->has('cupon') ? session('cupon') : null;

                    $inscripcion->save();
                    //Eliminar la variable de session cupon y descuento
                    session()->forget('cupon');
                    session()->forget('descuento');

                    $datos = [
                        'identificador' => $cursoProgramado->identificador,
                        'precio' => $cursoProgramado->precio,
                        'id_carge' => $id_carge,
                        'name_alumno' => auth()->user()->nombre,
                    ];

                    $mail = Mail::to(Auth::user()->email)->cc(config('mail.to_support'));
                    $m = new TarjetaEmail($datos);

                    $mail->send($m);

                    /* $send = new Curso; */
                    return redirect()->route('checkout.payout.approved',$id_carge);
                }else{
                    dd('Pago no completado');
                }
            }
        }

        public function chargeApproved($id){
            return view('alumno.approved', compact('id'));
        }

        public function errorPayment(){
            return view('errors.payment');
        }

}