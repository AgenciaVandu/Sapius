@extends('layouts.adminmart.login')

@section('content')
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
        style="background: linear-gradient(135deg, #101a26 60%, #ed6a5a 100%); min-height: 100vh;">
        <div class="auth-box row shadow-lg rounded" style="overflow: hidden; background: #fff;">
            <div class="col-lg-7 col-md-5 d-none d-md-block p-0"
                style="background: linear-gradient(135deg, rgba(237,106,90,0.65) 0%, rgba(16,26,38,0.85) 100%), url({{ asset('vendor/adminmart/assets/images/big/login.png') }}) center center/cover no-repeat;">
            </div>
            <div class="col-lg-5 col-md-7 bg-white p-4" style="border-left: 5px solid #ed6a5a;">
                <div class="text-center mb-4">
                    <img src="{{ asset('vendor/adminmart/assets/images/big/icon.png') }}" alt="wrapkit" style="width: 60px;">
                </div>
                <h2 class="mt-2 text-center" style="color: #101a26;">{{ __('Sign In') }}</h2>
                <p class="text-center" style="color: #ed6a5a;">Desde aquí puedes ingresar.</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="username" class="text-dark" style="color: #101a26 !important;">{{ __('Username') }}</label>
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus
                                    style="border: 1.5px solid #101a26;">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="password" class="text-dark" style="color: #101a26 !important;">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password"
                                    style="border: 1.5px solid #101a26;">
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
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember" style="color: #101a26;">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <div class="g-recaptcha pt-2" id="g-recaptcha-contacto"
                                    data-sitekey="{{ config('elearning.captcha_data_sitekey') }}"></div>
                                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-block"
                                style="background: #101a26; color: #fff; border-radius: 25px; font-weight: bold; border: none;">
                                {{ __('Login') }}
                            </button>
                        </div>
                       {{--  <div class="col-lg-12 text-center mt-3">
                            <div>
                                <hr style="border-top: 1.5px solid #ed6a5a;">
                            </div>
                            <a href="{{ url('/redirect') }}" class="btn btn-block"
                                style="background: #ed6a5a; color: #fff; border-radius: 25px; font-weight: bold;">
                                <i class="fab fa-facebook-f ml-2"></i>
                                Entrar con Facebook
                            </a>
                        </div> --}}
                        @if (Route::has('password.request'))
                            <div class="col-lg-12 text-center mt-3">
                                <a class="text-info" href="{{ route('password.request') }}"
                                    style="color: #ed6a5a !important;">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        @endif
                        @if (Route::has('register'))
                            <div class="col-lg-12 text-center mt-2">
                                <span style="color: #101a26;">{{ __("Don't have an account?") }}</span>
                                <a href="{{ route('register') }}" class="text-danger" style="color: #ed6a5a !important; font-weight: bold;">
                                    {{ __('Sign Up') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
