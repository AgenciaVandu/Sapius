@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Descuento par el curso</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'descuento.index'])
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <div class="dropdown float-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="POST" id="create-form"  action="{{ route('descuento.create') }}">
                                @csrf
                                <input name="curso_programado_id" type="hidden" value="{{ $curso->id }}">
                                <a class="dropdown-item" href="{{ route('descuento.create') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('create-form').submit();">
                                    Agregar
                                </a>
                            </form>
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
                                <th>clave</th>
                                <th>% de descuento</th>
                                <th>limite</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tfoot class="thead-light">
                            <tr>
                                <th>clave</th>
                                <th>% de descuento</th>
                                <th>limite</th>
                                <th>Editar</th>
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
                    url: '{{ URL::route("descuento.getall", $curso->id) }}',
                    dataSrc: ''
                },
                columns: [
                    { data: 'clave',orderable: true,},
                    { data: 'descuento',orderable: true,},
                    { data: 'limite',orderable: true,},
                    { data: 'id',orderable: true,},


                ],
                dom: 'Bfrtip',
                buttons: [
                ],
                "rowCallback": function( row, data ) {
                    $(row).find('td:eq(3)').html( '<form method="POST" action="{{ route('descuento.edit') }}"> @csrf <input name="curso_programado_id" type="hidden" value="'+data['curso_programado_id']+'"> <input name="descuento_id" type="hidden" value="'+data['id']+'"><button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i></button> </form>' );
                },
            });
        } );
    </script>
@endsection
