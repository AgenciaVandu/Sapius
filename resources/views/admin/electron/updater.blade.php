@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Actualizador Electron</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}" class="text-muted">Inicio</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Electron Updater</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0 text-white">Subir Archivos de Actualización</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.electron.updater.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="latest_yml" class="font-weight-medium">1. Archivo latest.yml</label>
                            <input type="file" class="form-control-file" id="latest_yml" name="latest_yml" accept=".yml">
                            <small class="form-text text-muted">Contiene los metadatos y la versión (debe llamarse exactamente <code>latest.yml</code>).</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="installer_exe" class="font-weight-medium">2. Instalador Ejecutable (.exe)</label>
                            <input type="file" class="form-control-file" id="installer_exe" name="installer_exe" accept=".exe">
                            <small class="form-text text-muted">El instalador ejecutable generado (ej: <code>Sapius MAC Detector Setup 1.0.1.exe</code>).</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="blockmap_file" class="font-weight-medium">3. Archivo Blockmap (.blockmap) <span class="badge badge-secondary">Opcional</span></label>
                            <input type="file" class="form-control-file" id="blockmap_file" name="blockmap_file" accept=".blockmap">
                            <small class="form-text text-muted">Permite descargas y parches parciales súper eficientes en Windows (ej: <code>Sapius MAC Detector Setup 1.0.1.exe.blockmap</code>).</small>
                        </div>

                        <div class="d-flex flex-row-reverse mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload mr-2"></i> Subir Archivos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body bg-light rounded">
                    <h5 class="card-title text-dark">Versión Publicada Actual</h5>
                    <h2 class="display-4 text-primary font-weight-bold mb-0">{{ $currentVersion }}</h2>
                    <p class="text-muted small mt-2 mb-0">Esta es la versión leída desde el archivo <code>latest.yml</code> en tu servidor.</p>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h4 class="card-title mb-0 text-white">Archivos Disponibles en el Servidor</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nombre del Archivo</th>
                                    <th>Tamaño</th>
                                    <th>Última Modificación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($files) > 0)
                                    @foreach ($files as $file)
                                        <tr>
                                            <td class="font-weight-medium">{{ $file['name'] }}</td>
                                            <td>{{ $file['size'] }}</td>
                                            <td class="text-muted small">{{ $file['last_modified'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center text-muted p-4">
                                            No hay archivos de actualización cargados todavía.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
