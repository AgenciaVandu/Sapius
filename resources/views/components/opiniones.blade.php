<div class="orgullo-txt text-center mt-5">
    <h4 class="lead text-center mt-4" style="color: gray;">Forma parte de nuestra comunidad</h4>
    <h2 class="color-gray text-center"><strong>Opiniones de nuestros alumnos</strong></h2>
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($reviews as $review)
                <div class="carousel-item @if ($loop->first) active @endif">
                    <p class="color-gray px-4">
                    <div class="maestro-img mx-auto mb-3">
                        <img src="{{ asset(route('public.alumno.image', $review->user->foto)) }}"
                            class="rounded-circle"
                            style="max-width: 10.4rem; max-height: 10.4rem; min-width: 10.4rem; min-height: 10.4rem; background: #ffffff;">
                    </div>
                    <strong>{{ $review->user->nombre_completo }} <br></strong>
                    <span>
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#FFD700' : '#ccc' }};"></i>
                        @endfor
                    </span>
                    <br>
                    <p class="px-4">
                        {{ $review->comment }}
                    </p>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>
