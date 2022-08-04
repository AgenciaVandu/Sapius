@extends('layouts.landing')
@section('content')
<header class="bg-blue-3">
    <div class="container pad text-center">
        <div class="col-12 pad-1">
            <h1 style="color: #fff;">Forma parte de nuestra comunidad Sapius.<br>
                Vive la experiencia en modo<span class=color-lowblue> Presencial</span> 
            </h1>
            <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
        
    </div>
</header>
<section id="incluido" class="bg-naranja-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12 col-sm-12 text-center m-auto">
                <img src="{{asset('img/presencial.png')}}" class="img-fluid" alt="Clases presenciales EGEL PLUS">
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12 m-auto incluido__info">
                <h5>Tasa de aprobados del 99.1%</h5>
                <p>Contamos con la tasa de aprobados más alta a nivel nacional, con una acreditación del 99.1%, con resultados de excelencia.</p>
                <hr>
                <h5>Más de 1200 estudiantes nos avalan</h5>
                <p>En la modalidad presencial contamos con más de 1200 estudiantes, satisfechos con sus resultados.</p>
                <hr>
                <h5>Profesores expertos en el área con programas actualizados</h5>
                <p>Nuestros profesores cuentan con la máxima experiencia en docencia, cuentan con un amplio conocimiento teórico – practico de la especialidad.</p>
                <hr>
                <h5>Contamos con descuentos por grupos y pago anticipado</h5>
                <p>Programa de descuentos por grupos de estudiantes (Descuento dependiendo el número) y descuento por pago anticipado.</p>
                <hr>
                <h5>Contamos con descuentos por grupos y pago anticipado</h5>
                <p>Nuestros programas educativos cuentan con un grupo limitado de estudiantes con la finalidad de brindar atención personalizada a cada estudiante, para la obtención de excelentes resultados.</p>
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#sapius-info">¡Solicita una clase muestra!</button>
            </div>
        </div>
      <!--   <div class="row pt-5 align-items-center">
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
                <p>Nuestros profesores cuentan con la máxima experiencia en docencia, cuentan con un amplio conocimiento teórico – practico de la especialidad.</p>
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
        </div> -->
    </div>
</section>
<section id="experiencia">
    <div class="bg-2 mt-5">
        <div class="container text-center">
            <div class="posicion">
                <h1 style="color: #fff;">Más de 10 años de excelencia nos respaldan</h1>
                <a href="{{ route('register') }}" class="btn btn-primary">COMENZAR</a>
            </div>
        </div>
    </div>
</section>
<section id="prueba" >
    <div class="container justify-content-center">
    <div class="row pt-5">
        <div class="col-md-6 col-lg-6 col-sm-12">
          <div class="centro-card text-center">
            <div class="col-12 pb-3">
            <img src="{{asset ('img/v1/icon/exni/calendario.png')}}" class="img-fluid" alt="">
            </div>
            <div class="col-12">
                <h5 class="color-gray" style="font-weight: 400">Contamos con diferentes <br>horarios disponibles</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-12">
          <div class="centro-card text-center">
            <div class="col-12 pb-3">
            <img src="{{asset ('img//v1/icon/exni/alumno.png')}}" class="img-fluid" alt="">
            </div>
            <div class="col-12">
              <h5 class="color-gray" style="font-weight: 400">Grupos <br>
                reducidos</h5>
            </div>
          </div>
        </div>
      </div>
       <!--  <div class="row pt-5">
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
        </div> -->
    </div>
</section>
<section id="orgullos-sapius">
    <div class="bg-naranja pt-2">
      <div class="container text-center">
        <div class="titular pt-5">
            <h2 class="color-gray">Acredita a la primera y logra tus metas <br> 
                <span class="color-gray">Conoce nuestro método de enseñanza</span>
            </h2>
        </div>
        <div class="row orgullo-sapius">
            
          <div class="col-lg-12">
            <figure>
                <img src="{{asset('img/box-plus.png')}}" class="img-fluid" alt="">
            </figure>
          </div>
        </div>
        <div class="titular pt-2 pb-5">
            <h5 class="color-gray">Maximiza tus oportunidades complementando tu preparación con nuestro <br> paquete escolar + el acceso al contenido digital</span>
            </h2>
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
</section>
@endsection