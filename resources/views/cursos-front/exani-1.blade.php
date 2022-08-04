@extends('layouts.landing')
@section('content')
<header class="bg-blue-1">
    <div class="container pad text-center">
        <div class="col-12 pad-1">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                Acredita el <span class=color-lowblue>EXANI-I</span> a la primera e <br class="d-none d-sm-none d-md-none d-lg-block"> ingresa a la Preparatoria 
            </h1>
            <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
        
    </div>
</header>
<section id="exani">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12 exani">
                <h3 class="color-gray">¿Qué es el EXANI-I?</h3>
                <p class="color-gray">El EXANI-I es un examen que proporciona información acerca del potencial de los aspirantes para tener un buen desempeño en estudios de tipo medio superior. Es utilizado para apoyar los procesos de admisión en las instituciones de la educación media superior.</p>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 text-center">
                <div>
                    <img src="{{asset ('img/v1/exani-1.png')}}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
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
            <div class="col-md-6 col-lg-6 col-sm-12 pt-3">
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
            <div class="col-md-6 col-lg-6 col-sm-12 pt-3">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/icono-e-2.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Guía <br> EXANI-I</h2>
                        <p class="color-gray">Actualizamos nuestro contenido cada año con base en la bibliografía del CENEVAL EXANI-I</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 pt-3">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/icono-e-3.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Simulador <br>
                            Especializado
                        </h4>
                        <p class="color-gray">Mide tu conocimiento con exámenes por tema, módulo y exámenes simuladores globales con retroalimentación completa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 pt-3">
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
@include('components.cta')
@endsection
