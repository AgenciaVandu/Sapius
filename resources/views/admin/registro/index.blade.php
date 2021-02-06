@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $curso_programado->Curso->titulo}}</h3>
                <div class="d-flex align-items-center">
                    Lista de inscritos
                </div>
            </div>
            <div class="col-5 align-self-center">
                @if(Auth::user()->rol[0]->slug == "admin")
                <div class="customize-input float-right">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Opciones
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" id="btnActivo" href="#">Usuarios No Aceptados</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-sm" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha de Registro</th>
                                <th>Aceptado</th>
                                <th>Resultados</th>
                                @if(Auth::user()->rol[0]->slug == "admin")
                                <th id="activoHead">Desactivar</th>
                                @endif
                            </tr>
                        </thead>
                        <tfoot class="thead-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha de Registro</th>
                                <th>Aceptado</th>
                                <th>Resultados</th>
                                @if(Auth::user()->rol[0]->slug == "admin")
                                <th id="activoFoot">Desactivar</th>
                                @endif
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
                <h5 class="modal-title"></h5>
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
            var endpoint = '{{ URL::route(Auth::user()->rol[0]->slug.".cursos.get-inscritos",["curso_id" => $curso_programado->id,"active" => "si"]) }}';
            var show = '<a class="btn btn-primary btn-detalle" href="javascript:void(0)" id="{{ route(Auth::user()->rol[0]->slug.'.curso.lista-resultados',['inscripcion_id' => 1]) }}"><i class="fas fa-chess"></i></a>';
            $( "#btnActivo" ).click(function() {
                if(activo){
                    activo = false;
                    $("#btnActivo").text("Usuarios Aceptados");
                    endpoint = endpoint.replace("si", "no");
                }else{
                    activo = true;
                    $("#btnActivo").text("Usaurios No Aceptados");
                    endpoint = endpoint.replace("no", "si");
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
                    { data: 'nombre_completo',orderable: true,},
                    { data: 'pivot.created_at',orderable: true,},
                    { data: 'pivot.aceptado',orderable: true,},
                    { data: 'pivot.id',orderable: true,},
                    @if(Auth::user()->rol[0]->slug == "admin")
                    { data: 'pivot.id',orderable: true,},
                    @endif
                ],
                dom: 'Bfrtip',
                buttons: [
                ],
                "rowCallback": function( row, data ) {

                    $(row).find('td:eq(3)').html( show.replace('1', data['pivot']['id']) );

                    @if(Auth::user()->rol[0]->slug == "admin")
                    if(data['pivot']['aceptado'] == 'si'){
                        $(row).find('td:eq(4)').html( '<form method="POST" action="{{ route('curso.destroy') }}"> @csrf <input name="id" type="hidden" value="'+data['pivot']['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-trash"></i></button></form>' );
                        $("#activoHead").text("Desactivar");
                        $("#activoFoot").text("Desactivar");
                    }else{
                        $(row).find('td:eq(4)').html( '<form method="POST" action="{{ route('curso.activate') }}"> @csrf <input name="id" type="hidden" value="'+data['pivot']['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button></form>' );
                        $("#activoHead").text("Activar");
                        $("#activoFoot").text("Activar");
                    }
                    @endif
                },
            });
        } );
    </script>
@endsection
