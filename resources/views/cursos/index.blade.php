@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Administración de Cursos</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.menu',['form' => 'Lecciones'])
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <div class="dropdown float-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" id="btnActivo" href="#">Cursos Inactivos</a>
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
            @if(session()->get('success'))
                {{-- <div class="alert alert-success">
                {{ session()->get('success') }}
                </div><br /> --}}
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Actualizado ! - </strong> {{ session()->get('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-sm" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Módulos</th>
                                <th>Editar</th>
                                <th>Programar</th>
                                <th>Ver</th>
                                <th id="activoHead">Desactivar</th>
                            </tr>
                        </thead>
                        <tfoot class="thead-light">
                            <tr>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Módulos</th>
                                <th>Editar</th>
                                <th>Programar</th>
                                <th>Ver</th>
                                <th id="activoFoot">Desactivar</th>
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
                <h5 class="modal-title">Detalle del curso</h5>
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
            var endpoint = '{{ URL::route(Auth::user()->rol[0]->slug.'.gcu',["active" => "enable"]) }}';
            var show = '<a class="btn btn-primary btn-detalle" href="javascript:void(0)" id="{{ route('admin.cursos.show',1) }}"><i class="fas fa-eye"></i></a>';
            $( "#btnActivo" ).click(function() {
                if(activo){
                    activo = false;
                    $("#btnActivo").text("Cursos Activos");
                    endpoint = endpoint.replace("enable", "disable");
                }else{
                    activo = true;
                    $("#btnActivo").text("Cursos Inactivos");
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
                    { data: 'titulo',orderable: true,},
                    { data: 'descripcion',orderable: true,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,},
                    { data: 'id',orderable: false,}
                ],
                dom: 'Bfrtip',
                buttons: [
                ],
                "rowCallback": function( row, data ) {
                    $(row).find('td:eq(2)').html( '<form method="POST" action="{{ route('admin.lecciones.index') }}"> @csrf <input name="curso_id" type="hidden" value="'+data['id']+'"><input name="leccion_id" type="hidden" value="0"> <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i></button> </form>' );
                    $(row).find('td:eq(3)').html( '<form method="POST" action="{{ route('cursos.edit') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i></button> </form>' );
                    $(row).find('td:eq(4)').html( '<form method="POST" action="{{ route('schedule') }}"> @csrf <input name="curso_id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-calendar-alt"></i></button> </form>' );

                    var s = show.replace('1', data['id']);
                    $(row).find('td:eq(5)').html(s);

                    if(data['activo'] == 'si'){
                        $(row).find('td:eq(6)').html( '<form method="POST" action="{{ route('cursos.destroy') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-trash"></i></button> </form>' );
                        $("#activoHead").text("Desactivar");
                        $("#activoFoot").text("Desactivar");
                    }else{
                        $(row).find('td:eq(6)').html( '<form method="POST" action="{{ route('cursos.activate') }}"> @csrf <input name="id" type="hidden" value="'+data['id']+'"> <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button> </form>' );
                        $("#activoHead").text("Activar");
                        $("#activoFoot").text("Activar");
                    }
                },
            });
        } );
    </script>
@endsection
