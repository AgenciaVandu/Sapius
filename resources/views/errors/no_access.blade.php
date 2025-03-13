@extends('layouts.adminmart.error')

@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center padding-2" >
                <div class="contaner-title-tabs-black">
                <i class="fas fa-ban"></i>
                Esta acción no esta permitida en el sistema (error 500)
                <i class="fas fa-ban"></i>
                </div>
                <p class="p-5">La parte del sitio al que deseas ingresar no es posible desde dispositivos como smartphones o tabletas, debes ingresar por medio de una laptop u ordenador </p>
                <div class="container-button">
                    <a class="btn btn-info btn-lg"
                    href="{{ route('landing.home') }}">
                    <i class="fas fa-home"></i>
                    Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
