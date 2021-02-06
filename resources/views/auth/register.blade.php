@extends('layouts.adminmart.login')

@section('content')
    <h2 class="mt-3 text-center">{{ __('Sign Up') }}</h2>
    <form method="POST" id="registro" action="{{ route('register') }}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus placeholder="{{ __('Name') }}">
                    @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" name="apellido" value="{{ old('apellido') }}" required autocomplete="apellido" autofocus placeholder="{{ __('Surname') }}">

                    @error('apellido')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="{{ __('Username') }}">

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                    <label class="form-check-label" for="invalidCheck2" style="font-size: 0.9em;">
                      Acepto los términos y condiciones
                    </label>
                  </div>
            </div>
            <div class="col-lg-12">
                <a href="terms/conditions" target="_blank">Consulta los terminos y condiciones</a>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    <div class="g-recaptcha pt-2"  id="g-recaptcha-contacto" data-sitekey="{{ config('elearning.captcha_data_sitekey') }}"></div>
                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                </div>
            </div>
            <div class="col-lg-12 text-center">
                <button type="submit" class="btn btn-block btn-dark">
                    {{ __('Register') }}
                </button>
            </div>
            <div class="col-lg-12 text-center">
                <div>
                    <hr>
                </div>
                <a href="{{url('/redirect')}}" class="btn btn-block bg-facebook text-white font-16">
                    <i class="fab fa-facebook-f ml-2"></i>
                    Registro con Facebook
                </a>
            </div>
            <div class="col-lg-12 text-center mt-3">
                {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="text-danger">{{ __('Sign In') }}</a>
            </div>
        </div>
    </form>
@endsection
