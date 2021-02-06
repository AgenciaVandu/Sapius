<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAPIUS</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/icono-sapius.png')}}" />
    <link href="{{ asset('vendor/adminmart/assets/libs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
</head>
<body>

    <header class="section-black">
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-5 shadow-sm">
            <h5 class="my-0 mr-md-auto font-weight-normal contacto"><a href="#"> <img src="{{ asset('img/logo-sapius.png') }}" width="45%" alt="" loading="lazy"> </a></h5>
            <nav class="my-2 my-md-0 mr-md-3">
              <a class="p-2 color-text-white" href="{{ route('login') }}">Entrar</a>
            </nav>
            <a class="btn btn-outline-primary color-text-white" href="{{ route('register') }}">Registro</a>
          </div>
    </header>

    <div class="container-fluid section-black">
        <div class="row pl-5 pr-5">
            <div class="col-md-6 pl-6 pb-4">
                <div class="contaner-title">
                    Cursos Online para aprobar el <span class="color-text">EGEL</span>
                </div>
                <a href="{{ route('register') }}" class="button-title btn btn-danger" style="background-color: #ed6a5a;">COMENZAR</a>
            </div>
            <div class="col-md-6 pr-6 pb-4">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators ">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{ asset('img/slider/IMG_1.jpg') }}"class="d-block w-100" alt="Foto 1"/>
                      </div>
                      <div class="carousel-item">
                        <img src="{{ asset('img/slider/IMG_3.jpg') }}"class="d-block w-100" alt="Foto 2"/>
                      </div>
                      <div class="carousel-item">
                        <img src="{{ asset('img/slider/IMG_4.jpg') }}"class="d-block w-100" alt="Foto 3"/>
                      </div>
                      <div class="carousel-item">
                        <img src="{{ asset('img/slider/IMG_7879.jpg') }}"class="d-block w-100" alt="Foto 4"/>
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
            </div>
        </div>
    </div>

    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="padding-2">
                    <p class="text-title">¿Cuál es tu objetivo?</p>
                    <p class="text-sub-title">Selecciona el objetivo que quieras conseguir</p>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="container-fluid">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active text-title2" id="pills-prepa-tab" data-toggle="pill" href="#prepa">
                    <span>Quiero entrar a la prepa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-title2" id="pills-universidad-tab" data-toggle="pill" href="#universidad">
                    <span>Quiero entrar a la Universidad</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-title2" id="pills-egel-tab" data-toggle="pill" href="#egel">
                    <span>Quiero aprobar el EGEL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-title2" id="pills-maestria-tab" data-toggle="pill" href="#maestria">
                    <span>Quiero aprobar la Maestría</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-title2" id="pills-enarm-tab" data-toggle="pill" href="#enarm">
                    <span>Quiero aprobar el ENARM</span>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="prepa" role="tabpanel">
                <div class="container-fluid p-5">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                            <div class="contaner-title-tabs">
                                Juntos lograremos tu admisión a la <span class="color-text">PREPARATORIA</span>
                                <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el EXANI II.</p>
                            </div>
                            <div class="container-button">
                                <a href="{{ route('register') }}" class="button-title-tabs btn btn-danger" style="background-color: #ed6a5a;">COMENZAR</a>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-1">
                            <img src="{{ asset('img/tabs.png') }}" class="d-block w-100" alt="Foto 1"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="universidad" role="tabpanel">
                <div class="container-fluid p-5">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                            <div class="contaner-title-tabs">
                                Juntos lograremos tu admisión a la <span class="color-text">UNIVERSIDAD</span>
                                <p class="text-sub-title1"> En esta curso obtendras todo lo que necesitas para aprobar el EXANI II</p>
                            </div>
                            <div class="container-button">
                                <a href="{{ route('register') }}" class="button-title-tabs btn btn-danger" style="background-color: #ed6a5a;">COMENZAR</a>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-1 p-3">
                            <img src="{{ asset('img/tabs.png') }}" class="d-block w-100" alt="Foto 1"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="egel" role="tabpanel">
                <div class="container-fluid p-5">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                            <div class="contaner-title-tabs">
                                Juntos lograremos tu admisión al <span class="color-text">EGEL</span>
                                <p class="text-sub-title1"> En esta curso obtendras todo lo que necesitas para aprobar el examen EGEL.</p>
                            </div>
                            <div class="container-button">
                                <a href="{{ route('register') }}" class="button-title-tabs btn btn-danger" style="background-color: #ed6a5a;">COMENZAR</a>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-1 p-3">
                            <img src="{{ asset('img/tabs.png') }}" class="d-block w-100" alt="Foto 1"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="maestria" role="tabpanel">
                <div class="container-fluid p-5">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                            <div class="contaner-title-tabs">
                                Juntos lograremos tu admisión a la <span class="color-text">MAESTRÍA</span>
                                <p class="text-sub-title1"> En esta curso obtendras todo lo que necesitas para aprobar la MAESTRÍA.</p>
                            </div>
                            <div class="container-button">
                                <a href="{{ route('register') }}" class="button-title-tabs btn btn-danger" style="background-color: #ed6a5a;">COMENZAR</a>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-1 p-3">
                            <img src="{{ asset('img/tabs.png') }}" class="d-block w-100" alt="Foto 1"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="enarm" role="tabpanel">
                <div class="container-fluid p-5">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                            <div class="contaner-title-tabs">
                                Juntos lograremos tu admisión al <span class="color-text">ENARM</span>
                                <p class="text-sub-title1"> En esta curso obtendras todo lo que necesitas para aprobar el ENARM.</p>
                            </div>
                            <div class="container-button">
                                <a href="{{ route('register') }}" class="button-title-tabs btn btn-danger" style="background-color: #ed6a5a;">COMENZAR</a>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-1 p-3">
                            <img src="{{ asset('img/tabs.png') }}" class="d-block w-100 img-" alt="Foto 1"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="padding-2">
                    <dl class="row">
                        <dt class="col-sm-1 contacto"><i class="fas fa-chart-line icon-size"></i></dt>
                        <dd class="col-sm-10 text-sub-title">El 98.7% de nuestros estudiantes aprueban.</dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6">
                <div class="padding-2">
                    <dl class="row">
                        <dt class="col-sm-1 contacto"><i class="fas fa-book-open icon-size"></i></dt>
                        <dd class="col-sm-10 text-sub-title">Nuestro método SUMA maximiza tus resultados.</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <hr> -->

    <div class="container-fluid">
        @yield('content')
    </div>

    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 text-center padding-2" >
                <div class="contaner-title-tabs-black">
                    ¿Quieres más información?
                    <p class="text-sub-title-black">Nuestros asesores están felices de ayudarte</p>
                </div>
                <div class="container-button">
                    <button class="button-title-tabs btn btn-danger" data-toggle="modal" data-target="#exampleModal" style="background-color: #ed6a5a;">ENVIAR MENSAJE</button>
                </div>
            </div>
            <div class="col-md-6 text-center padding-2">
                <div class="contaner-title-tabs-black">
                    Modalidad presencial
                    <p class="text-sub-title-black">Puedes aplicar a nuestros cursos de forma presencial</p>
                </div>
                <div class="container-button">
                    <button class="button-title-tabs btn btn-danger" data-toggle="modal" data-target="#exampleModal" style="background-color: #ed6a5a;">MÁS INFORMACIÓN</button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="form-informacion" action="#">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Solicitar información</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="name" name="nombre" class="form-control" id="nombre" placeholder="Escribe tu nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control"id="email" placeholder="Escribe tu correo electrónico" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Teléfono</label>
                    {{-- <input type="tel" name="telefono" class="form-control" id="telefono" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="Escribe tu teléfono" required> --}}
                    <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="Escribe tu teléfono" required>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea class="form-control" name="mensaje" id="mensaje" rows="3" placeholder="Ejemplo: Hola, me gustaría saber un poco más..." required></textarea>
                </div>
                <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                      <label class="form-check-label" for="invalidCheck">
                        Acepto otras comunicaciones
                      </label>
                      <div class="invalid-feedback">
                        You must agree before submitting.
                      </div>
                    </div>
                </div>
                <div class="form-group">
                    <a href="terms/conditions" target="_blank">Consulta los términos y condiciones</a>
                </div>
                <div class="form-group">
                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    <div class="g-recaptcha pt-2"  id="g-recaptcha-contacto" data-sitekey="{{ config('elearning.captcha_data_sitekey') }}"></div>
                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button id="enviar" type="submit" class="btn btn-primary">
            <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
             <span id="span-e">Enviar</span>
          </button>
        </div>
    </form>
      </div>
    </div>
</div>


    <footer class="container-footer">
        <div class="row">
            <div class="col-md-4 logo-container">
                <img src="{{ asset('img/logo-sapius.png') }}" class="img-fluid" width="80%"/>
            </div>
            <div class="col-md-2 offset-md-1 contacto">
                <p class="text-sub-title2">Contacto</p>
                <dl style="color: white;">
                    <dt>Correo:</dt>
                    <dd id="email">contacto@sapius.com.mx</dd>
                    <dt>Redes Sociales:</dt>
                    <dd id="email">
                        <a href="https://www.facebook.com/CursoEgelNutricion1" target="_blank" class="color-text-white">
                            <i class="fab fa-facebook-square"></i>
                        </a>
                    </dd>
                  </dl>
            </div>
            <div class="col-md-5">
                <iframe class="iframe"
                src="https://maps.google.com/?ll=20.966459,-89.623213&z=14&t=m&output=embed"
                height="280" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </footer>
    <script src="{{ asset('vendor/adminmart/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready( function(){
            $('#exampleModal').on('hidden.bs.modal', function (e) {
                $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
            });

            $('#direccion').text('Calle 59 495, Parque Santa Lucia, Centro, 97000 Ejido del Centro, Yuc., México');
            $('#telefono').text('(999) 928-3745');
            $('#email').text('example@example.com');
            //Solicitar informacion
            $('#spinner').hide();
            $( "#form-informacion" ).submit(function( event ) {
                event.preventDefault();

                var response = grecaptcha.getResponse();
                if(response.length == 0)
                {
                    //reCaptcha not verified
                    alert("por favor verifica el captcha");
                }else{
                    //captcha verified
                    $('#spinner').show();
                    $('#span-e').html('Enviando ...');
                    /* Previene hacer submit más de una vez */
                    $("#span-e").prop("disabled", true);
                    var token =  "{{ csrf_token() }}";
                    var nombre =  $("#nombre").val();
                    var email =  $("#email").val();
                    var telefono =  $("#telefono").val();
                    var mensaje =  $("#mensaje").val();
                    $.post("{{ route('informacion') }}", {
                        _token: token,
                        nombre: nombre,
                        email: email,
                        telefono: telefono,
                        mensaje: mensaje
                    },function(){
                    }).done(function(){
                        $('#spinner').hide();
                        $('#span-e').html('Enviado <i class="fa fa-check" aria-hidden="true"></i>');
                        $("#span-e").prop("disabled", false);
                        //bOTON ENVIADO
                    }).fail(function(){
                        alert("Error al solicitar informacion, intente más tarde");
                        $("#span-e").prop("disabled", false);
                    });
                }
            });
        });
    </script>
</body>
</html>
