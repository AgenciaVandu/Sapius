@extends('layouts.landing')
@section('content')
<header class="bg-blue-3">
    <div class="container pad text-center">
        <div class="col-12 pad-1">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                Acredita el <span class=color-lowblue>EGEL Plus</span> MEDICINA con Sapius. <br> <span>El 99.1% de nuestros estudiantes acreditan</span>
            </h1>
            <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
        
    </div>
</header>
<section id="exani">
    <div class="container pt-5">
        <h2 class="color-gray text-center pt-3">Habilidades que reforzarás en el curso <br>
            <span style="font-size: 20px">Sección Disciplinar Específica</span>
        </h2>
        <div class="row pt-3">
            <div class="col-lg-4 col-md-6 col-lg-3 col-sm-12">
                <h1 class="color-orange">1</h1>
                <h5 class="color-gray">Abordaje clínico <br> 
                </h5>
                <p style="color: gray">1. Identificación del problema de salud <br>
                    <span>2. Diagnóstico de la comunidad</span> <br>
                    <span>3. Terapéutica</span> <br>
                </p>
            </div>
            <div class="col-lg-4 col-md-6 col-lg-3 col-sm-12">
                <h1 class="color-orange">2</h1>
                <h5 class="color-gray">Promoción de la salud <br> 
                </h5>
                <p style="color: gray">1. Prevención<br>
                    <span>2. Protección específica</span> <br>
                    <span>3. Educación para la salud</span> <br>
                </p>
            </div>
            <div class="col-lg-4 col-md-6 col-lg-3 col-sm-12">
                <h1 class="color-orange">3</h1>
                <h5 class="color-gray">Fundamento de las decisiones médicas
                </h5>
                <p style="color: gray">1. Investigación en Ciencias Médicas<br>
                    <span>2. Medicina basada en evidencias</span> <br>
                    <span>3. Bioética y marco legal de la medicina</span> <br>
                    <span>4. Salud pública y global</span> <br>
                </p>
            </div>
            <div class="col-12">
                <h2 class="color-gray text-center pt-3 pb-3">Sección Transversal de Lenguaje y Comunicación</h2>
            </div>
            <div class="col-lg-4 col-md-6 col-lg-3 col-sm-12">
                <h1 class="color-orange">4</h1>
                <h5 class="color-gray">Comprensión lectora <br> 
                </h5>
                <p style="color: gray">1. Ámbito de estudio<br>
                    <span>2. Ámbito literario</span> <br>
                    <span>3. Ámbito de participación social</span> <br>
                </p>
            </div>
            <div class="col-lg-4 col-md-6 col-lg-4 col-sm-12">
                <h1 class="color-orange">5</h1>
                <h5 class="color-gray">Redacción indirecta nutriológica
                </h5>
                <p style="color: gray">1. Ámbito de estudio<br>
                    <span>2. Ámbito de participación social</span> <br>
                </p>
            </div>
        </div>
        
    </div>
</section>
<section id="prueba">
    <div class="container">
        <div class="titular pt-5">
            <h2 class="color-gray">Acredita a la primera y logra tus metas <br> 
                <span class="color-gray">Conoce nuestro método de enseñanza</span>
            </h2>
        </div>
        <div class="row pt-4">
            <div class="col-md-6 col-lg-6 col-sm-12">
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
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/icono-e-2.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Guía <br> EGEL Plus</h2>
                        <p class="color-gray">Actualizamos nuestro contenido cada año con base en la bibliografía del EGEL Plus Medicina</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
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
            <div class="col-md-6 col-lg-6 col-sm-12">
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

@include('components.cta')
@endsection