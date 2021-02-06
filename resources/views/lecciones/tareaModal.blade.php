@extends('layouts.adminmart.detalle')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" id="form_tarea" action="{{ route('alumno.lecciones.sendTarea') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="nombre">Nombre completo</label>
                        <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                               value="{{ auth()->user()->nombre." ".auth()->user()->apellido }}" required autocomplete="nombre" autofocus>

                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="leccion">Titulo de la leccion</label>
                            <input id="leccion" type="text" class="form-control @error('leccion') is-invalid @enderror" name="leccion"
                                   value="{{ $leccion->titulo }}" required autocomplete="leccion" autofocus>

                            @error('leccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="tarea">Titulo de la tarea</label>
                            <input id="tarea" type="text" class="form-control @error('tarea') is-invalid @enderror" name="tarea"
                                   value="{{ "Tarea: ".$leccion->titulo }}" required autocomplete="tarea" autofocus>

                            @error('tarea')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="descripcion">Adjuntar documento</label>
                            <div class="custom-file">
                                <input type="file" name="documento" class="custom-file-input" id="inputGroupFile02" accept="application/pdf,application/msword">
                                <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Selecciona</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Enviar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready( function () {
        //Boton del modal que carga
        $("#continuar").hide();
        //cambiar nombre de input importar
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            if (fileName) {
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            }else{
                $(this).siblings(".custom-file-label").addClass("selected").html("Selecciona documento");
            }
        });

        // Attach an event for when the user submits the form
        $('#form_tarea').on('submit', function(event) {
            // Prevent the page from reloading
            event.preventDefault();
            var token =  "{{ csrf_token() }}";
            var nombre =  $("#nombre").val();
            var leccion =  $("#leccion").val();
            var tarea =  $("#tarea").val();
            //var documento =  $('#inputGroupFile02');
            $.post("{{ route('alumno.lecciones.sendTarea') }}", {
                _token: token,
                nombre: nombre,
                leccion: leccion,
                tarea: tarea
                //documento: documento
            },function(){
            }).done(function(){
                alert("ok");
                //$("#divAlerts").html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>¡Correcto!</strong> Usuario validado </div>');
            }).fail(function(){
                alert("fail");
                //$("#divAlerts").html('<div class="alert alert-danger alert-dismissible bg-success text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>Error !</strong> No se aplicaron los cambios </div>');
            });
        });
    });
</script>
@endsection
