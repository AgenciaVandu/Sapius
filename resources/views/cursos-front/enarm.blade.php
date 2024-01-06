@extends('layouts.landing')
@push('title')
<title>Cursos online para el ENARM - Sapius®</title>
@endpush
@push('css')
<link rel="stylesheet" href="{{asset('css/enarm.css')}}">
@endpush
@section('content')
<header class="bg-blue">
    <div class="container text-center">
        <div class="col-12 exani-titular">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                El curso de<span class=color-lowblue> residentes</span> para <br class="d-none d-sm-none d-md-block d-lg-block">futuros <span class=color-lowblue> residentes</span>  
            </h1>
            <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
        
    </div>
</header>
<section class="exani">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-lg-7 col-sm-12 m-auto pb-4 exani__faq">
                <h3 class="color-gray">
                    <strong>Método de trabajo</strong>
                </h3>
                <p class="color-gray">Estamos enfocados 100% al examen ENARM. Con el fin de garantizar la acreditación y el máximo aprovechamiento de cada alumno creamos nuestro método tutorial que te acompañará en el camino con material didáctico actualizado.</p>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
            <div class="col-md-5 col-lg-5 col-sm-12 text-center">
                <div>
                    <img src="{{asset('img/webp/exani-II.webp')}}" class="img-fluid" alt="material exani 2">
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
                        <h4 class="color-gray">Guía <br> ENARM</h2>
                            <p class="color-gray">Actualizamos nuestro contenido cada año con base en la bibliografía del CENEVAL ENARM</p>
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
                <h1 style="color: #fff;">Más de 10 años de excelencia nos respaldan</h1>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
        </div>
    </div>
</section>
@include('components.preparacion')
@include('components.info')
@endsection