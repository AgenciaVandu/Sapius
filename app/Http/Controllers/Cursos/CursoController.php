<?php

namespace App\Http\Controllers\Cursos;

use App\Models\Cursos\Curso;
use App\Models\Registro\ContenidoProgramado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Registro\CursoProgramado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Conekta\Conekta;
use Conekta\Order;
use DateTime;
use DateInterval;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::where('activo', 'si')->get();
        return (Auth::user()->rol[0]->slug =='admin') ? view('cursos.index',compact('cursos')) : view('instructor.cursos-index');
    }

    public function getAll($active)
    {
        if($active == "enable")
            $cursos = Curso::where('activo', 'si')->get();
        elseif($active == "disable")
            $cursos = Curso::where('activo', 'no')->get();
        return $cursos->toJson();
    }

    public function getAllForInstructor($active)
    {
        $cursos = Curso::withCount(['CursoProgramado' => function($q){
            $q->where('user_id',Auth::user()->id);
        }])->where('activo', 'si')->get();

        return $cursos->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //vista
        return view('cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curso = new Curso;

        $curso->user_id = auth()->user()->id;
        $curso->titulo = $request->titulo;
        $curso->slug = $request->slug;
        $curso->descripcion = $request->descripcion;
        $curso->imagen = $this->imageUploadPost($request);
        $curso->activo = "si";
        $curso->save();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index')->with('success', 'El curso ha sido agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = Curso::find($id);
        return view('cursos.show',compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $curso = Curso::find($request->id);
        //\Log::debug(dd($curso));
        $edit = true;
        return view('cursos.edit')->with('curso',$curso)->with('edit',$edit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $curso = Curso::find($request->id);
        $curso->titulo = $request->titulo;
        $curso->slug = $request->slug;
        $curso->descripcion = $request->descripcion;
        $curso->imagen = $this->imageUploadPost($request);
        $curso->save();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index')->with('success', 'El curso ha sido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $curso = Curso::find($request->id);
        $curso->activo = "no";
        //\Log::debug(dd($curso));
        $curso->save();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index');
    }

    public function activate(Request $request)
    {
        $curso = Curso::find($request->id);
        $curso->activo = "si";
        //\Log::debug(dd($curso));
        $curso->save();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index');
    }

    public function imageUploadPost(Request $request)
    {
        $file = $request->file('image');
        //\Log::debug(dd($file));
        if(is_null($file) || $request->imgEliminar == "si"){
            //\Log::debug(dd("file null"));
            return null;
        }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        $name = basename(Storage::put('images/cursos', $file));
        return $name;
    }

    public function cursoPicture($file)
    {
        $storagePath = storage_path('app/images/cursos/' . $file);
        return response()->file($storagePath);
    }

    public function video()
    {
        //vista
        return view('cursos.video');
    }

    public function token()
    {
        //vista
        return view('cursos.token');
    }

    public function payment2()
    {
        //vista
        return view('cursos.payment2');
    }

    public function payment(Request $request) {
        Conekta::setApiKey("key_eYvWV7gSDkNYXsmr");
        try{
            $order = Order::create(
              [
                "line_items" => [
                  [
                    "name" => "Tacos",
                    "unit_price" => 1000,
                    "quantity" => 120
                  ]
                ],
                "shipping_lines" => [
                  [
                    "amount" => 1500,
                    "carrier" => "FEDEX"
                  ]
                ], //optional - shipping_lines are only required for physical goods
                "currency" => "MXN",
                "customer_info" => [
                  "name" => "nombre",
                  "email" => "fulanito@conekta.com",
                  "phone" => "5512345678"
                ],
                "shipping_contact" => [
                  "address" => [
                    "street1" => "Calle 123, int 2",
                    "postal_code" => "06100",
                    "country" => "MX"
                  ]
                ], //optional - shipping_contact is only required for physical goods
                "metadata" => ["reference" => "12987324097", "more_info" => "lalalalala"],
                "charges" => [
                  [
                    "payment_method" => [
                      "monthly_installments" => 3, //optional
                      "type" => "card",
                      "token_id" => $request->conektaTokenId
                    ] //payment_method - use customer's default - a card
                      //to charge a card, different from the default,
                      //you can indicate the card's source_id as shown in the Retry Card Section
                  ]
                ]
              ]
            );
          } catch (\Conekta\ProcessingError $error){
            echo $error->getMessage();
          } catch (\Conekta\ParameterValidationError $error){
            echo $error->getMessage();
          } catch (\Conekta\Handler $error){
            echo $error->getMessage();
          }

          //\Log::debug(dd($order));
          return view('cursos.payment')->with('order',$order);
    }

    public function paymentOxxo(Request $request) {
        Conekta::setApiKey("key_eYvWV7gSDkNYXsmr");
        try{
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
          } catch (\Conekta\ParameterValidationError $error){
            echo $error->getMessage();
          } catch (\Conekta\Handler $error){
            echo $error->getMessage();
          }
          //\Log::debug(dd($order));
          return view('cursos.payment')->with('order',$order);
    }
}
