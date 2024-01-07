@extends('layouts.landing')
@push('title' )
<title>Cursos online para aprobar el EGEL PLUS - Sapius®</title>
@endpush
@push('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endpush
@section('content')
<header class="header__intro">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-12 col-sm-12 m-auto txt-banner">
        <h1 style="color: #fff;">Prepárate con Sapius <br>
          Cursos online para el <span class=color-lowblue>EGEL PLUS</span>
        </h1>
        <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
        <a href="{{ route('register') }}" class="btn btn-primary">Comenzar</a>
      </div>
      <div class="col-lg-5 col-md-12 col-sm-12 banner">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="{{asset ('img/v1/morritos.png')}}" class="w-100 img-fluid" alt="Estudiantes EGEL" loading="lazy">>
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
@include('components.ventas')
<section class="objetivos pt-3">
  <div class="pt-5">
    <div class="container">
      <h1 class="text-center pb-5">
        <strong>¿Cuál es tu objetivo?</strong> <br> <span style="font-size:18px; font-weight:300; color: gray;">Selecciona el objetivo que quieras conseguir</span>
      </h1>
      <ul class="nav nav-tabs nav-justified" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active text-title2" id="pills-prepa-tab" data-toggle="pill" href="#prepa">
            <span>Quiero entrar <br class="d-none d-sm-none d-md-block d-lg-block"> a la prepa</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-title2" id="pills-universidad-tab" data-toggle="pill" href="#universidad">
            <span>Quiero entrar <br class="d-none d-sm-none d-md-block d-lg-block"> a la Universidad</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-title2" id="pills-egel-tab" data-toggle="pill" href="#egel">
            <span>Quiero aprobar <br class="d-none d-sm-none d-md-block d-lg-block"> el EGEL Plus</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-title2" id="pills-maestria-tab" data-toggle="pill" href="#maestria">
            <span>Quiero aprobar <br class="d-none d-sm-none d-md-block d-lg-block"> la Maestría</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-title2" id="pills-enarm-tab" data-toggle="pill" href="#enarm">
            <span>Quiero aprobar <br class="d-none d-sm-none d-md-block d-lg-block"> el ENARM</span>
          </a>
        </li>

      </ul>
    </div>

    <div class="tab-content pills-objetivos" id="pills-tabContent">
      <div class="tab-pane fade show active" id="prepa" role="tabpanel">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-7 m-auto">
              <div class="contaner-title-tabs">
                <h1>Juntos lograremos tu<br> admisión a la <span>Preparatoria</span></h1>
                <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
              </div>
              <div class="container-button">
                <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
              </div>
            </div>
            <div class="col-md-5 text-center objetivo">
              <img src="{{ asset('img/v1/1.png') }}" class="img-fluid" alt="Foto 1" loading="lazy">
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade show" id="universidad" role="tabpanel">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-7 m-auto">
              <div class="contaner-title-tabs">
                <h1 class="juntos">Juntos lograremos tu<br> admisión a la <span class="color-text">Universidad</span></h1>
                <p class="text-sub-title1">En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
              </div>
              <div class="container-button">
                <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
              </div>
            </div>
            <div class="col-md-5 objetivo">
              <img src="{{ asset('img/v1/2.png') }}" class="img-fluid" alt="Foto 1" loading="lazy">
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade show" id="egel" role="tabpanel">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-7 m-auto">
              <div class="contaner-title-tabs">
                <h1>Juntos lograremos <br> aprobar el <span>EGEL Plus</span></h1>
                <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
              </div>
              <div class="container-button">
                <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
              </div>
            </div>
            <div class="col-md-5 objetivo">
              <img src="{{ asset('img/egel.png') }}" class="img-fluid" alt="Foto 1" loading="lazy">
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade show" id="maestria" role="tabpanel">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-7 m-auto">
              <div class="contaner-title-tabs">
                <h1>Juntos lograremos <br> aprobar la <span class="color-text">Maestría</span></h1>
                <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
              </div>
              <div class="container-button">
                <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
              </div>
            </div>
            <div class="col-md-5 objetivo">
              <img src="{{ asset('img/v1/4.png') }}" class="img-fluid" alt="Foto 1" loading="lazy">
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade show" id="enarm" role="tabpanel">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-7 m-auto">
              <div class="contaner-title-tabs">
                <h1>Juntos lograremos <br> aprobar el <span class="color-text">ENARM</span></h1>
                <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar el examen.</p>
              </div>
              <div class="container-button">
                <a href="{{ route('register') }}" class="button-title-tabs btn btn-primary">COMENZAR</a>
              </div>
            </div>
            <div class="col-md-5 objetivo">
              <img src="{{ asset('img/v1/5.png') }}" class="img-fluid" alt="Foto 1" loading="lazy">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="bg-naranja">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-6 col-sm-12 m-auto orgullo-txt">
          <h1 class="color-gray ">
            <strong>Conoce nuestros <br>
              orgullos Sapius.
            </strong>
          </h1>
          <p class="color-gray">Selecciona el objetivo que quieras conseguir</p>
        </div>
        <div class="col-md-12 col-lg-6 col-sm-12 centro-card text-center">
          <div class="card">
            <div class="cabecera-orgullo">
              <img src="{{asset('img/v1/penelope-quintanar-Gracia.png')}}" class="img-fluid" loading="lazy">>
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
</section>

<section class="plataforma">
  <div class="container">
    <h3 class="color-gray text-center pb-4">La plataforma diferente para ser excelente</h3>
    <div class="row plataforma__height">
      <div class="col text-center">
        <i class="fas fa-check-circle" style="font-size: 40px; color:#ED6A5A;"></i>
        <h5 class="color-gray pt-3">El 99.1% de nuestros <br class="d-none d-sm-none d-md-block d-lg-block"> estudiantes acreditan</h5>
      </div>
      <div class="col text-center">
        <i class="fas fa-user-graduate" style="font-size: 40px; color:#ED6A5A;"></i>
        <h5 class="color-gray pt-3">Nuestro método <b>SUMA</b>
          maximiza <br class="d-none d-sm-none d-md-none d-lg-block">tus resultados</h5>
      </div>
      <div class="col text-center">
        <i class="fas fa-book-reader" style="font-size: 40px; color:#ED6A5A;"></i>
        <h5 class="color-gray pt-3">El curso más
          completo <br class="d-none d-sm-none d-md-block d-lg-block"> del mercado</h5>
      </div>
    </div>
  </div>
</section>

<section class="docentes">
  <div class="container"> <!--Slider-->
    <h2 class="text-center " style="color: #fff;">Conoce a nuestros docentes</h2>
    <div class="docentes__contenedor">
      <div class="docentes__persona">
        <div class="maestro-img">
          <img src="{{asset('img/m-4.png')}}" class="img-fluid pb-3" alt="Verónica Sansores" loading="lazy">
        </div>
        <h5 style="color: #fff;">
          L.N. Verónica González <br> <small style="color: #30D6E6;">Premio Nacional Excelencia EGEL</small>
        </h5>
        <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para pláticas, conferencias y ponencias.
        </small>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar mensaje</butt>
      </div>
      <div class="docentes__persona">
        <div class="maestro-img">
          <img src="{{asset('img/m-5.png')}}" class="img-fluid pb-3" alt="Maestro sapius" loading="lazy">>
        </div>
        <h5 style="color: #fff;">Dr. Erika González <br> <small style="color: #30D6E6;">Residente de Neurología</small></h5>
        <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para pláticas, conferencias y ponencias.
        </small>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar mensaje</butt>
      </div>

      <div class="docentes__persona">
        <div class="maestro-img">
          <img src="{{asset('img/m-2.png')}}" class="img-fluid pb-3" alt="Maestro sapius" loading="lazy">>
        </div>
        <h5 style="color: #fff;">Dr. César Estrada <br> <small style="color: #30D6E6; ">Cirujano Plástico Estético</small></h5>
        <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para pláticas, conferencias y ponencias.
        </small>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar mensaje</butt>
      </div>
      <div class="docentes__persona">
        <div class="maestro-img">
          <img src="{{asset('img/m-3.png')}}" class="img-fluid pb-3" alt="Maestro sapius" loading="lazy">>
        </div>
        <h5 style="color: #fff;">LTS. Martín González <br> <small style="color: #30D6E6;">Docente titular del curso EGEL</small></h5>
        <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para pláticas, conferencias y ponencias.
        </small>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sapius-info">Enviar mensaje</butt>
      </div>
    </div>
  </div>
</section>

<section class="modalidades">
  <div class="container ">
    <div class="modalidades__espacio">
      <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="card">
            <h2><strong>¿Quieres más información?</strong></h5>
              <p class="color-gray">Nuestros asesores están felices de ayudarte <br class="d-none d-sm-none d-md-none d-lg-block"><br class="d-none d-sm-none d-md-none d-lg-block"></p>
              <div class="boton__espacio">
                <button type="button" class="btn btn-primary boton" data-toggle="modal" data-target="#ventas">Enviar mensaje</button>
              </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="card">
            <h2><strong>Modalidad Presencial</strong></h5>
              <p class="color-gray pl-4 pr-4">Nuestro cuerpo docente esta disponible para consultas, asesorías, clases, pláticas, conferencias y ponencias.</p>
              <div class="boton__espacio">
                <a href="/cursos-presenciales" class="btn btn-primary">Más información</a>
              </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection