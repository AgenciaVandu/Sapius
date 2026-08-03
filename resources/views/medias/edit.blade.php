@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Editar Multimedia de la Lección {{$leccion->titulo}}</h3>
                <div class="d-flex align-items-center">
                    {{-- Curso: {{ $curso->titulo }} --}}
                    @include('genericos.breadcrum',['route' => 'medias.edit'])
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.medias.update') }}">
                        @csrf

                        <input name="id" type="hidden" value="{{ $media->id }}">

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">Tipo de multimedia</label>

                            <div class="col-md-6">
                                <select id="tipo" class="form-control @error('nombre') is-invalid @enderror" name="tipo" value="" required autocomplete="tipo" autofocus>
                                <option value="{{$media->tipo}}" selected>{{ucfirst($media->tipo)}}</option>
                                    {{-- <option value="imagen" @if($media->tipo == "imagen") selected @endif>Imagen</option>
                                    <option value="archivo" @if($media->tipo == "archivo") selected @endif>Archivo</option>
                                    <option value="liga" @if($media->tipo == "liga") selected @endif>Liga</option>
                                    <option value="video" @if($media->tipo == "video") selected @endif>Video</option> --}}
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" id="rowRuta">
                            <label for="ruta" class="col-md-4 col-form-label text-md-right">Ruta o Enlace</label>

                            <div class="col-md-6">
                                <input id="ruta" type="text" class="form-control @error('ruta') is-invalid @enderror" name="ruta" value="{{ $media->ruta }}" autocomplete="ruta" autofocus>

                                @error('ruta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" id="rowVideoUpload" style="display: none;">
                            <label class="col-md-4 col-form-label text-md-right">Origen del Video</label>
                            <div class="col-md-6">
                                <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                                    <label class="btn btn-outline-primary active w-50" id="lblVideoLink">
                                        <input type="radio" name="video_source" id="videoLinkRadio" value="link" checked> Enlace de Video
                                    </label>
                                    <label class="btn btn-outline-primary w-50" id="lblVideoFile">
                                        <input type="radio" name="video_source" id="videoFileRadio" value="file"> Subir Archivo
                                    </label>
                                </div>

                                <!-- Drag & Drop Zone -->
                                <div id="videoDropZone" class="video-drop-zone p-4 text-center border rounded mb-3" style="display: none; border-style: dashed !important; border-width: 2px !important; border-color: #5f76e8 !important; background-color: #f8f9fa; cursor: pointer; transition: all 0.2s;">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                                    <h5>Arrastra tu archivo de video aquí</h5>
                                    <p class="text-muted small">o haz clic para buscar en tu equipo (Solo MP4)</p>
                                    <input type="file" id="videoFileInput" accept="video/mp4" style="display: none;">
                                </div>

                                <!-- Progress Bar Container -->
                                <div id="videoProgressContainer" class="border rounded p-3 mb-3" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span id="videoFileName" class="text-truncate font-weight-bold" style="max-width: 70%;">video.mp4</span>
                                        <span id="videoProgressPercent" class="text-primary font-weight-bold">0%</span>
                                    </div>
                                    <div class="progress mb-2" style="height: 10px;">
                                        <div id="videoProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small id="videoUploadStatus" class="text-muted">Subiendo...</small>
                                        <button type="button" id="btnCancelVideoUpload" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 11px;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="rowImagen">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">Imagen</label>

                            @if($media->tipo == "imagen")
                                @if($media->ruta)
                                    <a href="#" id="btnEliminarImagen">Eliminar imagen</a>
                                    <input name="imgEliminar" type="hidden" value="">
                                    <img src="{{  route(Auth::user()->rol[0]->slug.'.medias.image',['file' => $media->ruta]) }}"
                                            id="img"
                                            width="600"
                                            alt="..."
                                            class="img-thumbnail">
                                @endif
                            @endif

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile02" accept="image/*">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Cambiar imagen</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="rowArchivo">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">Archivo</label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                </div>
                            </div>
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right mt-1">Descargable</label>
                            <div class="col-md-6 d-flex align-items-center">
                                    <input type="checkbox" class="form-check-input ml-1" name="downloadable" value="{{ $media->downloadable }}" >
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="btnSubmitForm" class="btn btn-primary">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready( function () {
            //cambiar nombre de input importar
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                if (fileName) {
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                }else{
                    $(this).siblings(".custom-file-label").addClass("selected").html("Selecciona archivo");
                }
            });

            $( "#btnEliminarImagen" ).click(function() {
                $('#img').hide();
                $('#btnEliminarImagen').hide();
                $('#imgEliminar').val('si')
            });

            // Lógica de carga fragmentada de videos
            var currentXhr = null;
            var isUploading = false;

            $('#videoDropZone').on('click', function() {
                $('#videoFileInput').click();
            });

            $('#videoFileInput').on('click', function(e) {
                e.stopPropagation();
            });

            $('#videoDropZone').on('dragover', function(e) {
                e.preventDefault();
                $(this).css('background-color', '#e2e6ff');
            });

            $('#videoDropZone').on('dragleave', function(e) {
                e.preventDefault();
                $(this).css('background-color', '#f8f9fa');
            });

            $('#videoDropZone').on('drop', function(e) {
                e.preventDefault();
                $(this).css('background-color', '#f8f9fa');
                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    handleVideoSelect(files[0]);
                }
            });

            $('#videoFileInput').on('change', function() {
                if (this.files.length > 0) {
                    handleVideoSelect(this.files[0]);
                }
            });

            $('input[name="video_source"]').on('change', function() {
                if (this.value === 'file') {
                    $('#rowRuta').hide();
                    $('#videoDropZone').show();
                    if ($('#ruta').val().trim() !== '' && !isUploading) {
                        $('#videoProgressContainer').show();
                        $('#videoFileName').text($('#ruta').val());
                        $('#videoUploadStatus').text('Archivo de video cargado.');
                        $('#videoProgressBar').css('width', '100%').removeClass('progress-bar-striped progress-bar-animated').addClass('bg-success');
                        $('#videoProgressPercent').text('100%');
                    }
                } else {
                    $('#rowRuta').show();
                    $('#videoDropZone').hide();
                    $('#videoProgressContainer').hide();
                }
            });

            // Si es un video y el nombre termina en .mp4 (o similar), asumimos que es un archivo subido
            var initialRoute = $('#ruta').val().trim();
            if ("{{ $media->tipo }}" === "video" && initialRoute !== "") {
                var isProbablyFile = initialRoute.indexOf('.') !== -1 && initialRoute.indexOf('/') === -1 && initialRoute.indexOf('http') === -1;
                if (isProbablyFile) {
                    $('#videoFileRadio').prop('checked', true).closest('label').addClass('active');
                    $('#videoLinkRadio').prop('checked', false).closest('label').removeClass('active');
                }
            }

            function handleVideoSelect(file) {
                if (isUploading) return;

                var extension = file.name.split('.').pop().toLowerCase();
                if (extension !== 'mp4') {
                    alert('Por compatibilidad con todos los navegadores de los alumnos, solo se permiten videos en formato MP4.');
                    return;
                }
                
                $('#videoFileName').text(file.name);
                $('#videoProgressContainer').show();
                $('#videoProgressBar').css('width', '0%').addClass('progress-bar-striped progress-bar-animated').removeClass('bg-success');
                $('#videoProgressPercent').text('0%');
                $('#videoUploadStatus').text('Iniciando carga...');
                
                // Deshabilitar botón submit
                $('#btnSubmitForm').prop('disabled', true);
                isUploading = true;

                uploadVideoInChunks(file);
            }

            function uploadVideoInChunks(file) {
                var chunkSize = 5 * 1024 * 1024; // 5MB
                var totalChunks = Math.ceil(file.size / chunkSize);
                var identifier = 'vid-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                var currentChunk = 0;

                function sendNextChunk() {
                    if (!isUploading) return;

                    var start = currentChunk * chunkSize;
                    var end = Math.min(start + chunkSize, file.size);
                    var blob = file.slice(start, end);

                    var formData = new FormData();
                    formData.append('file', blob);
                    formData.append('index', currentChunk);
                    formData.append('total_chunks', totalChunks);
                    formData.append('identifier', identifier);
                    formData.append('filename', file.name);
                    formData.append('_token', '{{ csrf_token() }}');

                    currentXhr = $.ajax({
                        url: "{{ route(Auth::user()->rol[0]->slug . '.medias.upload-chunk') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.completed) {
                                $('#videoProgressBar').css('width', '100%').removeClass('progress-bar-striped progress-bar-animated').addClass('bg-success');
                                $('#videoProgressPercent').text('100%');
                                $('#videoUploadStatus').text('Subida completada con éxito.');
                                $('#ruta').val(response.filename);
                                $('#btnSubmitForm').prop('disabled', false);
                                isUploading = false;
                            } else {
                                currentChunk++;
                                var percent = Math.round((currentChunk / totalChunks) * 100);
                                $('#videoProgressBar').css('width', percent + '%');
                                $('#videoProgressPercent').text(percent + '%');
                                $('#videoUploadStatus').text('Subiendo fragmento ' + currentChunk + ' de ' + totalChunks + '...');
                                sendNextChunk();
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#videoProgressBar').removeClass('bg-primary').addClass('bg-danger');
                            $('#videoUploadStatus').text('Error en la carga: ' + (xhr.responseJSON?.error || 'Error de conexión'));
                            $('#btnSubmitForm').prop('disabled', false);
                            isUploading = false;
                        }
                    });
                }

                sendNextChunk();
            }

            $('#btnCancelVideoUpload').on('click', function() {
                if (currentXhr) {
                    currentXhr.abort();
                }
                isUploading = false;
                $('#btnSubmitForm').prop('disabled', false);
                $('#videoProgressContainer').hide();
                $('#videoFileInput').val('');
                $('#ruta').val('');
            });

            //cambios en el select de multimedia
            function setSelect(){
                var seleccion = $( "select#tipo option:checked" ).val();
                if(seleccion == "imagen"){
                    $( "#rowImagen" ).show();
                    $( "#rowRuta" ).hide();
                    $( "#rowArchivo" ).hide();
                    $("#rowVideoUpload").hide();
                }
                if(seleccion == "archivo"){
                    $( "#rowArchivo" ).show();
                    $( "#rowRuta" ).hide();
                    $( "#rowImagen" ).hide();
                    $("#rowVideoUpload").hide();
                }
                if(seleccion == "liga"){
                    $( "#rowRuta" ).show();
                    $( "#rowImagen" ).hide();
                    $( "#rowArchivo" ).hide();
                    $("#rowVideoUpload").hide();
                }
                if(seleccion == "video"){
                    var isFile = $('#videoFileRadio').is(':checked');
                    if (isFile) {
                        $("#rowRuta").hide();
                        $("#videoDropZone").show();
                    } else {
                        $("#rowRuta").show();
                        $("#videoDropZone").hide();
                    }
                    $( "#rowImagen" ).hide();
                    $( "#rowArchivo" ).hide();
                    $("#rowVideoUpload").show();
                }
            }
            $( "#tipo" ).change(function() {
                setSelect();
            });
            setSelect();
        } );
    </script>
@endsection
