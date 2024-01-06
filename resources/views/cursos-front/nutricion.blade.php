@extends('layouts.landing')
@push('title')
<title>Cursos online para el EGEL PLUS NUTRICIÓN - Sapius®</title>
@endpush
@push('css')
<link rel="stylesheet" href="{{asset('css/nutricion.css')}}">
@endpush
@section('content')
<header class="bg-blue">
    <div class="container text-center">
        <div class="col-12 exani-titular ">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                Acredita el <span class=color-lowblue>EGEL PLUS</span> NUTRICIÓN con Sapius. <br class="d-none d-sm-none d-md-block d-lg-block"> <span>El 99.1% de nuestros estudiantes acreditan</span>
            </h1>
            <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
            <a href="{{ route('register') }}" class="btn btn-primary">Comenzar</a>
        </div>
        
    </div>
</header>
<section class="habilidades-exani">
    <div class="container pt-5">
        <h2 class="color-gray text-center pt-3 pb-4">Habilidades que reforzarás en el curso</h2>
        <div class="row pt-3">
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h1 class="color-orange">1</h1>
                <h4 class="color-gray">Atención clínica <br> 
                    Nutriológica
                </h4>
                <p style="color: gray">1. Evaluación del estado de nutrición <br>
                    <span>2. Tratamiento nutriológico individualizado </span> <br>
                    <span>3. Orientación alimentaria individualizada </span> <br>
                    <span>4. Manejo del servicio de nutrición clínica</span>
                </p>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h1 class="color-orange">2</h1>
                <h4 class="color-gray">Atención clínica <br> 
                    Nutriológica
                </h4>
                <p style="color: gray">1. Evaluación de la situación alimentaria y nutricional. <br>
                    <span>2. Desarrollo de intervenciones nutricionales</span> <br>
                    <span>3. Investigación.</span> <br>
                </p>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h1 class="color-orange">3</h1>
                <h4 class="color-gray">Atención clínica <br> 
                    Nutriológica
                </h4>
                <p style="color: gray">1. Manejo de servicios de alimentos<br>
                    <span>2. Normatividad para el control sanitario </span> <br>
                    <span>3. Diseño de planes alimentarios y menús </span> <br>
                    <span>4. Orientación alimentaria</span>
                </p>
            </div>
        </div>
        <h2 class="color-gray text-center pt-5 pb-4">Sección Transversal de Lenguaje y Comunicación</h2>
        <div class="row pt-3">
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h1 class="color-orange">4</h1>
                <h4 class="color-gray">Comprensión<br>
                    lectora 
                </h4>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h1 class="color-orange">5</h1>
                <h4 class="color-gray">Redacción indirecta<br> 
                    Nutriológica
                </h4>
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
                        <h4 class="color-gray">Guía <br> EGEL PLUS</h2>
                            <p class="color-gray">Actualizamos nuestro contenido cada año con base en la bibliografía del CENEVAL EGEL PLUS NUTRICIÓN</p>
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
                <h1 class="cta-1" style="color: #fff;">ACREDITA EL <span class="color-lowblue">EGEL PLUS NUTRICIÓN</span> CON EXCELENCIA <br> <span class="lead">El 40% de nuestros estudiantes obtiene 
                    el premio nacional a la excelencia EGEL</span></h1>
                <a href="{{ route('register') }}" class="btn btn-primary">COMENZAR</a>
            </div>
        </div>
    </div>
</section>
@include('components.preparacion')
@include('components.info')
@endsection