@extends('layouts.adminmart.default')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Disclaimer arriba --}}
            <div class="alert alert-info text-center mb-4">
                <strong>¡Queremos saber tu opinión!</strong><br>
                Tu retroalimentación nos ayuda a mejorar la plataforma <span class="font-weight-bold">Sapius</span>.
            </div>

            {{-- Card con formulario --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Deja tu Reseña</h5>
                </div>
                <div class="card-body">
                    @if ($reviews->count() > 0)
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <i class="fa fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                                <h4 class="mb-3">¡Gracias por tu opinión!</h4>
                                <p class="text-muted">
                                    Ya hemos registrado tu reseña sobre <strong>Sapius</strong>.
                                </p>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('alumno.opinion.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="name" value="{{ Auth::user()->nombre }}">

                            {{-- Calificación con estrellas --}}
                            <div class="form-group">
                                <label for="rating" class="font-weight-bold">Calificación</label>
                                <div class="d-flex mb-2" id="star-rating">
                                    <span class="star h2 text-secondary mr-2" data-value="1">&#9733;</span>
                                    <span class="star h2 text-secondary mr-2" data-value="2">&#9733;</span>
                                    <span class="star h2 text-secondary mr-2" data-value="3">&#9733;</span>
                                    <span class="star h2 text-secondary mr-2" data-value="4">&#9733;</span>
                                    <span class="star h2 text-secondary" data-value="5">&#9733;</span>
                                </div>
                                <input type="number" name="rating" id="rating" class="form-control" min="1"
                                    max="5" required hidden>
                            </div>

                            {{-- Comentario --}}
                            <div class="form-group">
                                <label for="comment" class="font-weight-bold">Comentario</label>
                                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Escribe aquí tu experiencia..."
                                    required></textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-paper-plane"></i> Enviar Reseña
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var stars = document.querySelectorAll('#star-rating .star');
        var ratingInput = document.getElementById('rating');

        stars.forEach(function(star) {
            star.style.cursor = "pointer";

            star.addEventListener('click', function() {
                var value = this.getAttribute('data-value');
                ratingInput.value = value;

                // resetear todas
                stars.forEach(function(s) {
                    s.classList.remove('text-warning');
                    s.classList.add('text-secondary');
                });

                // marcar hasta la seleccionada
                for (var i = 0; i < value; i++) {
                    stars[i].classList.remove('text-secondary');
                    stars[i].classList.add('text-warning');
                }
            });
        });
    </script>
@endsection
