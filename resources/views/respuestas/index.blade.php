@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Respuestas</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'respuestas.index'])
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <div class="dropdown float-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="POST" id="create-form"  action="{{ route(Auth::user()->rol[0]->slug.'.respuestas.create') }}">
                                @csrf
                                <input name="pregunta_id" type="hidden" value="{{ $pregunta->id }}">
                                <a class="dropdown-item" href="{{ route(Auth::user()->rol[0]->slug.'.respuestas.create') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('create-form').submit();">
                                    Agregar
                                </a>
                            </form>
                            <a class="dropdown-item" id="btnActivo" href="#">Respuestas Inactivas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(isset($success))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>¡Correcto! - </strong> {{ $success }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-sm" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                            <th>Respuesta</th>
                            <th>Correcto</th>
                            <th>Editar</th>
                            <th id="activoHead">Desactivar</th>
                            <th>Ver</th>
                            </tr>
                        </thead>
                        <tfoot class="thead-light">
                            <tr>
                            <th>Respuesta</th>
                            <th>Correcto</th>
                            <th>Editar</th>
                            <th id="activoFoot">Desactivar</th>
                            <th>Ver</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de la respuesta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('javascript')
    <script src="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready( function () {
            var activo = true;
            var endpoint = '{{ URL::route(Auth::user()->rol[0]->slug.".gres",[$pregunta->id,"enable"]) }}';
            var show = '<a class="btn btn-primary btn-detalle" href="javascript:void(0)" id="{{ route(Auth::user()->rol[0]->slug.'.respuestas.show',1) }}"><i class="fas fa-eye"></i></a>';
            $( "#btnActivo" ).click(function() {
                if(activo){
                    activo = false;
                    $("#btnActivo").text("Respuestas Activas");
                    endpoint = endpoint.replace("enable", "disable");
                }else{
                    activo = true;
                    $("#btnActivo").text("Respuestas Inactivas");
                    endpoint = endpoint.replace("disable", "enable");
                }
                table.ajax.url( endpoint ).load();
            });
            var table =$('#dataTable')
            .on('draw.dt', function ( e, settings, json, xhr ) {
                $('a[class ~= "btn-detalle"]').click(function(){
                    btn = $(this);
                    liga = '' + btn.attr( "id");
                    $('.modal-body').load(liga,function(){
                        $('#' + 'myModal').modal({show:true});
                    });
                });
            } )
            .on('xhr.dt', function ( e, settings, json, xhr ) {
                $('#btn-cargar').attr( "disabled", false );
                $('#btn-cargar').html('Exportar Excel');
            } )
            .DataTable({
                language: {
                    processing:    "Cargando...",
                    search:        "Buscar:",
                    lengthMenu:    "Mostrar _MENU_ registros",
                    info:           "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
                    infoEmpty:      "",
                    infoFiltered:   "(filtrado de un total de _MAX_ entradas)",
                    infoPostFix:    "",
                    loadingRecords: "",
                    emptyTable:     "No existen registros para mostrar",
                    paginate: {
                        first:      "Primer",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Último"
                    },
                },
                processing: true,
                paging: true,
                ajax: {
                    url: endpoint,
                    dataSrc: ''
                },
                columns: [
                    { data: 'respuesta',orderable: true,},
                    { data: 'correcto',orderable: true,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,}
                ],
                dom: 'Bfrtip',
                buttons: [
                ],
                "rowCallback": function( row, data ) {
                    parte1 = data.respuesta.split("<table");

                    if(parte1.length > 1){
                        parte2 =data.respuesta.split("</table>");
                        contenido = parte1[0] + "<br><code> El contenido de esta parte puede vizualizarlo con la opcion VER </code><br>" + parte2[1];
                        $(row).find('td:eq(0)').html(contenido);
                    }


                    if(data['correcto'] == 1){
                        $(row).find('td:eq(1)').html('<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" disabled id="customSwitch2" checked ><label class="custom-control-label" for="customSwitch2">Correcto</label></div>');
                    }else{
                        $(row).find('td:eq(1)').html('<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" disabled id="customSwitch2"><label class="custom-control-label" for="customSwitch2">Incorrecto</label></div>');
                    }
                    $(row).find('td:eq(2)').html( '<form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.respuestas.edit') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i></button> </form>' );
                    if(data['activo'] == 'si'){
                        $(row).find('td:eq(3)').html( '<form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.respuestas.destroy') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fas fa-trash-alt"></i></button> </form>' );
                        $("#activoHead").text("Desactivar");
                        $("#activoFoot").text("Desactivar");
                    }else{
                        $(row).find('td:eq(3)').html( '<form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.respuestas.activate') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fas fa-check"></i></button> </form>' );
                        $("#activoHead").text("Activar");
                        $("#activoFoot").text("Activar");
                    }
                    var s = show.replace('1', data['id']);
                    $(row).find('td:eq(4)').html(s);
                },
            });

            $(document).ready( function () {
                pregunta = $('#spanRespuesta').text();
                parte1 = pregunta.split("<table");

                if(parte1.length > 1){
                        parte2 = pregunta.split("</table>");
                        contenido = parte1[0] + "<br><code> El contenido de esta parte puede vizualizarlo en la seccion de preguntas </code><br>" + parte2[1];
                        $('#spanRespuesta').html(contenido);
                    }
            } );
        } );
    </script>
 @endsection
