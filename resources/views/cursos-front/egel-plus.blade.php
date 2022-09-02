@extends('layouts.landing')
@section('content')
<header class="bg-blue-3">
    <div class="container pad text-center">
        <div class="col-12 pad-1">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                Acredita el <span class=color-lowblue>EGEL Plus</span> Sapius. <br> <span>El 99.1% de nuestros estudiantes acreditan</span>
            </h1>
            <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
    </div>
</header>
<section id="exani">
    <div class="container pt-4">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12 exani">
                <h3 class="color-gray">¿Cuál es el objetivo del EGEL Plus?</h3>
                <p class="color-gray">El propósito del EGEL plus es identificar si los egresados de la licenciatura cuentan con los conocimientos y las habilidades necesarios para iniciarse eficazmente en el ejercicio de la profesión.</p>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 text-center">
                <div>
                    <img src="{{asset('img/v1/exani-III.png')}}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="slider mt-4 m-b4">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active bg-blue">
              <div class="container">
                <div class="row pb-5 pt-5">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h3 class="pt-4 pb-2" style="color: #fff"><span style="color: aqua">Egel Plus</span> MEDICINA</h3>
                        <li>* El 99.1% de nuestros estudiantes acreditan</li>
                        <li>* Paquete escolar completo y envío gratis</li>
                        <li>* Guía EGEL Plus Medicina</li>
                        <li>* Duración de 8 semanas</li>
                        <li>* Video de clases en vivo con docentes expertos</li>
                        <li>* Asesorías en vivo*</li>
                        <li>* Simuladores tipo EGEL Plus (Por módulo y Globales)</li>
                        <li>* Garantía de repetición</li>
                      <a href="{{ route('register') }}" class="btn btn-primary mt-4">COMENZAR</a>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                      <img src="{{asset('/img/monito.png')}}" class="d-block w-100">
                    </div>
                </div>
              </div>
            <a href=""></a>
          </div>
          <div class="carousel-item bg-blue">
            <div class="container">
                <div class="row pb-5 pt-5">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h3 class="pt-4 pb-2" style="color: #fff"><span style="color: aqua">Egel Plus</span> MEDICINA</h3>
                        <li>* El 99.1% de nuestros estudiantes acreditan</li>
                        <li>* Paquete escolar completo y envío gratis</li>
                        <li>* Guía EGEL Plus Medicina</li>
                        <li>* Duración de 8 semanas</li>
                        <li>* Video de clases en vivo con docentes expertos</li>
                        <li>* Asesorías en vivo*</li>
                        <li>* Simuladores tipo EGEL Plus (Por módulo y Globales)</li>
                        <li>* Garantía de repetición</li>
                      <a href="{{ route('register') }}" class="btn btn-primary mt-4">COMENZAR</a>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                      <img src="{{asset('/img/monito.png')}}" class="d-block w-100">
                    </div>
                </div>
              </div>
          </div>
        </div>
       <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </button>
      </div>
</section>
<section id="prueba">
    <div class="container">
        <div class="titular pt-4">
            <h2 class="color-gray">Acredita a la primera y logra tus metas <br> 
                <span class="color-gray">Conoce nuestro método de enseñanza</span>
            </h2>
        </div>
        <div class="row pt-4">
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset ('img/v1/icon/exni/icono-e-1.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Video Clases con <br> profesores expertos</h2>
                        <p class="color-gray">Todos nuestros profesores tienen años de experiencia en nuestro método SUMA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset ('img/v1/icon/exni/icono-e-2.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Guía <br> EGEL Plus</h2>
                        <p class="color-gray">Actualizamos nuestro contenido cada año con base en la bibliografía del EGEL Plus</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset ('img/v1/icon/exni/icono-e-3.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Simulador <br>
                            Especializado
                        </h4>
                        <p class="color-gray">Mide tu conocimiento con exámenes por tema, módulo y exámenes simuladores globales con retroalimentación completa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset ('img/v1/icon/exni/icono-e-4.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Toma clases a la <br> hora que prefieras</h2>
                        <p class="color-gray">Con nuestra plataforma podrás visualizar las clases en el momento que desees, ya que es 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="experiencia">
    <div class="bg-2 mt-5">
        <div class="container text-center">
            <div class="posicion">
                <h1 class="cta-1" style="color: #fff;">ACREDITA EL <span class="color-lowblue">EGEL PLUS</span> CON EXCELENCIA <br> <span class="lead">El 40% de nuestros estudiantes obtiene 
                    el premio nacional a la excelencia EGEL</span></h1>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
        </div>
    </div>
</section>
@include('components.cta')
@endsection