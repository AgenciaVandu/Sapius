@extends('layouts.landing')
@push('title')
    <title>Simuladores nutrición - Sapius®</title>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('css/exani3.css') }}">
@endpush
@section('content')
    <header class="bg-blue">
        <div class="container text-center">
            <div class="col-11 exani-titular">
                <h1 style="color: #fff;">Prepárate para
                    <span class="color-lowblue">EGEL PLUS - Nutrición con los Simuladores </span> Sapius. <br
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
                <div class="col-md-7 col-lg-7 col-sm-12 m-auto pb-4 exani__faq">
                    <h3 class="color-gray">
                        <strong>Simuladores Globales - EGEL Plus Nutrición</strong>
                    </h3>
                    <p class="color-gray">En Sapius, hemos desarrollado simuladores globales 100% actualizados con la
                        bibliografía oficial del EGEL Plus en Nutrición, diseñados para optimizar tu
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
                <div class="col-md-5 col-lg-5 col-sm-12 text-center">
                    <div>
                        <img src="{{ asset('img/webp/egel.webp') }}" class="img-fluid" alt="Material EGEL PLUS">
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
    @include('components.info')
@endsection
