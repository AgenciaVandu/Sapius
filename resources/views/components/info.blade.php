@include('components.diagnostico')
@include('components.paquete')
@include('components.guia')
@include('components.plataforma')
@include('components.portabilidad')
@include('components.asesoria')
@include('components.simuladores')
@include('components.feedback')
@include('components.garantia')
@include('components.ventas')

<section class="cta">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12 mb-5 cta__flex">
                <div class="cta__incluye">
                    <h5 class="text-center">Tu inscripción incluye</h5>
                    <div class="cta__incluye-contenido">
                        <span>
                        <a href="#" data-toggle="modal" data-target="#popup">
                        Examen diagnóstico
                        </a>    
                        </span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>
                        <a href="#" data-toggle="modal" data-target="#paquete">
                        Paquete escolar
                        </a>   </span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>
                        <a href="#" data-toggle="modal" data-target="#guia">
                        Guía actualizada
                        </a> </span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>
                        <a href="#" data-toggle="modal" data-target="#plataforma">
                        Plataforma 24/7
                        </a>
                        </span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span><a href="#" data-toggle="modal" data-target="#portabilidad">
                        Portabilidad
                        </a></span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>
                            
                        <a href="#" data-toggle="modal" data-target="#asesoria">
                        Asesoría en vivo*
                        </a></span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        
                        <span>
                        <a href="#" data-toggle="modal" data-target="#simuladores">
                        Simuladores por tema, <br> módulos y globales
                        </a>
                       </span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>
                        <a href="#" data-toggle="modal" data-target="#feedback">
                        Feedback en vivo*
                        </a></span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="cta__incluye-contenido">
                        <span>
                        <a href="#" data-toggle="modal" data-target="#garantia">
                        Garantía*
                        </a></span>
                        <img src="{{asset ('img/v1/icon/check.svg')}}" width="25" alt="">
                    </div>
                    <div class="boton">
                        <a data-toggle="modal" data-target="#ventas" class="btn btn-primary">Contactar a un asesor</a>
                    </div>
                </div>
                <div class="text-center pt-2">
                    <small style="color: gray;">Duración 4, 6, 8 y 12 meses / Aplican restricciones <br> Sujeto a disponibilidad</small>

                </div>
            </div>
            <div class="col-lg-7 col-sm-12">
                <div class="orgullo-txt">
                    <h4 class="lead" style="color: gray;">Forma parte de nuestra comunidad</h4>
                    <h2 class="color-gray"><strong>Opiniones de <br>
                        nuestros alumnos</strong></h2>
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

                    <a href="" data-toggle="modal" data-target="#ventas" class="btn btn-primary">Más información</a>
                </div>
            </div>
        </div>
    </div>
</section>