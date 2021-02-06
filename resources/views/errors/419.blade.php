@extends('layouts.adminmart.error')

@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center padding-2" >
                <div class="contaner-title-tabs-black">
                <i class="fas fa-ban"></i>
                Esta acción no esta permitida en el sistema
                <i class="fas fa-ban"></i>
                </div>
                <div class="container-button">
                    <a class="btn btn-info btn-lg"
                    href="{{ route('login') }}">
                    <i class="fas fa-home"></i>
                    Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection