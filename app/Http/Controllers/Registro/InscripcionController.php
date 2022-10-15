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

    public function inscripcion($curso_programado_id)
    {
        $curso = CursoProgramado::with('Curso')->where('id', $curso_programado_id)->first();
        return view('registro.inscripcion')->with('curso', $curso);
    }

    public function pago(Request $request)
    {
        return $request;
        //Codigo para crear la referencia de la transaccion ya sea con tarjeta o en oxxo
        $cursoProgramado = CursoProgramado::with('Curso')->where('id', $request->curso_programado_id)->first();
        $curso = $cursoProgramado->Curso;


        //***********Validar si previamente el alumno fue inscrito*******************


            $inscripcion = new Inscripcion();

            $inscripcion->user_id = Auth::user()->id;
            $inscripcion->curso_programado_id = $request->curso_programado_id;
            $inscripcion->referencia = $request->id;
            $inscripcion->tipo_pago = $request->tipo_cobro;
            $inscripcion->clave = $request->clave;

            $inscripcion->save();

        $send = new Curso;
        return $send->cursoDetallado($request);
    }

    public function payment($request, $curso)
    {
        Conekta::setApiKey(config("elearning.token_conekta"));
        try {
            $order = Order::create(
                [
                    "line_items" => [
                        [
                            "name" => $curso->titulo,
                            "unit_price" => (intval(str_replace(",", "", $request->precio)) * 100),
                            "quantity" => 1 //siempre es un curso
                        ]
                    ],
                    // "shipping_lines" => [
                    //   [
                    //     "amount" => 1500,
                    //     "carrier" => "FEDEX"
                    //   ]
                    // ], //optional - shipping_lines are only required for physical goods
                    "currency" => "MXN",
                    "customer_info" => [
                        "name" => Auth::user()->nombre . " " . Auth::user()->apellido,
                        "email" => Auth::user()->email,
                        "phone" => Auth::user()->telefono
                    ],
                    // "shipping_contact" => [
                    //   "address" => [
                    //     "street1" => "Calle 123, int 2",
                    //     "postal_code" => "06100",
                    //     "country" => "MX"
                    //   ]
                    // ], //optional - shipping_contact is only required for physical goods
                    // "metadata" => ["reference" => "12987324097", "more_info" => "lalalalala"],
                    "charges" => [
                        [
                            "payment_method" => [
                                //"monthly_installments" => 3, //optional
                                "type" => "card",
                                "token_id" => $request->conektaTokenId
                            ] //payment_method - use customer's default - a card
                            //to charge a card, different from the default,
                            //you can indicate the card's source_id as shown in the Retry Card Section
                        ]
                    ]
                ]
            );
        } catch (\Conekta\ProcessingError $error) {
            echo $error->getMessage();
        } catch (\Conekta\ParameterValidationError $error) {
            echo $error->getMessage();
        } catch (\Conekta\Handler $error) {
            echo $error->getMessage();
        }

        return $order;
    }

    public function paymentOxxo()
    {
        Conekta::setApiKey(config("elearning.token_conekta"));
        try {
            $thirty_days_from_now = (new DateTime())->add(new DateInterval('P30D'))->getTimestamp();

            $order = Order::create(
                [
                    "line_items" => [
                        [
                            "name" => "Tacos",
                            "unit_price" => 1000,
                            "quantity" => 12
                        ]
                    ],
                    "shipping_lines" => [
                        [
                            "amount" => 1500,
                            "carrier" => "FEDEX"
                        ]
                    ], //shipping_lines - physical goods only
                    "currency" => "MXN",
                    "customer_info" => [
                        "name" => "Fulanito Pérez",
                        "email" => "fulanito@conekta.com",
                        "phone" => "+5218181818181"
                    ],
                    "shipping_contact" => [
                        "address" => [
                            "street1" => "Calle 123, int 2",
                            "postal_code" => "06100",
                            "country" => "MX"
                        ]
                    ], //shipping_contact - required only for physical goods
                    "charges" => [
                        [
                            "payment_method" => [
                                "type" => "oxxo_cash",
                                "expires_at" => $thirty_days_from_now
                            ]
                        ]
                    ]
                ]
            );
        } catch (\Conekta\ParameterValidationError $error) {
            echo $error->getMessage();
        } catch (\Conekta\Handler $error) {
            echo $error->getMessage();
        }
        //\Log::debug(dd($order));
        //return view('cursos.payment')->with('order',$order);
        return $order;
    }

    public function correoTarjeta($orden)
    {
        $datos = [
            'monto' => ($orden->amount / 100),
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
