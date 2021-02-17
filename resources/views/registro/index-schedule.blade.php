@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Programación de cursos</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'schedule'])
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <div class="dropdown float-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="POST" id="create-form"  action="{{ route('schedule.create') }}">
                                @csrf
                                <input name="curso_id" type="hidden" value="{{ $curso->id }}">
                                <a class="dropdown-item" href="{{ route('schedule.create') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('create-form').submit();">
                                    Agregar
                                </a>
                            </form>
                            <a class="dropdown-item" id="btnActivo" href="#">Cursos Programados Inactivos</a>
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
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-sm" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Identificador</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>
                                <th>Instructor</th>
                                <th>Precio</th>
                                <th>Clave descuento</th>
                                <th>Contenido</th>
                                <th>Editar</th>
                                <th>Desactivar</th>
                            </tr>
                        </thead>
                        <tfoot class="thead-light">
                            <tr>
                                <th>Identificador</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>
                                <th>Instructor</th>
                                <th>Precio</th>
                                <th>Clave descuento</th>
                                <th>Contenido</th>
                                <th>Editar</th>
                                <th>Desactivar</th>
                            </tr>
                        </tfoot>
                    </table>
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
            var endpoint = '{{ URL::route("schedule.getall",[$curso->id,"enable"]) }}';

            $( "#btnActivo" ).click(function() {
                if(activo){
                    activo = false;
                    $("#btnActivo").text("Cursos Programados Activos");
                    endpoint = endpoint.replace("enable", "disable");
                }else{
                    activo = true;
                    $("#btnActivo").text("Cursos Programados Inactivos");
                    endpoint = endpoint.replace("disable", "enable");
                }
                table.ajax.url( endpoint ).load();
            });
            var table =$('#dataTable')
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
                    { data: 'identificador',orderable: true,},
                    { data: 'fecha_inicio',orderable: true,},
                    { data: 'fecha_fin',orderable: true,},
                    { data: 'instructor.nombre_completo',orderable: true,},
                    { data: 'precio',orderable: true,},
                    { data: 'clave_descuento',orderable: false,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,},
                ],
                dom: 'Bfrtip',
                buttons: [
                ],
                "rowCallback": function( row, data ) {
                    $(row).find('td:eq(5)').html( '<form method="POST" action="{{ route('descuento.index') }}"> @csrf <input name="cp_id" type="hidden" value="'+data['id']+'"> <input name="curso_id" type="hidden" value="'+data['curso_id']+'"><button type="submit" class="btn btn-primary"><i class="fas fa-barcode"></i></button> </form>' );
                    $(row).find('td:eq(6)').html( '<form method="POST" action="{{ route('contenido.index') }}"> @csrf <input name="cp_id" type="hidden" value="'+data['id']+'"> <input name="curso_id" type="hidden" value="'+data['curso_id']+'"><button type="submit" class="btn btn-primary"><i class="fas fa-book"></i></button> </form>' );
                    $(row).find('td:eq(7)').html( '<form method="POST" action="{{ route('schedule.edit') }}"> @csrf <input name="cp_id" type="hidden" value="'+data['id']+'"> <input name="curso_id" type="hidden" value="'+data['curso_id']+'"><button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i></button> </form>' );
                    $(row).find('td:eq(8)').html( '<form method="POST" action="{{ route('schedule.destroy') }}"> @csrf <input name="cp_id" type="hidden" value="'+data['id']+'"> <input name="curso_id" type="hidden" value="'+data['curso_id']+'"><button type="submit" class="btn btn-primary"><i class="fas fa-trash"></i></button> </form>' );
                },
            });
        } );
    </script>
@endsection
