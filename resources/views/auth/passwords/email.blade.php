@extends('layouts.adminmart.login')

@section('content')

    <h2 class="mt-3 text-center">{{ __('Reset Password') }}</h2>
    <p class="text-center">{{ __('Send Password Reset Link') }}</p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email') }}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-block btn-dark">
                        {{ __('Enviar Liga') }}
                    </button>
            </div>
            <div class="col-lg-12 text-center mt-3">
                {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="text-danger">{{ __('Sign In') }}</a>
            </div>
        </div>
    </form>
@endsection
