@extends('layouts.adminmart.default')

@section('content')
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-6 text-center">
            <div class="card shadow-lg p-5">
                <div class="card-body">
                    <i class="fas fa-lock text-danger display-1 mb-4"></i>
                    <h2 class="card-title text-danger font-weight-bold">Cuenta Bloqueada</h2>
                    <p class="card-text lead mt-3">
                        Hemos detectado actividad sospechosa en tu cuenta (intentos reiterados de captura de contenido).
                        Por seguridad, tu acceso ha sido suspendido temporalmente.
                    </p>
                    <p class="text-muted">
                        Para recuperar el acceso, por favor contacta a soporte técnico.
                    </p>
                    <div class="mt-4">
                        <a href="https://wa.me/529993648594?text=Ayuda,%20mi%20cuenta%20ha%20sido%20bloqueada"
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
    </script>
@endsection
