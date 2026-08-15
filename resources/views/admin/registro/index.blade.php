@extends('layouts.adminmart.default')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $curso_programado->Curso->titulo}}
            </h3>
            <div class="d-flex align-items-center">
                Lista de inscritos
            </div>
        </div>
        <div class="col-5 align-self-center">
            @if (Auth::user()->rol[0]->slug == 'admin')
            <div class="customize-input float-right">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        @if (session()->get('success'))
        {{-- <div class="alert alert-success">
            {{ session()->get('success') }}
        </div><br /> --}}
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Actualizado ! - </strong> {{ session()->get('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <div class="mr-2">
                        <a href="{{ route('admin.copy.users.form', ['curso_id' => $curso_programado->id]) }}"
                            class="btn btn-primary">Incribir alumnos de curso existente</a>
                    </div>
                    <div>
                        <a href="{{ route('admin.exportAllResults', ['curso_id' => $curso_programado->id]) }}"
                            class="btn btn-primary">Exportar Calificaciones del Grupo</a>
                    </div>
                </div>
                <table class="table table-striped table-sm" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de Registro</th>
                            <th>Aceptado</th>
                            <th>Resultados</th>
                            <th>Bloqueo</th>
                            @if (Auth::user()->rol[0]->slug == 'admin')
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
                            <th>Bloqueo</th>
                            @if (Auth::user()->rol[0]->slug == 'admin')
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
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width: 92%; width: 92%;">
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

<!-- Unlock Confirmation Modal -->
<div class="modal fade" id="unlockConfirmModal" tabindex="-1" role="dialog" aria-labelledby="unlockConfirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unlockConfirmModalLabel">Confirmar Desbloqueo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas desbloquear a este usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmUnlock">Desbloquear</button>
            </div>
        </div>
    </div>
</div>

<!-- Unlock Success Modal -->
<div class="modal fade" id="unlockSuccessModal" tabindex="-1" role="dialog" aria-labelledby="unlockSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="unlockSuccessModalLabel">¡Éxito!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <p id="unlockSuccessMessage" class="lead">El usuario ha sido desbloqueado exitosamente.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link href="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"
    rel="stylesheet">
@endsection

@section('javascript')
<script src="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

<script>
    var table;
    $(document).ready(function () {
        var activo = true;
        var endpoint =
            '{{ URL::route(Auth::user()->rol[0]->slug . '.cursos.get-inscritos', ['curso_id' => $curso_programado->id, 'active' => 'si']) }}';
        var show =
            '<a class="btn btn-primary btn-detalle" href="javascript:void(0)" id="{{ route(Auth::user()->rol[0]->slug . '.curso.lista-resultados', ['inscripcion_id' => '__ID__']) }}" title="Ver Resultados"><i class="fas fa-chess"></i></a> ' +
            '<a class="btn btn-info ml-1" href="{{ route('admin.curso.homework.tracking', ['curso_programado_id' => $curso_programado->id, 'user_id' => '__USER_ID__']) }}" title="Ver Tareas"><i class="fas fa-tasks"></i></a> ' +
            '<a class="btn btn-success ml-1" href="{{ route('admin.curso.progress', ['curso_programado_id' => $curso_programado->id, 'user_id' => '__USER_ID__']) }}" title="Ver Progreso"><i class="fas fa-chart-line"></i></a>';
        $("#btnActivo").click(function () {
            if (activo) {
                activo = false;
                $("#btnActivo").text("Usuarios Aceptados");
                endpoint = endpoint.replace("si", "no");
            } else {
                activo = true;
                $("#btnActivo").text("Usaurios No Aceptados");
                endpoint = endpoint.replace("no", "si");
            }
            table.ajax.url(endpoint).load();
        });

        table = $('#dataTable')
            .on('draw.dt', function (e, settings, json, xhr) {
                $('a[class ~= "btn-detalle"]').click(function () {
                    btn = $(this);
                    liga = '' + btn.attr("id");
                    $('.modal-body').load(liga, function () {
                        $('#' + 'myModal').modal({
                            show: true
                        });
                    });
                });
            })
            .on('xhr.dt', function (e, settings, json, xhr) {

            })
            .DataTable({
                language: {
                    processing: "Cargando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
                    infoEmpty: "",
                    infoFiltered: "(filtrado de un total de _MAX_ entradas)",
                    infoPostFix: "",
                    loadingRecords: "",
                    emptyTable: "No existen registros para mostrar",
                    paginate: {
                        first: "Primer",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    },
                },
                processing: true,
                paging: true,
                ajax: {
                    url: endpoint,
                    dataSrc: ''
                },
                columns: [{
                    data: 'nombre_completo',
                    orderable: true,
                },
                {
                    data: 'pivot.created_at',
                    orderable: true,
                },
                {
                    data: 'pivot.aceptado',
                    orderable: true,
                },
                {
                    data: 'pivot.id',
                    orderable: true,
                },
                {
                    data: 'is_blocked',
                    orderable: true,
                },
                @if(Auth:: user() -> rol[0] -> slug == 'admin')
        {
            data: 'pivot.id',
                orderable: true,
                            },
        @endif
                    ],
        dom: 'Bfrtip',
            buttons: [],
                "rowCallback": function(row, data) {

                    $(row).find('td:eq(3)').html(show.replace('__ID__', data['pivot']['id']).replace(/__USER_ID__/g, data['id']));

                    // Columna Bloqueo (Index 4)
                    if (data['is_blocked'] == 1 || data['is_blocked'] == true) {
                        var unlockUrl = "{{ route('users.unlock', ':id') }}";
                        unlockUrl = unlockUrl.replace(':id', data['id']);

                        $(row).find('td:eq(4)').html(
                            '<button type="button" class="btn btn-sm btn-danger btn-unlock" data-id="' +
                            data['id'] + '" title="Desbloquear usuario">' +
                            '<i class="fas fa-lock"></i> Desbloquear' +
                            '</button>'
                        );
                    } else {
                        $(row).find('td:eq(4)').html('<span class="badge badge-success">Activo</span>');
                    }


                    @if (Auth:: user() -> rol[0] -> slug == 'admin')
    if (data['pivot']['aceptado'] == 'si') {
        $(row).find('td:eq(5)').html(
            '<form method="POST" action="{{ route('curso.destroy') }}"> @csrf <input name="id" type="hidden" value="' +
            data['pivot']['id'] +
        '"> <button type="submit" class="btn btn-primary"><i class="fas fa-trash"></i></button></form>'
        );
        $("#activoHead").text("Desactivar");
        $("#activoFoot").text("Desactivar");
    } else {
        $(row).find('td:eq(5)').html(
            '<form method="POST" action="{{ route('curso.activate') }}"> @csrf <input name="id" type="hidden" value="' +
            data['pivot']['id'] +
        '"> <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button></form>'
        );
        $("#activoHead").text("Activar");
        $("#activoFoot").text("Activar");
    }
    @endif
                    },
                });
        });
</script>

<script>
    $(document).ready(function () {

        // ===============================
        // Script para botones "Finalizado"
        // ===============================
        $(document).on("click", "[id^='finalizar-']", function () {
            let button = $(this);
            let id = button.data("id");

            $.ajax({
                url: "{{ route('examen.cambiarEstadoFinalizado') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function (response) {
                    if (response.nuevo_estado === "si") {
                        button.removeClass("btn-danger").addClass("btn-success").text(
                            "Reanudar");
                    } else {
                        button.removeClass("btn-success").addClass("btn-danger").text(
                            "Finalizar");
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // ===============================
        // Script para botones "Retroalimentación"
        // ===============================
        $(document).on("click", "[id^='retro-']", function () {
            let button = $(this);
            let id = button.data("id");

            $.ajax({
                url: "{{ route('examen.cambiarEstadoRetro') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function (response) {
                    if (response.nuevo_estado === "si") {
                        button.removeClass("btn-danger").addClass("btn-success").text(
                            "Reanudar");
                    } else {
                        button.removeClass("btn-success").addClass("btn-danger").text(
                            "Finalizar");
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // ===============================
        // Script para botones "Reiniciar"
        // ===============================
        $(document).on("click", "[id^='reiniciar-']", function () {
            let button = $(this);
            let id = button.data("id");

            if (!confirm("¿Estás seguro de que deseas reiniciar este examen? Se eliminará todo el progreso del alumno.")) {
                return;
            }

            $.ajax({
                url: "{{ route('examen.reiniciar') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        button.text("Reiniciado");
                        button.removeClass("btn-danger").addClass("btn-success");
                        button.prop("disabled", true);
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert("Error al reiniciar el examen.");
                }
            });
        });

        // ===============================
        // ===============================
        // Script para botones "Desbloquear"
        // ===============================
        var userIdToUnlock;

        $(document).on("click", ".btn-unlock", function () {
            userIdToUnlock = $(this).data("id");
            $('#unlockConfirmModal').modal('show');
        });

        $('#btnConfirmUnlock').click(function () {
            if (!userIdToUnlock) return;

            let unlockUrl = "{{ route('users.unlock', ':id') }}";
            unlockUrl = unlockUrl.replace(':id', userIdToUnlock);

            // Disable button to prevent double submit
            $(this).prop('disabled', true);

            $.ajax({
                url: unlockUrl,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    $('#unlockConfirmModal').modal('hide');
                    $('#btnConfirmUnlock').prop('disabled', false);

                    if (response.success) {
                        $('#unlockSuccessMessage').text(response.message);
                        $('#unlockSuccessModal').modal('show');
                        // Table reload is now handled by the modal hidden event
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function (xhr) {
                    $('#unlockConfirmModal').modal('hide');
                    $('#btnConfirmUnlock').prop('disabled', false);
                    console.error(xhr.responseText);
                    alert("Ocurrió un error al intentar desbloquear al usuario.");
                }
            });
        });

        // Reload table when success modal is closed
        $('#unlockSuccessModal').on('hidden.bs.modal', function () {
            table.ajax.reload(null, false); // Reload data, keep paging
        });

    });
</script>
@endsection