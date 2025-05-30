@extends('layouts.landing')
@push('title')
    <title>Cursos online para aprobar el EGEL PLUS - Sapius®</title>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <!-- Glide.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.theme.min.css">
@endpush
@section('content')
    <header class="header__intro">
        <div class="container mt-5">
            <div class="row mt-3">
                <div class="col-lg-7 col-md-12 col-sm-12 m-auto txt-banner">
                    <h1 style="color: #fff;">Prepárate con Sapius <br>

                        <div id="textos" class="carousel slide carousel-fade" data-ride="carousel">
                            Cursos online para el
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-interval="2500">
                                    <span class="color-lowblue">EXANI-I</span>
                                </div>
                                <div class="carousel-item" data-interval="2500">
                                    <span class="color-lowblue">EXANI-II</span>
                                </div>
                                <div class="carousel-item" data-interval="2500">
                                    <span class="color-lowblue">EXANI-III</span>
                                </div>
                                <div class="carousel-item" data-interval="2500">
                                    <span class="color-lowblue">ENARM</span>
                                </div>
                                <div class="carousel-item" data-interval="2500">
                                    <span class="color-lowblue">EGEL PLUS</span>
                                </div>
                            </div>
                        </div>

                    </h1>
                    <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
                    <a href="{{ route('register') }}" class="btn btn-primary">Comenzar</a>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 banner">
                    <div id="carousel-imagenes" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @if ($images)
                                @foreach ($images as $image)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <img src="{{ asset('storage/' . $image->img) }}" class="img-ajustada"
                                            alt="Estudiantes EGEL" loading="lazy">
                                    </div>
                                @endforeach
                            @endif
                        </div>
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
                    <strong>¿Cuál es tu objetivo?</strong> <br> <span
                        style="font-size:18px; font-weight:300; color: gray;">Selecciona el objetivo que quieras
                        conseguir</span>
                </h1>
                <ul class="nav nav-tabs nav-justified" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-title2" id="pills-prepa-tab" data-toggle="pill" href="#prepa">
                            <span>Ingresar <br class="d-none d-sm-none d-md-none d-lg-block"> a la prepa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-title2" id="pills-universidad-tab" data-toggle="pill" href="#universidad">
                            <span>Ingresar <br class="d-none d-sm-none d-md-none d-lg-block"> a la Universidad</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-title2" id="pills-egel-tab" data-toggle="pill" href="#egel">
                            <span>Aprobar<br class="d-none d-sm-none d-md-none d-lg-block"> el EGEL Plus</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-title2" id="pills-maestria-tab" data-toggle="pill" href="#maestria">
                            <span>Ingresar<br class="d-none d-sm-none d-md-none d-lg-block">a la Maestría</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-title2" id="pills-enarm-tab" data-toggle="pill" href="#enarm">
                            <span>Aprobar<br class="d-none d-sm-none d-md-none d-lg-block"> el ENARM</span>
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
                                    <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar
                                        el examen.</p>
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
                                    <h1 class="juntos">Juntos lograremos tu<br> admisión a la <span
                                            class="color-text">Universidad</span></h1>
                                    <p class="text-sub-title1">En esta curso obtendrás todo lo que necesitas para aprobar
                                        el
                                        examen.</p>
                                </div>
                                <div class="container-button">
                                    <a href="{{ route('register') }}"
                                        class="button-title-tabs btn btn-primary">COMENZAR</a>
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
                                    <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar
                                        el examen.</p>
                                </div>
                                <div class="container-button">
                                    <a href="{{ route('register') }}"
                                        class="button-title-tabs btn btn-primary">COMENZAR</a>
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
                                    <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar
                                        el examen.</p>
                                </div>
                                <div class="container-button">
                                    <a href="{{ route('register') }}"
                                        class="button-title-tabs btn btn-primary">COMENZAR</a>
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
                                    <p class="text-sub-title1"> En esta curso obtendrás todo lo que necesitas para aprobar
                                        el examen.</p>
                                </div>
                                <div class="container-button">
                                    <a href="{{ route('register') }}"
                                        class="button-title-tabs btn btn-primary">COMENZAR</a>
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
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#ventas">SOLICITAR
                            UNA CLASE MUESTRA</a>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12 centro-card text-center">
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($prides as $pride)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <div class="card">
                                            <div class="cabecera-orgullo">
                                                <img src="{{ asset('storage/' . $pride->img) }}" class="rounded-circle" style="max-width: 15.4rem; max-height: 15.4rem;"
                                                    loading="lazy">
                                            </div>
                                            <h4 class="color-gray">{{ $pride->name }}</h4>
                                            <p class="color-gray font-weight-normal mb-0">
                                                {{ $pride->text }}
                                            </p>
                                            <p class="color-orange font-weight-normal px-5 mt-0">
                                                {{ $pride->text2 }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
                    <h5 class="color-gray pt-3">El 99.1% de nuestros <br class="d-none d-sm-none d-md-block d-lg-block">
                        estudiantes acreditan</h5>
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
        <div class="container">
            <!-- Carousel de Glide.js -->
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach ($teachers as $teacher)
                            <li class="glide__slide">
                                <div class="docentes__persona">
                                    <div class="maestro-img">
                                        <img src="{{ asset('storage/' . $teacher->img) }}" class="rounded-circle border-teachers" style="max-width: 10.4rem; max-height: 10.4rem; min-width: 10.4rem; min-height: 10.4rem; background: #ffffff;"
                                            alt="Maestro sapius" loading="lazy">
                                    </div>
                                    <h5 style="color: #fff;">{{ $teacher->name }} <br> <small
                                            style="color: #30D6E6;">{{$teacher->description}}</small></h5>
                                    <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para
                                        pláticas,
                                        conferencias y ponencias.
                                    </small>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#sapius-info">Enviar
                                        mensaje</button>
                                </div>
                            </li>
                        @endforeach
                        {{-- <li class="glide__slide">
                            <div class="docentes__persona">
                                <div class="maestro-img">
                                    <img src="{{ asset('img/m-6.png') }}" class="img-fluid pb-3" alt="Maestro sapius"
                                        loading="lazy">
                                </div>
                                <h5 style="color: #fff;">LN. Fernando Iván Pat Poot <br> <small
                                        style="color: #30D6E6;">Docente
                                        Sapius</small></h5>
                                <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para
                                    pláticas,
                                    conferencias y ponencias.
                                </small>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#sapius-info">Enviar
                                    mensaje</button>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div class="docentes__persona">
                                <div class="maestro-img">
                                    <img src="{{ asset('img/m-3.png') }}" class="img-fluid pb-3" alt="Maestro sapius"
                                        loading="lazy">
                                </div>
                                <h5 style="color: #fff;">Lic.Trab.Soc. Martín Moises González Sansores <br> <small
                                        style="color: #30D6E6;">Docente
                                        titular del
                                        curso EGEL Plus</small></h5>
                                <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para
                                    pláticas,
                                    conferencias y ponencias.
                                </small>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#sapius-info">Enviar
                                    mensaje</button>
                            </div>
                        </li>

                        <li class="glide__slide">
                            <div class="docentes__persona">
                                <div class="maestro-img">
                                    <img src="{{ asset('img/m-5.png') }}" class="img-fluid pb-3" alt="Maestro sapius"
                                        loading="lazy">
                                </div>
                                <h5 style="color: #fff;">Dra. Erika Elizabeth González Sansores <br> <small
                                        style="color: #30D6E6;">Neuróloga egresada del Centro Nacional Siglo XXI</small>
                                </h5>
                                <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para
                                    pláticas,
                                    conferencias y ponencias.
                                </small>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#sapius-info">Enviar
                                    mensaje</button>
                            </div>

                        </li>
                        <li class="glide__slide">
                            <div class="docentes__persona">
                                <div class="maestro-img">
                                    <img src="{{ asset('img/m-4.png') }}" class="img-fluid pb-3" alt="Verónica Sansores"
                                        loading="lazy">
                                </div>
                                <h5 style="color: #fff;">
                                    L.N. Elsy Verónica González Sansores <br> <small style="color: #30D6E6;">Premio
                                        Nacional Excelencia
                                        EGEL</small>
                                </h5>
                                <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para
                                    pláticas,
                                    conferencias y ponencias.
                                </small>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#sapius-info">Enviar
                                    mensaje</button>
                            </div>
                        </li>
                        <li class="glide__slide">

                            <div class="docentes__persona">
                                <div class="maestro-img">
                                    <img src="{{ asset('img/m-2.png') }}" class="img-fluid pb-3" alt="Maestro sapius"
                                        loading="lazy">
                                </div>
                                <h5 style="color: #fff;">Dr. César Abraham Estrada Aguirre<br> <small
                                        style="color: #30D6E6; ">Cirujano
                                        Plástico Estético y Reconstructivo</small></h5>
                                <small style="color: #fff;" class="pb-3">Nuestro cuerpo docente esta disponible para
                                    pláticas,
                                    conferencias y ponencias.
                                </small>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#sapius-info">Enviar
                                    mensaje</button>
                            </div>
                        </li> --}}


                    </ul>
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
                                <p class="color-gray">Nuestros asesores están felices de ayudarte <br
                                        class="d-none d-sm-none d-md-none d-lg-block"><br
                                        class="d-none d-sm-none d-md-none d-lg-block"></p>
                                <div class="boton__espacio">
                                    <button type="button" class="btn btn-primary boton" data-toggle="modal"
                                        data-target="#ventas">Enviar mensaje</button>
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="card">
                            <h2><strong>Modalidad Presencial</strong></h5>
                                <p class="color-gray pl-4 pr-4">Nuestro cuerpo docente esta disponible para consultas,
                                    asesorías, clases, pláticas, conferencias y ponencias.</p>
                                <div class="boton__espacio">
                                    <a href="/cursos-presenciales" class="btn btn-primary">Más información</a>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            new Glide('.glide', {
                perView: 4,
                gap: 10,
                autoplay: 2000,
                bound: true,
                breakpoints: {
                    1200: {
                        perView: 4,
                        gap: 10
                    },
                    992: {
                        perView: 2,
                        gap: 20
                    },
                    600: {
                        perView: 1,
                        gap: 10
                    }
                }
            }).mount();
        </script>
    @endpush
@endsection
@section('cta')
@endsection
