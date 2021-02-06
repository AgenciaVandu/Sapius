@extends('layouts.adminmart.detalle')

@section('content')
<div id="divAlerts"></div>
<div class="grid-structure">
    <div class="row">
        <strong>Datos principales: </strong>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <strong>Nombre: </strong><br>
            {{ $user->nombre_completo }}
        </div>
        <div class="col-lg-4">
            <strong>Usuario: </strong><br>
            {{ $user->username }}
        </div>
        <div class="col-lg-4">
            <strong>Correo: </strong><br>
            {{ $user->email }}
        </div>
        <div class="col-lg-4">
            <strong>Rol: </strong><br>
            {{ $user->roles[0]->name }}
        </div>
    </div>
    <div class="row">
        <strong>Datos complementarios: </strong>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <strong>Telefono: </strong><br>
            {{ $user->telefono }}
        </div>
        <div class="col-lg-4">
            <strong>Fecha sustentacion: </strong><br>
            {{ $user->fecha_sustentacion }}
        </div>
        <div class="col-lg-4">
            <strong>Folio: </strong><br>
            {{ $user->folio }}
        </div>
        <div class="col-lg-4">
            <strong>Universidad de procedencia: </strong><br>
            {{ $user->universidad_procedencia }}
        </div>
        <div class="col-lg-4">
            <strong>Especialidad: </strong><br>
            {{ $user->especialidad }}
        </div>
    </div>
    <div class="row">
        <strong>Documentos digitales: </strong>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <strong>Pase de ingreso: </strong>
            @if($user->pase_ingreso !== null && $user->pase_ingreso !== "")
                <a href="{{ URL::route(Auth::user()->rol[0]->slug.'.pase',['file' => $user->pase_ingreso]) }}" class="btn btn-secondary">
                    <i class="fas fa-download"></i>
                </a>
                @else
                No disponible
            @endif
        </div>
        <div class="col-lg-6">
            <strong>Identificacion: </strong>
            @if($user->documento_identificacion !== null && $user->documento_identificacion !== "")
                <a href="{{ URL::route(Auth::user()->rol[0]->slug.'.documento',['file' => $user->documento_identificacion]) }}" class="btn btn-secondary">
                    <i class="fas fa-download"></i>
                </a>
                @else
                No disponible
            @endif
        </div>
    </div>
    <div class="row">
        <strong>Foto: </strong>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if($user->foto !== null && $user->foto !== "")
                <img id="img" src="{{ route(Auth::user()->rol[0]->slug.'.image',['file' => $user->foto]) }}" alt="image"
                     class="img-thumbnail" width="50">
                @else
                No disponible
            @endif
        </div>
    </div>
    <div class="row" id="rowValidar">
        <div class="col-lg-8">
        </div>
        <div class="col-lg-4 text-right">
            <button id="btnValidar" type="button" class="btn btn-success">
                <i class="fas fa-check"></i> Validar
            </button>
            <button id="btnInvalidar" type="button" class="btn btn-warning">
                <i class="fas fa-times"></i> Eliminar validación
            </button>
        </div>
    </div>
    <div class="row" id="rowValidarOk">
        <div class="col-lg-8">
            <strong id="mensaje"></strong>
        </div>
        <div class="col-lg-2 text-right">
            <button id="btnSi" type="button" class="btn btn-success"><i class="fas fa-check"></i>
                Si</button>
        </div>
        <div class="col-lg-2 text-right">
            <button id="btnNo" type="button" class="btn btn-danger"><i class="fas fa-times"></i>
                No</button>
        </div>
    </div>
    <input id="validado" type="hidden" value="{{ $user->validado }}">
</div> <!-- grid-structure -->

{{-- <table class="table table-borderless table-striped">
    <tbody>
        <tr>
            <th scope="row">Nombre:</th>
            <td>{{ $user->nombre_completo }}<td>
        </tr>
        <tr>
            <th scope="row">Usuario:</th>
            <td>{{ $user->username }}<td>
        </tr>
        <tr>
            <th scope="row">Correo Electrónico:</th>
            <td>{{ $user->email }}<td>
        </tr>
        <tr>
            <th scope="row">Rol:</th>
            <td>{{ $user->roles[0]->name }}<td>
        </tr>
        <tr>
            <th scope="row">Telefono:</th>
            <td>{{ $user->telefono }}<td>
        </tr>
        <tr>
            <th scope="row">Fecha sustentacion:</th>
            <td>{{ $user->fecha_sustentacion }}<td>
        </tr>
        <tr>
            <th scope="row">Folio:</th>
            <td>{{ $user->folio }}<td>
        </tr>
        <tr>
            <th scope="row">Universidad de procedencia:</th>
            <td>{{ $user->universidad_procedencia }}<td>
        </tr>
        <tr>
            <th scope="row">Especialidad:</th>
            <td>{{ $user->especialidad }}<td>
        </tr>
        <tr>
            <th scope="row">Folio:</th>
            <td>{{ $user->folio }}<td>
        </tr>
        <tr>
            <th scope="row">Folio:</th>
            <td>{{ $user->folio }}<td>
        </tr>
        <tfoot>
            <tr>
                <th>¿ Deseas validar los datos ?</th>
                <td>
                    <button type="button" class="btn btn-success"><i class="fas fa-check"></i>
                    Validar</button>
                </td>
            </tr>
          </tfoot>
    </tbody>
</table> --}}

@endsection
<script src="{{ asset('js/funciones.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        //validar en que estado esta validado
        var validado =  $("#validado").val();

        if(validado == "no"){
            $("#btnInvalidar").hide();
        }else if(validado == "si"){
            $("#btnValidar").hide();
        }

        $("#rowValidarOk").hide();

        $("#btnValidar").click(function() {
            $("#rowValidar").hide();//row de los botones
            $("#rowValidarOk").show();
            $("#mensaje").text('¿Deseas aprobar los datos del usuario?');
        });

        $("#btnInvalidar").click(function() {
            $("#rowValidar").hide();//row de los botones
            $("#rowValidarOk").show();
            $("#mensaje").text('¿Deseas eliminar la validacion del usuario?');
        });

        $("#btnNo").click(function() {
            //Dinamico
            $("#rowValidar").show();
            $("#rowValidarOk").hide();
        });

        $("#btnSi").click(function() {
            var id = @json($user->id, JSON_PRETTY_PRINT);
            var token =  "{{ csrf_token() }}";
            validado =  $("#validado").val();
            if(validado == "no"){
                $.post("{{ route('users.approve') }}", { _token: token, id: id},function(){
                }).done(function(){
                    $("#rowValidarOk").hide();
                    $("#validado").val("si");
                    $("#btnValidar").hide();
                    $("#btnInvalidar").show();
                    $("#rowValidar").show();
                    $("#divAlerts").html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>¡Correcto!</strong> Usuario validado </div>');
                    validadoEstatusModal = true;
                }).fail(function(){
                    $("#rowValidar").show();
                    $("#rowValidarOk").hide();
                    $("#divAlerts").html('<div class="alert alert-danger alert-dismissible bg-success text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>Error !</strong> No se aplicaron los cambios </div>');
                });
            }else if(validado == "si"){
                $.post("{{ route('users.unapprove') }}", { _token: token, id: id},function(){
                }).done(function(){
                    $("#rowValidarOk").hide();
                    $("#validado").val("no");
                    $("#btnInvalidar").hide();
                    $("#btnValidar").show();
                    $("#rowValidar").show();
                    $("#divAlerts").html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>¡Correcto!</strong> Validacion Eliminada </div>');
                    validadoEstatusModal = true;
                }).fail(function(){
                    $("#rowValidar").show();
                    $("#rowValidarOk").hide();
                    $("#divAlerts").html('<div class="alert alert-danger alert-dismissible bg-success text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>Error !</strong> No se aplicaron los cambios </div>');
                });
            }
        });

    });
</script>
