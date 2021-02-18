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
                <p class="p-5">Se ha detectado el uso indebido de la plataforma y violación de las restricciones previstas en el contrato de servicios, de los términos y condiciones. Por ello, no podrá continuar con el examen y se le negará la retroalimentación correspondiente, nos reservamos el derecho de negar el acceso permanente a la plataforma.</p>
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
