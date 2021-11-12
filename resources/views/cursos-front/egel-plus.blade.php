@extends('layouts.landing')
@section('content')
<header class="bg-blue-3">
    <div class="container pad text-center">
        <div class="col-12 pad-1">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                Acredita el <span class=color-lowblue>EGEL Plus</span> Sapius. <br> <span>El 99.1% de nuestros estudiantes acreditan</span>
            </h1>
            <p style="color: #fff;">"Tu formación, es nuestra pasión"</p>
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
                        <h4 class="color-gray">Simulador tipo <br>
                            CENEVAL</h2>
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
<section id="orgullos-sapius">
    <div class="bg-naranja pt-5">
      <div class="container">
        <div class="row orgullo-sapius">
          <div class="col-md-6 col-lg-6 col-sm-12">
            <div class="orgullo-txt-1">
                <h2 class="color-gray">Continúa tu preparación <br>
                    donde quieras</h2>
                <p class="color-gray">Nuestra plataforma ofrece la posibilidad de reproducir el contenido desde tu computadora/laptop y así continúa tu preparación en todo momento.</p>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-sm-12 text-center">
            <img src="{{asset('img/v1/plataforma.png')}}" class=" img-fluid" alt="">
          </div>
        </div>
      </div>
    </div>
</section>
<section id="cta">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12 mb-5">
                <div class="bg-blue-2">
                    <div class="text-center pt-4">
                        <h4 style="color: #fff;">Tu inscripción incluye</h4>
                    </div>
                    <div class="row pad-50">
                        <div class="col-12">
                            <li class="caracteristicas">Examen diagnóstico 
                                <span class="check">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                </span>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">Paquete escolar 
                                <span class="check-1">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                </span> 
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">Guía actualizada Sapius 
                                <span class="check-2">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                </span>  
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">Plataforma 24 / 7   
                                <span class="check-3">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                </span>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">Portabilidad 
                                <span class="check-4">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                </span>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">Asesorías en vivo *   
                                <span class="check-5">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                </span>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">Simuladores por tema, <br>
                                módulos y globales.   
                                <span class="check-6">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                </span>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">Feedback en vivo*  
                                <span class="check-7">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                </span>
                            </li>
                            <hr style="border-color: #fff;">
                        </div>
                        
                    </div>
                </div>
                <div class="text-center pt-2">
                    <li style="color: gray;">Duración 4, 6, 8 y 12 meses **</li>
                    <li style="color: gray;">*Aplican restricciones</li>
                    <li style="color: gray;">**Sujeto a disponibilidad</li>
                </div>
            </div>
            <div class="col-lg-7 col-sm-12">
                <div class="orgullo-txt">
                    <h4 style="color: gray;">Forma parte de nuestra comunidad</h4>
                    <h2 class="color-gray">Opiniones de <br>
                        nuestros alumnos</h2>
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                              <div class="carousel-item active">
                                <p class="color-gray reference">
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
                                <p class="color-gray reference">
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
                                <p class="color-gray reference">
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
                    
                    <a href="" class="btn btn-primary">COMENZAR</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection