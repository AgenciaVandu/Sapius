@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Subir PDF Interactivo</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}" class="text-muted">Cursos</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">{{ $curso->titulo }}</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-muted">{{ $modulo->titulo }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.material-pdfs.index', ['leccion_id' => $leccion->id]) }}" class="text-muted">{{ $leccion->titulo }}</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Subir</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-dark mb-4">Cargar Nuevo Archivo PDF</h4>
                    
                    <form action="{{ route('admin.material-pdfs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="leccion_id" value="{{ $leccion->id }}">

                        <div class="form-group mb-3">
                            <label for="titulo" class="font-weight-bold text-dark">Título del Material</label>
                            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" placeholder="Ej. Ejercicio Práctico 1" value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="file" class="font-weight-bold text-dark">Archivo PDF</label>
                            <div class="custom-file">
                                <input type="file" name="file" id="file" class="custom-file-input @error('file') is-invalid @enderror" accept=".pdf" required>
                                <label class="custom-file-label" for="file">Seleccionar archivo PDF...</label>
                            </div>
                            <small class="text-muted d-block mt-1">Tamaño máximo de archivo: 20MB. Asegúrate de que el documento no esté protegido por contraseña.</small>
                            @error('file')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="allow_download" id="allow_download" class="custom-control-input" value="1" checked>
                                <label class="custom-control-label text-dark font-weight-bold" for="allow_download">Permitir descarga para alumnos</label>
                            </div>
                            <small class="text-muted d-block mt-1">Si se desmarca, los alumnos no podrán descargar el PDF original ni el resuelto con sus respuestas.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.material-pdfs.index', ['leccion_id' => $leccion->id]) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload mr-1"></i> Subir y Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        // Update label name on file select
        document.getElementById('file').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@endsection
