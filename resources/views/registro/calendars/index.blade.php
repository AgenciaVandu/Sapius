@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Calendarios de Programación</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}">Cursos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $curso->nombre }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Form Column -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    Subir Nuevo Calendario
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.programming.calendar.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="curso_id" value="{{ $curso->id }}">

                        <div class="form-group">
                            <label for="images">Imágenes del Calendario (Puedes seleccionar varias)</label>
                            <input type="file" name="images[]" class="form-control-file" id="images" required
                                accept="image/*" multiple>
                        </div>

                        <div class="form-group">
                            <label for="group_name">Nombre del Grupo / Semana (Opcional)</label>
                            <input type="text" name="group_name" class="form-control" id="group_name"
                                placeholder="Ej: Semana 1">
                        </div>

                        <div class="form-group">
                            <label for="start_date">Fecha Inicio</label>
                            <input type="date" name="start_date" class="form-control" id="start_date" required>
                        </div>

                        <div class="form-group">
                            <label for="end_date">Fecha Fin</label>
                            <input type="date" name="end_date" class="form-control" id="end_date" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Subir Calendario</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Column -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span>Listado de Calendarios</span>
                    <button id="saveOrderBtn" class="btn btn-success btn-sm" style="display: none;">Guardar Orden</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="calendarsTable">
                            <thead>
                                <tr>
                                    <th>Orden</th>
                                    <th>Imagen</th>
                                    <th>Grupo</th>
                                    <th>Fechas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($calendars as $calendar)
                                    <tr data-id="{{ $calendar->id }}" style="cursor: move;">
                                        <td style="width: 80px;">
                                            <input type="number" class="form-control form-control-sm order-input"
                                                value="{{ $calendar->position }}">
                                        </td>
                                        <td style="width: 150px;">
                                            <a href="{{ asset('storage/' . $calendar->image_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $calendar->image_path) }}" alt="Calendario"
                                                    class="img-fluid" style="max-height: 100px;">
                                            </a>
                                        </td>
                                        <td>{{ $calendar->group_name ?? '-' }}</td>
                                        <td>
                                            <small>
                                                {{ \Carbon\Carbon::parse($calendar->start_date)->format('d/m/Y') }} <br>
                                                {{ \Carbon\Carbon::parse($calendar->end_date)->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.programming.calendar.destroy', $calendar->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este calendario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay calendarios registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Sortable
            var el = document.getElementById('calendarsTable').getElementsByTagName('tbody')[0];
            var sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function(evt) {
                    updateOrderNumbers();
                    $('#saveOrderBtn').show();
                }
            });

            // Function to update the visible numbers and inputs
            function updateOrderNumbers() {
                $('#calendarsTable tbody tr').each(function(index) {
                    var newPosition = index + 1;
                    $(this).find('.order-input').val(newPosition);
                });
            }

            $('.order-input').on('change', function() {
                $('#saveOrderBtn').show();
            });

            $('#saveOrderBtn').on('click', function() {
                let order = [];
                $('.order-input').each(function() {
                    let row = $(this).closest('tr');
                    let id = row.data('id');
                    let position = $(this).val();
                    order.push({
                        id: id,
                        position: position
                    });
                });

                $.ajax({
                    url: "{{ route('admin.programming.calendar.reorder') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order: order
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Orden actualizado correctamente.');
                            $('#saveOrderBtn').hide();
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Hubo un error al guardar el orden.');
                    }
                });
            });
        });
    </script>
@endsection
