@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Multimedia</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'medias.index'])
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <div class="dropdown float-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="POST" id="create-form"  action="{{ route(Auth::user()->rol[0]->slug.'.medias.create') }}">
                                @csrf
                                <input name="leccion_id" type="hidden" value="{{ $leccion->id }}">
                                <a class="dropdown-item" href="{{ route(Auth::user()->rol[0]->slug.'.medias.create') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('create-form').submit();">
                                    Agregar
                                </a>
                            </form>
                            <a class="dropdown-item" id="btnActivo" href="#">Multimedia Inactivo</a>
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
                            <th>Tipo</th>
                            <th>Liga</th>
                            <th>Editar</th>
                            <th id="activoHead">Desactivar</th>
                            <th>Ver</th>
                            </tr>
                        </thead>
                        <tfoot class="thead-light">
                            <tr>
                            <th>Tipo</th>
                            <th>Liga</th>
                            <th>Editar</th>
                            <th id="activoHead">Desactivar</th>
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
                <h5 class="modal-title">Detalles del multimedia</h5>
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
            var endpoint = '{{ URL::route(Auth::user()->rol[0]->slug.".gmed",["leccion_id" => $leccion->id,"active" => "enable"]) }}';
            var show = '<a class="btn btn-primary btn-detalle" href="javascript:void(0)" id="{{ route(Auth::user()->rol[0]->slug.'.medias.show','#video') }}"><i class="fas fa-eye"></i></a>';
            var download = '<a href="{{ URL::route(Auth::user()->rol[0]->slug.'.medias.archivo',['file' => '#archivo']) }}" class="btn btn-primary"><i class="fas fa-download"></i></a>';
            $( "#btnActivo" ).click(function() {
                if(activo){
                    activo = false;
                    $("#btnActivo").text("Multimedia Activo");
                    endpoint = endpoint.replace("enable", "disable");
                }else{
                    activo = true;
                    $("#btnActivo").text("Multimedia Inactivo");
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
                    { data: 'tipo',orderable: true,},
                    { data: 'ruta',orderable: true,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,}
                ],
                dom: 'Bfrtip',
                buttons: [
                ],
                "rowCallback": function( row, data ) {
                    $(row).find('td:eq(2)').html( '<form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.medias.edit') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i></button> </form>' );
                    if(data['activo'] == 'si'){
                        $(row).find('td:eq(3)').html( '<form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.medias.destroy') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-trash"></i></button></form>' );
                        $("#activoHead").text("Desactivar");
                        $("#activoFoot").text("Desactivar");
                    }else{
                        $(row).find('td:eq(3)').html( '<form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.medias.activate') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button></form>' );
                        $("#activoHead").text("Activar");
                        $("#activoFoot").text("Activar");
                    }
                    if(data['tipo'] == 'archivo'){
                        var d = download.replace('#archivo', data['ruta']);
                        $(row).find('td:eq(4)').html(d);
                    }else{
                        var s = show.replace('#video', data['id']);
                        $(row).find('td:eq(4)').html(s);
                    }
                },
            });
        } );
    </script>
@endsection
