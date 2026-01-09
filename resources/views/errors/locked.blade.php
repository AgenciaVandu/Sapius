@extends('layouts.adminmart.default')

@section('content')
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-8 text-center">
            <div class="card shadow-lg p-5">
                <div class="card-body">
                    <div class="mb-4">
                        <i data-feather="lock" class="text-danger" style="width: 80px; height: 80px;"></i>
                    </div>
                    <h2 class="card-title text-danger font-weight-bold">Cuenta Bloqueada</h2>
                    <h5 class="text-dark mb-4">
                        Hemos detectado actividad sospechosa en tu cuenta (intentos reiterados de uso indebido).
                    </h5>
                    <p class="card-text lead mt-3 text-muted">
                        Por motivos de seguridad y cumpliendo con nuestros términos de servicio, tu acceso ha sido
                        suspendido temporalmente.
                        <br>
                        <strong>El examen en curso ha sido finalizado automáticamente.</strong>
                    </p>
                    <p class="text-muted mt-3">
                        Para recuperar el acceso, por favor contacta a soporte técnico.
                    </p>
                    <div class="mt-4">
                        <a href="https://wa.me/529993648594?text=Hola,%20mi%20cuenta%20ha%20sido%20bloqueada%20durante%20un%20examen"
                            target="_blank" class="btn btn-success btn-lg rounded-pill px-5">
                            <i class="fab fa-whatsapp mr-2"></i> Contactar Soporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prevent back navigation loop
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };

        // Poll to check if unblocked
        setInterval(() => {
            fetch(window.location.href, {
                    method: 'HEAD'
                })
                .then(response => {
                    if (response.redirected && response.url.includes('alumno')) {
                        window.location.href = "{{ route('alumno.home') }}";
                    }
                })
                .catch(() => {});
        }, 5000);
    </script>
@endsection
