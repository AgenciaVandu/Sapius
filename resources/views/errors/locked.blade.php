<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('vendor/adminmart/assets/images/favicon.png') }}">
    <title>{{ config('app.name', 'Laravel') }} - Cuenta Bloqueada</title>
    <!-- Custom CSS -->
    <link href="{{ asset('vendor/adminmart/dist/css/style.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="bg-white">
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background: #f4f6f9; min-height: 100vh;">
            <div class="auth-box row justify-content-center">
                <div class="col-lg-8 col-md-10 bg-white rounded shadow-lg p-5 text-center">
                    <div class="mb-4">
                        <i data-feather="lock" class="text-danger" style="width: 80px; height: 80px;"></i>
                    </div>
                    <h2 class="font-weight-bold text-danger mb-3">Cuenta Bloqueada</h2>
                    <h5 class="text-dark mb-4">
                        Hemos detectado actividad sospechosa en tu cuenta (intentos reiterados de uso indebido).
                    </h5>
                    <p class="text-muted mb-4 lead">
                        Por motivos de seguridad y cumpliendo con nuestros términos de servicio, tu acceso ha sido
                        suspendido temporalmente.
                    </p>

                    <div class="alert alert-light border-danger text-danger mb-4 mx-auto" style="max-width: 500px;">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Importante: El examen en curso ha sido finalizado automáticamente.
                    </div>

                    <p class="text-muted mb-4">
                        Para recuperar el acceso, es necesario que contactes a soporte técnico.
                    </p>

                    <div class="mt-4">
                        <a href="https://wa.me/529993648594?text=Hola,%20mi%20cuenta%20ha%20sido%20bloqueada%20durante%20un%20examen"
                            target="_blank" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm hover-lift">
                            <i class="fab fa-whatsapp mr-2"></i> Contactar Soporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calls to action / Polling scripts -->
    <script src="{{ asset('vendor/adminmart/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/dist/js/feather.min.js') }}"></script>
    <script>
        feather.replace();
        $(".preloader").fadeOut();

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
                    } else if (response.ok) {
                        // Double check by reloading if status is 200 (might still be locked page, but safe to reload)
                        // Actually, we want to know if we are redirect to home.
                        // Simple reload is effective.
                    }
                })
                .catch(() => {});
            // Reload every 10 seconds to check status
            // window.location.reload(); 
        }, 5000);
    </script>
</body>

</html>
