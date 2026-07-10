@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Enviar tarea</h3>
                <div class="d-flex align-items-center">
                    {{-- @include('genericos.breadcrum',['route' => 'lecciones.create']) --}}
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (isset($success))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>¡Correcto! - </strong> {{ $success }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="form_tarea" action="{{ route('alumno.lecciones.sendTarea') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="leccion_id" value="{{ $leccion->id }}">
                        <input type="hidden" name="curso_programado_id" value="{{ $curso_programado->id }}">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="nombre">Nombre completo</label>
                                <input id="nombre" type="text"
                                    class="form-control @error('nombre') is-invalid @enderror" name="nombre"
                                    value="{{ auth()->user()->nombre . ' ' . auth()->user()->apellido }}" required
                                    autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="leccion">Título de la lección</label>
                                <input id="leccion" type="text"
                                    class="form-control @error('leccion') is-invalid @enderror" name="leccion"
                                    value="{{ $leccion->titulo }}" required autocomplete="leccion" autofocus>

                                @error('leccion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="tarea">Título de la tarea</label>
                                <input id="tarea" type="text"
                                    class="form-control @error('tarea') is-invalid @enderror" name="tarea"
                                    value="{{ 'Tarea: ' . $leccion->titulo }}" required autocomplete="tarea" autofocus>

                                @error('tarea')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="descripcion">Adjuntar documento</label>
                                <div class="custom-file">
                                    <input type="file" name="documento" class="custom-file-input" id="inputGroupFile02"
                                        accept="application/pdf,application/msword" required>
                                    <label class="custom-file-label" for="inputGroupFile02"
                                        aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                </div>
                                <div id="file-size-warning" class="alert alert-warning mt-2 d-none" style="border-radius: 8px; border-left: 4px solid #ffc107;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle mr-2 text-warning" style="font-size: 1.2rem;"></i>
                                        <div>
                                            <strong>El archivo supera el límite de 5MB.</strong> Para reducir su tamaño, puedes comprimir tu archivo PDF en <a href="https://www.adobe.com/mx/acrobat/online/compress-pdf.html" target="_blank" rel="noopener noreferrer" class="font-weight-bold text-dark" style="text-decoration: underline;">Adobe Acrobat Online</a>.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                @if (isset($homework))
                                    <button type="button" class="btn btn-secondary btn-block" disabled>
                                        {{ __('Tarea ya enviada') }}
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Enviar') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('css')
    <link href="{{ asset('vendor/summernote/summernote.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
    <script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".custom-file-input").on("change", function() {
                var file = this.files[0];
                var fileName = $(this).val().split("\\").pop();

                if (file && file.size > 5 * 1024 * 1024) {
                    $('#file-size-warning').removeClass('d-none');
                    $(this).val('');
                    $(this).siblings(".custom-file-label").removeClass("selected").html("Selecciona documento");
                    return;
                } else {
                    $('#file-size-warning').addClass('d-none');
                }

                if (fileName) {
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                } else {
                    $(this).siblings(".custom-file-label").addClass("selected").html("Selecciona documento");
                }
            });

            // $('#contenido').summernote({
            //     height: 200,
            // });
        });
    </script>
@endsection
