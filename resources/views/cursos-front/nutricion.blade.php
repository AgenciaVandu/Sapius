@extends('layouts.landing')
@section('content')
<header class="bg-blue-3">
    <div class="container pad text-center">
        <div class="col-12 pad-1">
            <h1 style="color: #fff;">Prepárate con Sapius <br>
                Acredita el <span class=color-lowblue>EGEL Plus</span> NUTRICIÓN con Sapius. <br> <span>El 99.1% de nuestros estudiantes acreditan</span>
            </h1>
            <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
        
    </div>
</header>
<section id="exani">
    <div class="container pt-5">
        <h2 class="color-gray text-center pt-3">Habilidades que reforzarás en el curso</h2>
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
        <h2 class="color-gray text-center pt-3">Sección Transversal de Lenguaje y Comunicación</h2>
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
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h1 class="color-orange">6</h1>
                <h4 class="color-gray">Atención nutricia<br> 
                    Nutriológica
                </h4>
                <p style="color: gray">1. Evaluación y diagnóstico del estado nutricio.<br>
                    <span>2.Intervención y monitoreo</span> <br>
                </p>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h1 class="color-orange">7</h1>
                <h4 class="color-gray">Programas de intervención <br> 
                nutricional a nivel poblacional
                </h4>
                <p style="color: gray">1.Diagnóstico situacional<br>
                    <span>2. Diseño de la intervención</span> <br>
                    <span>3. Ejecución y evaluación de la intervención</span> <br>
                    <span>4. Sistemas alimentarios</span>
                </p>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12">
                <h1 class="color-orange">8</h1>
                <h4 class="color-gray">Servicios<br> 
                de alimentación
                </h4>
                <p style="color: gray">1. Administración del servicio<br>
                    <span>2. Normativa alimentaria</span> <br>
                    <span>3.Ciencias de los alimentos</span>
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
                        <p class="color-gray">Actualizamos nuestro contenido cada año con base en la bibliografía del EGEL Plus Nutrición</p>
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
<!-- <section id="cta">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12 mb-5">
                <div class="bg-blue-2">
                    <div class="text-center pt-4">
                        <h4 style="color: #fff;">Tu inscripción incluye</h4>
                    </div>
                    <div class="row pad-50">
                        <div class="col-12">
                            <li class="caracteristicas">
                                <div class="row">
                                    <div class="col-10">Examen diagnóstico </div>
                                    <div class="col-2">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        {{-- <span class="check">
                                            <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        </span> --}}
                                    </div>
                                </div>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas"> 
                                <div class="row">
                                    <div class="col-10">Paquete escolar</div>
                                    <div class="col-2">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        {{-- <span class="check">
                                            <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        </span> --}}
                                    </div>
                                </div>
                                </span> 
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas"> 
                                <div class="row">
                                    <div class="col-10">Guía actualizada Sapius</div>
                                    <div class="col-2">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        {{-- <span class="check">
                                            <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        </span> --}}
                                    </div>
                                </div>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">   
                                <div class="row">
                                    <div class="col-10">Plataforma 24 / 7</div>
                                    <div class="col-2">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        {{-- <span class="check">
                                            <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        </span> --}}
                                    </div>
                                </div>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">
                                <div class="row">
                                    <div class="col-10">Portabilidad</div>
                                    <div class="col-2">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        {{-- <span class="check">
                                            <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        </span> --}}
                                    </div>
                                </div>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas"><div class="row">
                                <div class="col-10">Asesorías en vivo*</div>
                                <div class="col-2">
                                    <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                    {{-- <span class="check">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                    </span> --}}
                                </div>
                            </div>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">
                                <div class="row">
                                    <div class="col-10">Simuladores por tema, <br>
                                        módulos y globales.   </div>
                                    <div class="col-2 m-auto pr-1">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        {{-- <span class="check">
                                            <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        </span> --}}
                                    </div>
                                </div>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas">
                                <div class="row">
                                    <div class="col-10">Feedback en vivo*</div>
                                    <div class="col-2 m-auto">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        {{-- <span class="check">
                                            <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        </span> --}}
                                    </div>
                                </div>
                            </li>
                            <hr style="border-color: #fff;">
                            <li class="caracteristicas"> 
                                <div class="row">
                                    <div class="col-10">Garantía*</div>
                                    <div class="col-2">
                                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        {{-- <span class="check">
                                            <img src="{{asset ('img/v1/icon/check.svg')}}" width="40" alt="">
                                        </span> --}}
                                    </div>
                                </div>
                            </li>
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
                    
                    <a href="" class="btn btn-primary">Más información</a>
                </div>
            </div>
        </div>
    </div>
</section> -->
@endsection