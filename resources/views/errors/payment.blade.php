@extends('layouts.adminmart.error')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center padding-2">
                <div class="contaner-title-tabs-black">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <strong>Error:</strong> {{ session('error') }} <br>
                            <strong>Descripción:</strong> {{ session('description') }} <br>
                            <strong>Código:</strong> {{ session('code') }}
                        </div>
                    @endif
                </div>
                <div class="container-button">
                    <a class="btn btn-info btn-lg" href="{{ route('landing.home') }}">
                        <i class="fas fa-home"></i>
                        Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
