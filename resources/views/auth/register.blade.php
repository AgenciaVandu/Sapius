@extends('layouts.adminmart.login')

@section('content')
    <div class="auth-wrapper d-flex align-items-center justify-content-center" style="min-height: 100vh; background: linear-gradient(135deg, #101a26 20%, #101a26 100%);">
        <div class="auth-box bg-white rounded-3 shadow-lg overflow-hidden" style="max-width: 400px; width: 100%;">
            <div class="p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('vendor/adminmart/assets/images/big/icon.png') }}" alt="wrapkit" style="width: 60px;">
                </div>
                <h2 class="text-center mb-2" style="color: #101a26; font-weight: 700;">{{ __('Sign Up') }}</h2>
                <p class="text-center mb-4" style="color: #ed6a5a;">Desde aquí puedes registrarte.</p>
                <form method="POST" id="registro" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror rounded-pill" name="nombre"
                            value="{{ old('nombre') }}" required autocomplete="nombre" autofocus placeholder="{{ __('Name') }}">
                        @error('nombre')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror rounded-pill" name="apellido"
                            value="{{ old('apellido') }}" required autocomplete="apellido" placeholder="{{ __('Surname') }}">
                        @error('apellido')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror rounded-pill" name="email"
                            value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror rounded-pill" name="username"
                            value="{{ old('username') }}" required autocomplete="username" placeholder="{{ __('Username') }}">
                        @error('username')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror rounded-pill" name="password"
                            required autocomplete="new-password" placeholder="{{ __('Password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input id="password-confirm" type="password" class="form-control rounded-pill" name="password_confirmation"
                            required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2" style="font-size: 0.9em;">
                            Acepto los términos y condiciones
                        </label>
                    </div>
                    <div class="mb-2">
                        <a href="terms/conditions" target="_blank" style="font-size: 0.9em;">Consulta los términos y condiciones</a>
                    </div>
                    <div class="mb-3">
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <div class="g-recaptcha pt-2" id="g-recaptcha-contacto"
                            data-sitekey="{{ config('elearning.captcha_data_sitekey') }}"></div>
                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 mb-3" style="font-weight: 600;">
                        {{ __('Register') }}
                    </button>
{{--                     <div class="text-center mb-3">
                        <hr>
                    </div>
                    <a href="{{ url('/redirect') }}" class="btn w-100 mb-2" style="background: #3b5998; color: #fff;">
                        <i class="fab fa-facebook-f mr-2"></i>
                        Registro con Facebook
                    </a> --}}
                    <div class="text-center mt-3" style="font-size: 0.95em;">
                        {{ __('Already have an account?') }}
                        <a href="{{ route('login') }}" class="text-danger">{{ __('Sign In') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        const driver = window.driver.js.driver;
        const driverObj = driver({
            showProgress: true,
            animate: true,
            doneBtnText: 'Entendido',
            nextBtnText: 'Siguiente',
            prevBtnText: 'Anterior',
            steps: [
                { 
                    element: '.auth-box', 
                    popover: { 
                        title: 'Registro de Usuario', 
                        description: 'Completa este formulario para crear tu cuenta.',
                        side: "bottom", 
                        align: 'center' 
                    } 
                },
                { 
                    element: '#nombre', 
                    popover: { 
                        title: 'Datos Personales', 
                        description: 'Ingresa tu nombre y apellido real.',
                        side: "right", 
                        align: 'center' 
                    } 
                },
                { 
                    element: '#email', 
                    popover: { 
                        title: 'Correo Electrónico', 
                        description: 'Usa un correo válido donde podamos contactarte.',
                        side: "right", 
                        align: 'center' 
                    } 
                },
                { 
                    element: '#username', 
                    popover: { 
                        title: 'Nombre de Usuario', 
                        description: 'Elige un nombre único para identificarte en la plataforma.',
                        side: "right", 
                        align: 'center' 
                    } 
                },
                { 
                    element: '#password', 
                    popover: { 
                        title: 'Seguridad', 
                        description: 'Crea una contraseña segura y confírmala.',
                        side: "right", 
                        align: 'center' 
                    } 
                },
                { 
                    element: '.form-check', 
                    popover: { 
                        title: 'Términos y Condiciones', 
                        description: 'Debes aceptar los términos de uso para poder registrarte.',
                        side: "top", 
                        align: 'center' 
                    } 
                }
            ]
        });

        $(window).on('load', function() {
            if (!localStorage.getItem('register_tutorial_seen')) {
                setTimeout(() => {
                    driverObj.drive();
                    localStorage.setItem('register_tutorial_seen', 'true');
                }, 1000); // Wait for preloader fadeOut
            }
        });
    </script>
@endsection
