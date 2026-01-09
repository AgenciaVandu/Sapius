<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('vendor/adminmart/assets/images/favicon.png') }}">
    <title>Sapius - Finalización Imprevista</title>
    <!-- Custom CSS -->
    <link href="{{ asset('vendor/adminmart/dist/css/style.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="main-wrapper">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="auth-box row justify-content-center">
                <div class="col-lg-8 col-md-10 bg-white rounded shadow-lg p-5 text-center">
                    <div class="mb-4">
                        <i data-feather="alert-triangle" class="text-warning" style="width: 60px; height: 60px;"></i>
                    </div>
                    <h2 class="card-title text-danger font-weight-bold mb-3">Finalización Imprevista</h2>
                    <h5 class="text-dark font-weight-normal mb-4">
                        Se ha detectado el uso indebido de la plataforma y violación de las restricciones previstas en
                        el contrato de servicios.
                    </h5>
                    <p class="text-muted lead mb-4">
                        Por ello, no podrá continuar con el examen y se le negará la retroalimentación correspondiente.
                        Nos reservamos el derecho de negar el acceso permanente a la plataforma.
                    </p>

                    <form method="POST" action="{{ route('examen.finalizar') }}" class="mt-4" id="form-finalizar">
                        @csrf
                        <input type="hidden" name="examen_id" value="{{ $examen_id }}">
                        <input type="hidden" name="leccion_id" value="{{ $leccion_id }}">
                        <input type="hidden" name="curso_programado_id" value="{{ $curso_programado_id }}">
                        <input type="hidden" name="inscripcion_id" value="{{ $inscripcion_id }}">

                        <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 shadow-sm hover-lift">
                            <i data-feather="x-circle" class="mr-2 feather-icon"></i> Confirmar y Finalizar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/adminmart/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/dist/js/feather.min.js') }}"></script>
    <script>
        feather.replace();
    </script>
</body>

</html>
