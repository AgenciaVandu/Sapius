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
                                                <a href="{{ route('admin.material-pdfs.edit', $material->id) }}" class="btn btn-sm btn-info text-white" title="Configurar Campos">
                                                    <i class="fas fa-edit mr-1"></i> Configurar Campos
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
                                        <td colspan="4" class="text-center text-muted py-4">
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
@endsection
