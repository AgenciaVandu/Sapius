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

<style>
    .simulador-descripcion li {
        color: black !important;
    }

    .simulador-descripcion {
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.5s ease-in-out;
    }

    .simulador-descripcion.active {
        opacity: 1;
        transform: translateX(0);
    }

    .simulador-descripcion.d-none {
        display: none;
    }

    .descripcion-estilizada ul {
        list-style: none;
        padding-left: 1.2rem;
    }

    .descripcion-estilizada li {
        position: relative;
        padding-left: 1.2rem;
        margin-bottom: 0.5rem;
        color: black;
    }

    .descripcion-estilizada li::before {
        content: "➤";
        position: relative;
        left: 0;
        color: orange;
        /* Puedes cambiarlo por el color que quieras */
        font-size: 0.9rem;
        line-height: 1;
    }
</style>
@php
    switch ($content) {
        case 'simulador-nutricion':
            break;
        case 'simulador-medicina':
            $items = collect([
                ['text' => 'Simulador global “1”', 'data-target' => '#guia'],
                ['text' => 'Simulador global “2”', 'data-target' => '#plataforma'],
                ['text' => 'Simulador global “2”', 'data-target' => '#simuladores'],
                [
                    'text' => 'Simulador global “Comprensión lectora y redacción indirecta”',
                    'data-target' => '#simuladores',
                ],
                ['text' => 'Plataforma 24/7', 'data-target' => '#plataforma'],
                ['text' => 'Contenido online', 'data-target' => '#simuladores'],
                ['text' => 'Descuentos especiales al adquirir el curso y/o simuladores', 'data-target' => '#guia'],
            ]);
            break;
        case 'guia-nutricion':
            $items = collect([
                ['text' => 'Guía Actualizada Sapius', 'data-target' => '#guia'],
                ['text' => 'Plataforma 24/7', 'data-target' => '#plataforma'],
                ['text' => 'Contenido online', 'data-target' => '#simuladores'],
                ['text' => 'Preguntas de repaso en temas clave', 'data-target' => '#simuladores'],
                ['text' => 'Exámenes por módulo', 'data-target' => '#plataforma'],
                ['text' => 'Ejercicios de repaso prácticos', 'data-target' => '#simuladores'],
                ['text' => 'Descuentos especiales al adquirir el curso y/o simuladores', 'data-target' => '#guia'],
            ]);
            break;
        case 'guia-medicina':
            $items = collect([
                ['text' => 'Guía Actualizada Sapius', 'data-target' => '#guia'],
                ['text' => 'Plataforma 24/7', 'data-target' => '#plataforma'],
                ['text' => 'Contenido online', 'data-target' => '#simuladores'],
                ['text' => 'Preguntas de repaso en temas clave', 'data-target' => '#simuladores'],
                ['text' => 'Exámenes por módulo', 'data-target' => '#plataforma'],
                ['text' => 'Ejercicios de repaso prácticos', 'data-target' => '#simuladores'],
                ['text' => 'Descuentos especiales al adquirir el curso y/o simuladores', 'data-target' => '#guia'],
            ]);
            break;
        case 'info':
            $items = collect([
                ['text' => 'Examen diagnóstico', 'data-target' => '#popup'],
                ['text' => 'Paquete escolar', 'data-target' => '#paquete'],
                ['text' => 'Guía actualizada', 'data-target' => '#guia'],
                ['text' => 'Plataforma 24/7', 'data-target' => '#plataforma'],
                ['text' => 'Portabilidad', 'data-target' => '#portabilidad'],
                ['text' => 'Asesoría en vivo*', 'data-target' => '#asesoria'],
                ['text' => 'Simuladores por tema, <br> módulos y globales', 'data-target' => '#simuladores'],
                ['text' => 'Feedback en vivo*', 'data-target' => '#feedback'],
            ]);
            break;
        default:
            break;
    }
@endphp
@if ($content == 'info')
    <section class="cta">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-12 mb-5 cta__flex">
                    <div class="cta__incluye">
                        <h5 class="text-center">Tu inscripción incluye</h5>
                        @foreach ($items as $item)
                            <div class="cta__incluye-contenido mb-2">
                                <span class="p-2">
                                    <a href="#" data-toggle="modal"
                                        data-target="#{{ Str::slug($item['data-target']) }}">
                                        {!! $item['text'] !!}
                                    </a>
                                </span>
                                <img src="{{ asset('img/v1/icon/check.svg') }}" width="25" alt="">
                            </div>
                        @endforeach
                    </div>
                    @if ($section == 'egel-plus')
                        <div class="text-center pt-2">
                            <small style="color: gray;">Duración 8 y 10 semanas / Aplican restricciones <br>
                                Sujeto a
                                disponibilidad</small>
                        </div>
                    @else
                        <div class="text-center pt-2">
                            <small style="color: gray;">Duración 4, 6, 8 y 12 semanas / Aplican restricciones <br>
                                Sujeto a
                                disponibilidad</small>
                        </div>
                    @endif
                </div>
                <div class="col-lg-7 col-sm-12">
                    <div class="orgullo-txt">
                        <h4 class="lead" style="color: gray;">Forma parte de nuestra comunidad</h4>
                        <h2 class="color-gray"><strong>Opiniones de <br>
                                nuestros alumnos</strong></h2>
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($reviews as $review)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <p class="color-gray reference">
                                            <strong>{{ $review->name }}</strong> <br>
                                            <span>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star"
                                                        style="color: {{ $i <= $review->rating ? '#FFD700' : '#ccc' }};"></i>
                                                @endfor
                                            </span>
                                            <br>
                                            <span>
                                                {{ $review->comment }}
                                            </span>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <a href="" data-toggle="modal" data-target="#ventas" class="btn btn-primary">Más
                            información</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <section class="cta">
        <div class="container">
            <div class="row">
                <!-- Lado izquierdo -->
                <div class="col-lg-5 col-sm-12 mb-5 cta__flex">
                    <div class="cta__incluye">
                        <h5 class="text-center">Tu inscripción incluye</h5>
                        @foreach ($manageable as $index => $item)
                            <div class="cta__incluye-contenido mb-2" id="link-container-{{ $index }}">
                                <span class="p-2">
                                    <a href="#" class="simulador-link" data-index="{{ $index }}">
                                        {{ $item->titulo }}
                                    </a>
                                </span>
                                <img id="check-icon-{{ $index }}" src="{{ asset('img/v1/icon/check.svg') }}"
                                    width="25" alt="">
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center pt-2">
                        <small style="color: gray;">Duración 4, 6, 8 y 12 semanas / Aplican restricciones <br> Sujeto a
                            disponibilidad</small>
                    </div>
                </div>

                <!-- Lado derecho -->
                <div class="col-lg-7 col-sm-12">
                    <div id="simulador-content" class="orgullo-txt">
                        @foreach ($manageable as $index => $item)
                            <div class="simulador-descripcion d-none" id="descripcion-{{ $index }}">
                                {{-- Imagen arriba del título --}}

                                <h2 class="color-gray"><strong>{{ $item->titulo }}</strong></h2>
                                <p class="color-gray reference">
                                    {!! $item->descripcion !!}
                                </p>
                                {{-- @if (!empty($item->image))
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('storage/' . $item->image) }}"
                                            alt="Imagen de {{ $item->titulo }}"
                                            style="max-width: 150px; height: auto;">
                                    </div>
                                @endif --}}
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const descripciones = document.querySelectorAll('.simulador-descripcion');
                const checkIcons = document.querySelectorAll('[id^="check-icon-"]');
                const simuladorLinks = document.querySelectorAll('.simulador-link');
                const total = descripciones.length;
                let currentIndex = 0;
                let intervalTime = 5000; // 10 segundos
                let paused = false;

                function showDescripcion(index) {
                    // Ocultar todas las descripciones
                    descripciones.forEach((desc) => {
                        desc.classList.add('d-none');
                        desc.classList.remove('active');
                    });

                    const currentDesc = document.getElementById(`descripcion-${index}`);
                    if (currentDesc) {
                        currentDesc.classList.remove('d-none');

                        // Reiniciar animación
                        void currentDesc.offsetWidth;
                        currentDesc.classList.add('active');
                    }

                    // Resetear íconos de check
                    checkIcons.forEach(icon => icon.style.filter = 'none');

                    // Resaltar ícono activo
                    const iconActivo = document.getElementById(`check-icon-${index}`);
                    if (iconActivo) {
                        iconActivo.style.filter =
                            'invert(39%) sepia(97%) saturate(738%) hue-rotate(2deg) brightness(101%) contrast(102%)';
                    }

                    currentIndex = index;
                }

                // Mostrar primero al cargar
                showDescripcion(0);

                // Activar clic manual
                simuladorLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const index = parseInt(this.getAttribute('data-index'));
                        showDescripcion(index);
                    });

                    // Pausar en hover
                    link.addEventListener('mouseenter', () => paused = true);
                    link.addEventListener('mouseleave', () => paused = false);
                });

                // Pausar también cuando el mouse está sobre el contenido
                descripciones.forEach(desc => {
                    desc.addEventListener('mouseenter', () => paused = true);
                    desc.addEventListener('mouseleave', () => paused = false);
                });

                // Cambio automático solo si no está en pausa
                setInterval(() => {
                    if (!paused) {
                        let nextIndex = (currentIndex + 1) % total;
                        showDescripcion(nextIndex);
                    }
                }, intervalTime);
            });
        </script>



    </section>
@endif
