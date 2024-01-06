@extends('layouts.landing')
@push('title')
<title>Cursos online para el EGEL PLUS - Sapius®</title>
@endpush
@push('css')
<link rel="stylesheet" href="{{asset('css/exani3.css')}}">
@endpush
@section('content')
<header class="bg-blue">
    <div class="container text-center">
        <div class="col-12 exani-titular">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                Acredita el <span class=color-lowblue>EGEL PLUS</span> Sapius. <br class="d-none d-sm-none d-md-block d-lg-block"> <span>El 99.1% de nuestros estudiantes acreditan</span>
            </h1>
            <p style="color: #fff;">"Tu formación, es nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
    </div>
</header>
<section class="exani">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-lg-7 col-sm-12 m-auto pb-4 exani__faq">
                <h3 class="color-gray">
                    <strong>¿Cuál es el objetivo del EGEL Plus?</strong>
                </h3>
                <p class="color-gray">El propósito del EGEL plus es identificar si los egresados de la licenciatura cuentan con los conocimientos y las habilidades necesarios para iniciarse eficazmente en el ejercicio de la profesión.</p>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
            <div class="col-md-5 col-lg-5 col-sm-12 text-center">
                <div>
                    <img src="{{asset('img/webp/egel.webp')}}" class="img-fluid" alt="Material EGEL PLUS">
                </div>
            </div>
        </div>
    </div>
</section>


<section class="prueba">
    <div class="container">
        <div class="titular">
            <h2 class="color-gray">Acredita a la primera y logra tus metas <br>
                <span class="color-gray">Conoce nuestro método de enseñanza</span>
            </h2>
        </div>
        <div class="row ">
            <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/icono-e-1.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Video Clases con <br> profesores expertos</h2>
                            <p class="color-gray">Todos nuestros profesores tienen años de experiencia en nuestro método SUMA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/icono-e-2.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Guía <br> EGEL PLUS </h2>
                            <p class="color-gray">Actualizamos nuestro contenido cada año con base en la bibliografía del CENEVAL EGEL PLUS MEDICINA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/icono-e-3.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Simulador tipo <br>
                            CENEVAL</h2>
                            <p class="color-gray">Mide tu conocimiento con exámenes por tema, módulo y exámenes simuladores globales con retroalimentación completa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/icono-e-4.png')}}" class="img-fluid" alt="">
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
@include('components.preparacion')
@include('components.info')
@endsection