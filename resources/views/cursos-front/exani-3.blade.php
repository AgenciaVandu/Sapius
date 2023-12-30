@extends('layouts.landing')
@push('title')
<title>Cursos online para el EXANI 3 - Sapius®</title>
@endpush
@push('css')
<link rel="stylesheet" href="{{asset('css/exani3.css')}}">
@endpush
@section('content')
<header class="bg-blue">
    <div class="container text-center">
        <div class="col-12 exani-titular">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                Acredita el <span class=color-lowblue>EXANI-III</span> a la primera e  <br class="d-none d-sm-none d-md-block d-lg-block"> ingresa a la Maestría 
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
                    <strong>¿Qué es el EXANI-III?</strong>
                </h3>
                <p class="color-gray">El Examen Nacional de Ingreso al Posgrado (EXANI-III) es un examen que proporciona información acerca del potencial que los aspirantes tienen para iniciar estudios de tipo superior.</p>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
            <div class="col-md-5 col-lg-5 col-sm-12 text-center">
                <div>
                    <img src="{{asset('img/webp/exani-III.webp')}}" class="img-fluid" alt="material exani 2">
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
                        <h4 class="color-gray">Guía <br> EXANI-III</h2>
                            <p class="color-gray">Actualizamos nuestro contenido cada año con base en la bibliografía del CENEVAL EXANI-III</p>
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
<section class="orgullos-sapius bg-naranja">
    <div class="container">
        <div class="orgullos-sapius__espacio">
            <div class="row ">
                <div class="col-md-12 col-lg-6 col-sm-12 m-auto pb-4 flex-1">
                    <h2 class="color-gray">Continúa tu preparación <br>
                        donde quieras</h2>
                    <p class="color-gray">Nuestra plataforma ofrece la posibilidad de reproducir el contenido desde tu computadora/laptop y así continúa tu preparación en todo momento.</p>
                    <a href="" class="btn btn-primary">COMENZAR</a>
                </div>
                <div class="col-md-12 col-lg-6 col-sm-12 text-center flex-2">
                    <img src="{{asset('img//v1/plataforma.png')}}" class=" img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="cta">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12 mb-5 cta__flex">
                <div class="cta__incluye">
                    <h5 class="text-center">Tu inscripción incluye</h5>
                    <div class="cta__incluye-contenido">
                        <span>Examen diagnóstico</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>Paquete escolar</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>Guía actualizada</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>Plataforma 24/7</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>Portabilidad</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>Asesoría en vivo*</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>Simuladores por tema, <br> módulos y globales</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>Feedback en vivo*</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>Garantía*</span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="boton">
                        <a class="btn btn-primary">Contactar a un asesor</a>
                    </div>
                </div>
                <div class="text-center pt-2">
                    <small style="color: gray;">Duración 4, 6, 8 y 12 meses / Aplican restricciones <br> Sujeto a disponibilidad</small>

                </div>
            </div>
            <div class="col-lg-7 col-sm-12">
                <div class="orgullo-txt">
                    <h5 class="lead" style="color: gray;">Forma parte de nuestra comunidad</h5>
                    <h2 class="color-gray"><strong>Opiniones de <br>
                        nuestros alumnos</strong></h2>
                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <p class="color-gray">
                                    <strong>Alvar Martín</strong> <br>
                                    <span>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span> <br>
                                    <span>
                                        El EXANI-I es un examen que proporciona información acerca del potencial de los aspirantes para tener un buen desempeño en estudios de tipo medio superior. Es utilizado para apoyar los procesos de admisión en las instituciones de la educación media superior.
                                    </span>
                                </p>
                            </div>
                            <div class="carousel-item">
                                <p class="color-gray">
                                    <strong>Gladys Martín</strong> <br>
                                    <span>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span> <br>
                                    <span>
                                        El EXANI-I es un examen que proporciona información acerca del potencial de los aspirantes para tener un buen desempeño en estudios de tipo medio superior. Es utilizado para apoyar los procesos de admisión en las instituciones de la educación media superior.
                                    </span>
                                </p>
                            </div>
                            <div class="carousel-item">
                                <p class="color-gray">
                                    <strong>Yair Martín</strong> <br>
                                    <span>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span> <br>
                                    <span>
                                        El EXANI-I es un examen que proporciona información acerca del potencial de los aspirantes para tener un buen desempeño en estudios de tipo medio superior. Es utilizado para apoyar los procesos de admisión en las instituciones de la educación media superior.
                                    </span>
                                </p>
                            </div>
                        </div>

                    </div>

                    <a href="" class="btn btn-primary">Más información</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection