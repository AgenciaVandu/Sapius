@extends('layouts.landing')
@push('meta')
    <title>{{ $meta_title ?? 'Simuladores EGEL Plus Medicina - Sapius®' }}</title>
    <meta name="description"
        content="{{ $meta_description ?? 'Prepárate para el EGEL Plus – Medicina con los Simuladores Sapius los más actualizados en un solo clic.' }}">
    <meta name="keywords"
        content="{{ $meta_keywords ?? 'Cursos Egel Plus, Cursos Enarm, Cursos Exani I, Cursos Exani II, Cursos Exani III, cursos para aprobar el EGEL, cómo aprobar el Exani' }}">
    <meta name="robots" content="{{ $meta_robots ?? 'index, follow' }}">
    <link rel="canonical" href="{{ $meta_canonical ?? url()->current() }}">
    <meta name="image" content="{{ $meta_image ?? asset('img/simuladores-medicina-SEO.jpg') }}">
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('css/exani3.css') }}">
    <!-- Glide.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.theme.min.css">
@endpush
@section('content')
    <header class="bg-blue">
        <div class="container text-center">
            <div class="col-11 exani-titular">
                <h1 style="color: #fff;">Prepárate para
                    <span class="color-lowblue">EGEL PLUS - Medicina con los Simuladores </span> Sapius. <br
                        class="d-none d-sm-none d-md-block d-lg-block"> <span>Los <span style="color: #ED6A5A;"> simuladores
                            más actualizados</span> a un solo clic</span>
                </h1>
                <a href="" class="btn btn-primary">Comenzar</a>
            </div>
        </div>
    </header>
    <section class="exani">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-12 m-auto pb-4 exani__faq">
                    <h3 class="color-gray">
                        <strong>Simuladores Globales - EGEL Plus Medicina</strong>
                    </h3>
                    <p class="color-gray">En Sapius, hemos desarrollado simuladores globales 100% actualizados con la
                        bibliografía oficial del EGEL Plus en Medicina, diseñados para optimizar tu
                        aprendizaje de manera práctica y efectiva.</p>
                    <p>
                        ¿Qué te ofrecemos?
                    </p>
                    <ul>
                        <li style="color: black;">
                            ✔ Exámenes con temporizador, simulando las condiciones reales del EGEL Plus.
                        </li>
                        <li style="color: black;">
                            ✔ Retroalimentación detallada, con explicaciones claras en cada reactivo
                            incorrecto para fortalecer tu comprensión.
                        </li>
                        <li style="color: black;">
                            ✔ Enfoque práctico y dinámico, que facilita el aprendizaje y la retención del
                            conocimiento.
                        </li>
                        <li style="color: black;">
                            ✔ Preparación con confianza, dominando los temas clave para afrontar el
                            examen con seguridad.
                        </li>
                    </ul>
                    <p>
                        Con Sapius, tendrás las herramientas necesarias para alcanzar el éxito académico.
                    </p>
                    <a href="" class="btn btn-primary">COMENZAR</a>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 text-center">
                    <div class="glide">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @if ($simuladores->count() > 0)
                                    @foreach ($simuladores as $simulador)
                                        <li class="glide__slide">
                                            <div class="card text-center mx-auto text-secondary"
                                                style="width: 100%; border: 0px solid rgb(252, 251, 251);">
                                                <img src="{{ route('public.cursos.image', ['file' => $simulador->Curso->imagen]) }}"
                                                    class="card-img-top" alt="{{ $simulador->titulo }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $simulador->Curso->titulo }}</h5>
                                                    <p class="card-text font-blod">{{ $simulador->identificador }}</p>
                                                    <h2 class="card-text">${{ number_format($simulador->precio, 2) }}</h2>
                                                    <a href="{{ route('inscripcion.form', $simulador->id) }}"
                                                        class="btn btn-primary">Obtener el simulador</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="glide__slide">
                                        <div class="card text-center mx-auto text-secondary"
                                            style="width: 100%; border: 0px solid rgb(252, 251, 251);">
                                            <img src="{{ asset('img/webp/egel.webp') }}" class="card-img-top">
                                            {{-- <div class="card-body">
                                                <h5 class="card-title">Guia Oficial Medicina</h5>
                                                <p class="card-text font-blod">Sapius</p>
                                                <h2 class="card-text">La guía más
                                                    actualizada a un solo clic</h2>
                                                <a href="{{ route('register') }}"
                                                    class="btn btn-primary">Registrarse</a>
                                            </div> --}}
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
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
                            <img src="{{ asset('img/v1/icon/exni/icono-e-1.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h4 class="color-gray">Practica a tu ritmo</h2>
                                <p class="color-gray">Los simuladores globales de Sapius los
                                    puedes presentar cuando lo desees, las 24
                                    horas del día los 7 días de la semana (dentro
                                    del período de vigencia)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('img/v1/icon/exni/icono-e-2.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h4 class="color-gray">Retroalimentación detallada</h2>
                                <p class="color-gray">Al finalizar el examen, recibirás una
                                    retroalimentación exhaustiva de cada
                                    pregunta errónea, con el objetivo de
                                    garantizar un aprendizaje significativo</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('img/v1/icon/exni/icono-e-3.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h4 class="color-gray">Exámenes simuladores por módulo<br>
                                CENEVAL</h2>
                                <p class="color-gray">Cada módulo cuenta con simulador global,
                                    incluyendo el apartado de comprensión
                                    lectora y redacción indirecta.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('img/v1/icon/exni/icono-e-4.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h4 class="color-gray">Acceso total – enfoque 100% EGEL</h2>
                                <p class="color-gray">Tendrás acceso a los simuladores globales
                                    actualizados, con 2 intentos por simulador y
                                    retroalimentación detallada. Además, cada
                                    simulador cuenta con un temporizador para
                                    mejorar tu gestión del tiempo.</p>
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
                    <h1 class="cta-1" style="color: #fff;">Más de 10 años de excelencia nos respaldan</h1>
                    <a href="" class="btn btn-primary">SOLICITA UNA CLASE MUESTRA</a>
                </div>
            </div>
        </div>
    </section>
    @include('components.preparacion')
    @include('components.info', [
        'content' => 'simulador-medicina',
        'manageable' => $manageable_simuladores_medicina,
    ])

    @push('js')
        <script>
            new Glide('.glide', {
                perView: 1,
                gap: 10,
                autoplay: 5000,
                bound: true,
                breakpoints: {
                    1200: {
                        perView: 1,
                        gap: 10
                    },
                    992: {
                        perView: 1,
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
