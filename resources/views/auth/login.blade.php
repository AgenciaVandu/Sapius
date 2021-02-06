@extends('layouts.adminmart.login')

@section('content')
    <h2 class="mt-3 text-center">{{ __('Sign In') }}</h2>
    <p class="text-center">Desde aqui puedes ingresar.</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="username" class="text-dark">{{ __('Username') }}</label>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="password" class="text-dark">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="text-dark" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
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
                    {{ __('Login') }}
                </button>
            </div>
            <div class="col-lg-12 text-center">
                <div>
                    <hr>
                </div>
                <a href="{{url('/redirect')}}" class="btn btn-block bg-facebook text-white font-16">
                    <i class="fab fa-facebook-f ml-2"></i>
                    Entrar con Facebook
                </a>
            </div>
            @if (Route::has('password.request'))
            <div class="col-lg-12 text-center mt-3">
                    <a class="text-info" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
            </div>
            @endif
            @if (Route::has('register'))
            <div class="col-lg-12 text-center mt-2">
                {{ __("Don't have an account?") }} <a href="{{ route('register') }}" class="text-danger">{{ __('Sign Up') }}</a>
            </div>
            @endif
        </div>
    </form>
@endsection
