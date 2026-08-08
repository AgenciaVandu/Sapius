@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">PDFs Interactivos</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}" class="text-muted">Cursos</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">{{ $curso->titulo }}</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">{{ $modulo->titulo }}</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">{{ $leccion->titulo }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <a href="{{ route('admin.material-pdfs.create', ['leccion_id' => $leccion->id]) }}" class="btn btn-primary btn-rounded">
                        <i class="fas fa-plus mr-1"></i> Subir PDF Interactivo
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-dark">Materiales Interactivos de la Clase</h4>
                    <p class="card-subtitle mb-4">Sube archivos PDF y añade campos de texto para que los alumnos respondan.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th>Título</th>
                                    <th>Archivo</th>
                                    <th>Descarga Alumnos</th>
                                    <th>Campos Configurados</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materials as $material)
                                    <tr>
                                        <td>
                                            <span class="font-weight-medium text-dark">{{ $material->titulo }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.material-pdfs.download-raw', $material->id) }}" class="text-primary">
                                                <i class="far fa-file-pdf mr-1"></i> {{ $material->file_path }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if($material->allow_download)
                                                <span class="badge badge-pill badge-success"><i class="fas fa-check-circle mr-1"></i> Permitida</span>
                                            @else
                                                <span class="badge badge-pill badge-danger"><i class="fas fa-ban mr-1"></i> Denegada</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $fields = $material->fields_config;
                                                $count = is_array($fields) ? count($fields) : 0;
                                            @endphp
                                            <span class="badge badge-pill badge-{{ $count > 0 ? 'success' : 'warning' }}">
                                                {{ $count }} campo(s)
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit-material" 
                                                        data-id="{{ $material->id }}" 
                                                        data-titulo="{{ $material->titulo }}" 
                                                        data-allow-download="{{ $material->allow_download ? '1' : '0' }}" 
                                                        title="Editar Metadatos">
                                                    <i class="fas fa-edit mr-1"></i> Editar
                                                </button>
                                                <a href="{{ route('admin.material-pdfs.edit', $material->id) }}" class="btn btn-sm btn-info text-white" title="Configurar Campos">
                                                    <i class="fas fa-cog mr-1"></i> Configurar Campos
                                                </a>
                                                <form action="{{ route('admin.material-pdfs.destroy', $material->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este PDF interactivo?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No hay PDFs interactivos subidos para esta clase.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editMaterialModal" tabindex="-1" role="dialog" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit-material-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title text-white font-weight-bold" id="editMaterialModalLabel"><i class="fas fa-edit mr-2"></i> Editar PDF Interactivo</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="modal-titulo" class="font-weight-bold text-dark">Título del PDF</label>
                            <input type="text" name="titulo" id="modal-titulo" class="form-control" placeholder="Ej. Ejercicio Práctico" required>
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="allow_download" id="modal-allow-download" class="custom-control-input" value="1">
                                <label class="custom-control-label text-dark font-weight-bold" for="modal-allow-download">Permitir descarga para alumnos</label>
                            </div>
                            <small class="text-muted d-block mt-1">Si se desmarca, los alumnos no podrán descargar el archivo original ni el resuelto con sus respuestas.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning text-white font-weight-bold">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('.btn-edit-material').click(function() {
                var id = $(this).data('id');
                var titulo = $(this).data('titulo');
                var allowDownload = $(this).data('allow-download');

                var formAction = "{{ route('admin.material-pdfs.update', ':id') }}".replace(':id', id);
                $('#edit-material-form').attr('action', formAction);
                $('#modal-titulo').val(titulo);
                $('#modal-allow-download').prop('checked', allowDownload == '1');

                $('#editMaterialModal').modal('show');
            });
        });
    </script>
@endsection
