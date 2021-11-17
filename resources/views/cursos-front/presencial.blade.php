@extends('layouts.landing')
@section('content')
<header class="bg-blue-3">
    <div class="container pad text-center">
        <div class="col-12 pad-1">
            <h1 style="color: #fff;">Forma parte de nuestra comunidad Sapius.<br>
                Vive la experiencia en modo<span class=color-lowblue> Presencial</span> 
            </h1>
            <p style="color: #fff;">"Tu formación, es nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
        
    </div>
</header>
<section id="incluido" class="bg-naranja-3">
    <div class="container">
        <div class="row pt-5 align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <h2>Tasa de aprobados <br> del 99.1%</h2>
                <p>Contamos con la tasa de aprobados más alta a nivel nacional,<br> con una acreditación del 99.1%, con resultados de excelencia.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/1.png')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/2.png')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <h2>Más de 1200 <br>
                    estudiantes nos avalan</h2>
                <p>En la modalidad presencial contamos con más de 1200 estudiantes, satisfechos con sus resultados.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <h2>Profesores expertos en el área
                    con programas actualizados</h2>
                <p>Nuestros profesores cuentan con la máxima experiencia en docencia y cuentan con la mayor experiencia y conocimiento de la especialidad.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/3.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/4.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <h2>Contamos con descuentos por 
                    grupos y pago anticipado</h2>
                <p>Programa de descuentos por grupos de estudiantes (Descuento dependiendo el número) y descuento por pago anticipado.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 align-items-center pt-5">
                <h2>Cupo limitado</h2>
                <p>Nuestros programas educativos cuentan con un grupo limitado de estudiantes con la finalidad de brindar atención personalizada a cada estudiante, para la obtención de excelentes resultados.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/5.jpg')}}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>
<section id="experiencia">
    <div class="bg-2 mt-5">
        <div class="container text-center">
            <div class="posicion">
                <h1 style="color: #fff;">10 años de excelencia nos respaldan</h1>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
        </div>
    </div>
</section>
<section id="prueba" >
    <div class="container justify-content-center">
        <div class="row pt-5">
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-4" style="text-align: right">
                        <img src="{{asset ('img/v1/icon/exni/calendario.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-8 pt-2">
                        <h4 class="color-gray">Contamos con diferentes <br> horarios disponibles</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-4" style="text-align: right">
                        <img src="{{asset ('img//v1/icon/exni/alumno.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-8 pt-2">
                        <h4 class="color-gray">Grupos <br>reducidos</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="orgullos-sapius">
    <div class="bg-naranja pt-2">
      <div class="container text-center">
        <div class="row orgullo-sapius">
          <div class="col-12">
            <div class="titular">
                <h2 class="color-gray">Acredita a la primera y logra tus metas <br> 
                    <span class="color-gray">Conoce nuestro método de enseñanza</span>
                </h2>
            </div>
            <img src="{{asset('img/v1/box.png')}}" class="img-fluid" alt="">
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