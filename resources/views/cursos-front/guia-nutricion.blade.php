@extends('layouts.landing')
@push('meta')
    <title>{{ $meta_title ?? 'Guía EGEL Plus Nutrición - Sapius®' }}</title>
    <meta name="description"
        content="{{ $meta_description ?? 'Prepárate para el EGEL Plus – Nutrición con la Guía Oficial Sapius..' }}">
    <meta name="keywords"
        content="{{ $meta_keywords ?? 'Cursos Egel, Cursos Enarm, Cursos Exani I, Cursos Exani II, Cursos Exani III, cursos para aprobar el EGEL, cómo aprobar el Exani' }}">
    <meta name="robots" content="{{ $meta_robots ?? 'index, follow' }}">
    <link rel="canonical" href="{{ $meta_canonical ?? url()->current() }}">
    <meta name="image" content="{{ $meta_image ?? asset('vendor/adminmart/assets/images/big/cursos.png') }}">
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
                <h1 style="color: #fff;">Prepárate para el
                    <span class="color-lowblue">EGEL Plus – Nutrición
                        con la Guía Oficial</span> Sapius. <br class="d-none d-sm-none d-md-block d-lg-block">La guía más
                    actualizada a un solo clic</span>
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
                        <strong>Guía Oficial Sapius – EGEL Plus Nutrición</strong>
                    </h3>
                    <p class="color-gray">La Guía Oficial Sapius está 100% actualizada según la bibliografía del EGEL Plus
                        Nutrición, ofreciendo un enfoque práctico y dinámico para optimizar tu aprendizaje.</p>
                    <p>
                        ¿Qué encontrarás en nuestra guía?
                    </p>
                    <ul>
                        <li style="color: black;">
                            ✔ Contenido actualizado y estructurado, alineado con los temas del EGEL Plus.
                        </li>
                        <li style="color: black;">
                            ✔ Preguntas de práctica al final de algunos temas clave para reforzar tu comprensión.
                        </li>
                        <li style="color: black;">
                            ✔ Ejercicios de repaso al cierre de cada módulo, permitiéndote consolidar el conocimiento
                            adquirido.
                        </li>
                        <li style="color: black;">
                            ✔ Exámenes de preguntas abiertas, diseñados para evaluar tu capacidad de análisis y
                            aplicación de conceptos clave.
                        </li>
                    </ul>
                    <p>
                        Con Sapius, tendrás las herramientas necesarias para afrontar el EGEL Plus con seguridad y
                        alcanzar el éxito académico.
                    </p>
                    <a href="" class="btn btn-primary">COMENZAR</a>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 text-center">
                    <div class="glide">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @if ($guias->count() > 0)
                                    @foreach ($guias as $guia)
                                        <li class="glide__slide">
                                            <div class="card text-center mx-auto text-secondary"
                                                style="width: 100%; border: 0px solid rgb(252, 251, 251);">
                                                <img src="{{ route('public.cursos.image', ['file' => $guia->Curso->imagen]) }}"
                                                    class="card-img-top" alt="{{ $guia->titulo }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $guia->Curso->titulo }}</h5>
                                                    <p class="card-text font-blod">{{ $guia->identificador }}</p>
                                                    <h2 class="card-text">${{ number_format($guia->precio, 2) }}</h2>
                                                    <a href="{{ route('inscripcion.form', $guia->id) }}"
                                                        class="btn btn-primary">Obtener la guía</a>
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
                            <h4 class="color-gray">Estudia cuando lo desees</h2>
                                <p class="color-gray">La guía oficial Sapius, estará disponible las 24
                                    horas del día, los 7 días de la semana, en
                                    nuestra plataforma para que puedas acceder
                                    a ella en cualquier momento.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('img/v1/icon/exni/icono-e-2.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h4 class="color-gray">Exámenes de repaso por módulo</h2>
                                <p class="color-gray">Al finalizar cada módulo, tendrás acceso a un
                                    examen compuesto por preguntas abiertas y/o
                                    ejercicios para reforzar tus conocimientos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('img/v1/icon/exni/icono-e-3.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h4 class="color-gray">Preguntas de repaso</h2>
                                <p class="color-gray">Al final de ciertos temas contarás con
                                    preguntas de repaso para reforzar lo
                                    aprendido.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('img/v1/icon/exni/icono-e-4.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-9">
                            <h4 class="color-gray">Acceso total</h2>
                                <p class="color-gray">Disfrutarás de acceso completo a la guía oficial
                                    de Sapius, siempre actualizada, durante los 3
                                    meses previos a tu examen.</p>
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
                    <h1 class="cta-1" style="color: #fff;">ACREDITA EL EGEL PLUS CON EXCELENCIA </h1>
                    <P style="color: #fff;">El 40% de nuestros estudiantes obtiene el premio naciona a la excelencia EGEL
                    </P>
                    <a href="" class="btn btn-primary">SOLICITA UNA CLASE MUESTRA</a>
                </div>
            </div>
        </div>
    </section>
    @include('components.preparacion')
    @include('components.info', [
        'content' => 'guia-nutricion',
        'manageable' => $manageable_guias_nutricion,
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
