@extends('layouts.landing')
@section('content')
<header class="bg-blue">
    <div class="container pad">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 pad-1 pad-2">
                <h2 style="color: #fff;">Prepárate con Sapius <br>
                    Cursos online para el <span class=color-lowblue>EGEL PLUS</span> 
                </h2>
                <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
                <a href="" class="btn btn-primary">Comenzar</a>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 d-none d-sm-none d-md-none d-lg-block">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{asset ('img/v1/morritos.png')}}" class="w-100 img-fluid" alt="...">
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
            </div>
        </div>
    </div>
</header>
<section class="pt-3 d-none d-sm-none d-md-none d-lg-block">
  <div class="pt-5">
    <div class="container">
      <h1 class="color-gray text-center pb-5" style="line-height: 37px; font-weight:600;">
        ¿Cuál es tu objetivo? <br> <span style="font-size:18px; font-weight:300; color: gray;">Selecciona el objetivo que quieras conseguir</span>
      </h1>
      <ul class="nav nav-tabs nav-justified" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active text-title2" id="pills-prepa-tab" data-toggle="pill" href="#prepa">
                <span>Quiero entrar <br> a la prepa</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-title2" id="pills-universidad-tab" data-toggle="pill" href="#universidad">
                <span>Quiero entrar <br> a la Universidad</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-title2" id="pills-egel-tab" data-toggle="pill" href="#egel">
                <span>Quiero aprobar <br> el EGEL Plus</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-title2" id="pills-maestria-tab" data-toggle="pill" href="#maestria">
                <span>Quiero aprobar <br> la Maestría</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-title2" id="pills-enarm-tab" data-toggle="pill" href="#enarm">
                <span>Quiero aprobar <br> el ENARM</span>
            </a>
        </li>
    
    </ul>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="prepa" role="tabpanel">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 offset-md-1 pad-1">
                        <div class="contaner-title-tabs">
                            <h1 class="juntos">Juntos lograremos tu<br> admisión a la <span class="color-text">Preparatoria</span></h1>
                            <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
                        </div>
                        <div class="container-button">
                            <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ asset('img/v1/1.png') }}" class="img-fluid" alt="Foto 1"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade show" id="universidad" role="tabpanel">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6 offset-md-1 pad-1">
                    <div class="contaner-title-tabs">
                        <h1 class="juntos">Juntos lograremos tu<br> admisión a la <span class="color-text">Universidad</span></h1>
                        <p class="text-sub-title1">En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
                    </div>
                    <div class="container-button">
                        <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('img/v1/2.png') }}" class="img-fluid" alt="Foto 1"/>
                </div>
              </div>
            </div>
        </div>
        <div class="tab-pane fade show" id="egel" role="tabpanel">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-1 pad-1">
                    <div class="contaner-title-tabs">
                        <h1 class="juntos">Juntos lograremos <br> aprobar el <span class="color-text">EGEL Plus</span></h1>
                        <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
                    </div>
                    <div class="container-button">
                        <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
                    </div>
                </div>
                <div class="col-md-4 pt-3 pb-2">
                    <img src="{{ asset('img/egel.png') }}" class="img-fluid" alt="Foto 1"/>
                </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade show" id="maestria" role="tabpanel">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-1 pad-1">
                    <div class="contaner-title-tabs">
                        <h1 class="juntos">Juntos lograremos <br> aprobar la <span class="color-text">Maestría</span></h1>
                        <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
                    </div>
                    <div class="container-button">
                        <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('img/v1/4.png') }}" class="img-fluid" alt="Foto 1"/>
                </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade show" id="enarm" role="tabpanel">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-1 pad-1">
                    <div class="contaner-title-tabs">
                        <h1 class="juntos">Juntos lograremos <br> aprobar el <span class="color-text">ENARM</span></h1>
                        <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
                    </div>
                    <div class="container-button">
                        <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('img/v1/5.png') }}" class="img-fluid" alt="Foto 1"/>
                </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</section >
<!--Movil objetivos-->
<section class="d-block d-sm-block d-md-block d-lg-none pt-5">
  <div class="container">
    <h1 class="color-gray text-center pb-3" style="line-height: 37px; font-weight:600;">
      ¿Cuál es tu objetivo? <br> <span style="font-size:18px; font-weight:300; color: gray;">Selecciona el objetivo que quieras conseguir</span>
    </h1>
  </div>
  <div class="bg-blue pt-4 pb-4">
    <div class="container">
      <div class="col-12">
        <h2 class="juntos text-center">Juntos lograremos tu<br> admisión a la <span class="color-text">Preparatoria</span></h2>
        <p class="text-sub-title1 text-center"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
      </div>
      <div class="col-12 text-center">
        <img src="{{ asset('img/v1/1-m.png') }}" class="img-fluid" alt="Foto 1"/>
      </div>
      <div class="col-12 text-center">
        <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
      </div>
    </div>
  </div>
</section>
<!--end Movil objetivos-->
<section id="orgullos-sapius">
    <div class="bg-naranja pt-5">
      <div class="container">
        <div class="row orgullo-sapius">
          <div class="col-md-12 col-lg-6 centro-card col-sm-12">
            <div class="orgullo-txt">
              <h1 class="color-gray">
                  <strong>Conoce nuestros <br>
                orgullos Sapius.
                  </strong>
              </h1>
                <p class="color-gray">Selecciona el objetivo que quieras conseguir</p>
            </div>
          </div>
          <div class="col-md-12 col-lg-6 col-sm-12 centro-card text-center">
            <div class="orgullo-card">
              <div class="card">
                <div class="cabecera-orgullo">
                  <img src="{{asset('img/v1/penelope-quintanar-Gracia.png')}}" class=" img-fluid" alt="">
                </div>
                <h4 class="color-gray">Penelope Quintanar G.</h4>
                <p class="color-gray">Pasante de nutrición 
                  <span class="color-orange">
                    <br>Premio Nacional a la 
                    <br> Excelencia EGEL
                  </span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<section id="nuestra-plataforma">
    <div class="container pt-5 pb-5">
      <h2 class="color-gray text-center pt-5 pb-4">La plataforma diferente para ser excelente</h2>
      <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-12">
          <div class="row centro-card">
            <div class="col-md-12 col-lg-2 col-sm-12">
              <i class="fas fa-check-circle" style="font-size: 40px; color:#ED6A5A;"></i>
            </div>
            <div class="col-md-12 col-lg-10 col-sm-12">
                <h5 class="color-gray">El 99.1% de nuestros estudiantes acreditan</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
          <div class="row centro-card">
            <div class="col-md-12 col-lg-2 col-sm-12">
              <i class="fas fa-user-graduate" style="font-size: 40px; color:#ED6A5A;"></i>
            </div>
            <div class="col-md-12 col-lg-10 col-sm-12">
              <h5 class="color-gray">Nuestro método SUMA
                maximiza tus resultados</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
          <div class="row centro-card">
            <div class="col-md-12 col-lg-2 col-sm-12">
              <i class="fas fa-book-reader" style="font-size: 40px; color:#ED6A5A;"></i>
            </div>
            <div class="col-md-12 col-lg-10 col-sm-12">
              <h5 class="color-gray">El curso más <br class="d-none d-sm-none d-md-block">
                completo del mercado</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="maestros">
    <div class="bg-blue pt-5 pb-5">
      <div class="container"> <!--Slider-->
        <h2 class="text-center pb-4" style="color: #fff;">Conoce a nuestros docentes</h2>
        <div class="carousel_1">
          <!--Carousel 2-->
          <div class="carousel__contenedor">
              <!--Carousel contenedor-->
              <button aria-label="anterior" class="carousel__anterior">
                  <i class="fas fa-chevron-left"></i>
              </button>
              <div class="carousel__lista1 text-center">
                <div class="carousel__elemento">
                  <div class="maestro-img">
                    <img src="{{asset('img/m-4.png')}}" class="img-fluid pb-3" alt="">
                  </div>
                    <h4 style="color: #fff;">L.N. Verónica</h5>
                    <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar Mensaje</butt>   
                </div>
                <div class="carousel__elemento">
                  <div class="maestro-img">
                    <img src="{{asset('img/m-5.png')}}" class="img-fluid pb-3" alt="">
                  </div>
                    <h4 style="color: #fff;">Dr. Erika</h5>
                    <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar Mensaje</butt>   
                </div>
                <div class="carousel__elemento">
                  <div class="maestro-img">
                    <img src="{{asset('img/m-1.png')}}" class="img-fluid pb-3" alt="">
                  </div>
                    <h4 style="color: #fff;">Dr. Carlos</h5>
                    <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar Mensaje</butt>   
                </div>
                <div class="carousel__elemento">
                  <div class="maestro-img">
                    <img src="{{asset('img/m-2.png')}}" class="img-fluid pb-3" alt="">
                  </div>
                    <h4 style="color: #fff;">Dr. César</h5>
                    <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar Mensaje</butt>   
                </div>
                <div class="carousel__elemento">
                  <div class="maestro-img">
                    <img src="{{asset('img/m-3.png')}}" class="img-fluid pb-3" alt="">
                  </div>
                    <h4 style="color: #fff;">Lic.Trab.Soc Martín</h5>
                    <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar Mensaje</butt>   
                </div>    
              </div>
              <button aria-label="siguiente" class="carousel__siguiente">
                  <i class="fas fa-chevron-right"></i>
              </button>
          </div>
          <div role="tabList" class="carousel__indicadores1"></div>
      </div> <!-- Fint Carousel 2--> 
      </div>
    </div> <!--END Slider-->
      
    </div>
  </section>
  <section id="modalidades">
    <div class="container pt-5 pb-5">
      <div class="row text-center">
        <div class="col-lg-6 col-md-12 col-sm-12 p-info">
          <h2>¿Quieres más información?</h5>
          <p class="color-gray ">Nuestros asesores están felices de ayudarte <br class="d-none d-sm-none d-md-none d-lg-block"><br class="d-none d-sm-none d-md-none d-lg-block"></p>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar mensaje</button>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 p-info">
          <h2>Modalidad Presencial</h5>
          <p class="color-gray">Nuestro cuerpo docente esta disponible para consultas, asesorías, clases, pláticas, conferencias y ponencias.</p>
          <a href="/cursos-presenciales" class="btn btn-primary">Más información</a>
        </div>
      </div>
    </div>
  </section>

@endsection