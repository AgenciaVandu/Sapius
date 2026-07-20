@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Configurar Campos: {{ $material->titulo }}</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}" class="text-muted">Cursos</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Editor</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <button id="save-btn" class="btn btn-success btn-rounded shadow">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .pdf-viewer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #525659;
            padding: 20px;
            border-radius: 8px;
            max-height: 75vh;
            overflow-y: auto;
            position: relative;
        }
        .pdf-page-wrapper {
            position: relative;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            background-color: #fff;
            border-radius: 4px;
        }
        .pdf-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: auto;
            cursor: crosshair;
        }
        .interactive-field {
            position: absolute;
            border: 2px dashed #007bff;
            background-color: rgba(0, 123, 255, 0.15);
            cursor: move;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            box-sizing: border-box;
            border-radius: 4px;
            min-width: 50px;
            min-height: 25px;
        }
        .interactive-field.selected {
            border: 2px solid #28a745;
            background-color: rgba(40, 167, 69, 0.2);
        }
        .field-label {
            font-size: 11px;
            font-weight: bold;
            color: #004085;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            padding: 2px;
            pointer-events: none;
        }
        .resize-handle {
            position: absolute;
            width: 8px;
            height: 8px;
            background-color: #007bff;
            right: -4px;
            bottom: -4px;
            cursor: se-resize;
            border-radius: 50%;
        }
        .editor-sidebar {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- PDF Rendering Panel -->
        <div class="col-lg-8">
            <div id="loading-spinner" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando PDF...</span>
                </div>
                <h5 class="mt-2 text-muted">Cargando páginas del documento...</h5>
            </div>
            <div class="pdf-viewer-container d-none" id="viewer-container">
                <!-- Rendered PDF pages will go here -->
            </div>
        </div>

        <!-- Editor Controls Sidebar -->
        <div class="col-lg-4">
            <div class="editor-sidebar">
                <h4 class="text-dark font-weight-medium">Configuración de Campos</h4>
                <p class="text-muted small mb-4">Haz doble clic sobre cualquier parte del PDF para agregar un campo de texto editable. Selecciónalo para configurarlo.</p>
                
                <div id="field-details-panel" class="d-none">
                    <div class="card bg-light border">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="fas fa-cog mr-2"></i>Editar Campo</h5>
                            
                            <div class="form-group">
                                <label for="field-name" class="font-weight-bold">Nombre del Campo</label>
                                <input type="text" id="field-name" class="form-control form-control-sm" placeholder="Ej. nombre_alumno">
                                <small class="text-muted">Evita espacios y caracteres especiales.</small>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="field-width">Ancho (px)</label>
                                        <input type="number" id="field-width" class="form-control form-control-sm" min="30">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="field-height">Alto (px)</label>
                                        <input type="number" id="field-height" class="form-control form-control-sm" min="15">
                                    </div>
                                </div>
                            </div>

                            <button id="delete-field-btn" class="btn btn-sm btn-block btn-danger mt-2">
                                <i class="fas fa-trash mr-1"></i> Eliminar Campo
                            </button>
                        </div>
                    </div>
                </div>

                <div id="no-selection-message" class="text-center py-4 bg-light border rounded">
                    <span class="text-muted"><i class="fas fa-mouse-pointer fa-2x mb-2 d-block"></i>Selecciona un campo para ver sus detalles</span>
                </div>

                <hr class="my-4">

                <div>
                    <h5 class="text-dark">Instrucciones</h5>
                    <ul class="pl-3 text-muted small">
                        <li class="mb-2"><strong>Doble Clic:</strong> Añade un campo interactivo en la posición del puntero.</li>
                        <li class="mb-2"><strong>Arrastrar:</strong> Mueve el campo a la posición deseada.</li>
                        <li class="mb-2"><strong>Modificar Tamaño:</strong> Usa el círculo en la esquina inferior derecha del campo seleccionado para redimensionar.</li>
                        <li class="mb-2"><strong>Guardar:</strong> Presiona "Guardar Cambios" para registrar el diseño.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <!-- Include PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        // Set worker source
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        const pdfUrl = "{{ route('admin.material-pdfs.download-raw', $material->id) }}";
        let fields = @json($material->fields_config ?? []);
        if (!Array.isArray(fields)) {
            fields = [];
        }
        let selectedFieldId = null;
        let pdfDoc = null;

        // Load Document
        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('loading-spinner').classList.add('d-none');
            document.getElementById('viewer-container').classList.remove('d-none');
            
            // Render all pages
            const promises = [];
            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                promises.push(renderPage(pageNum));
            }

            Promise.all(promises).then(() => {
                // Once all pages are rendered, draw existing fields
                drawExistingFields();
            });
        });

        function renderPage(pageNum) {
            return pdfDoc.getPage(pageNum).then(function(page) {
                const viewport = page.getViewport({ scale: 1.2 });
                const wrapper = document.createElement('div');
                wrapper.className = 'pdf-page-wrapper';
                wrapper.id = 'page-wrapper-' + pageNum;
                wrapper.style.width = viewport.width + 'px';
                wrapper.style.height = viewport.height + 'px';

                const canvas = document.createElement('canvas');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                wrapper.appendChild(canvas);

                const overlay = document.createElement('div');
                overlay.className = 'pdf-overlay';
                overlay.id = 'page-overlay-' + pageNum;
                overlay.dataset.pageNum = pageNum;
                overlay.addEventListener('dblclick', handlePageDoubleClick);
                wrapper.appendChild(overlay);

                document.getElementById('viewer-container').appendChild(wrapper);

                const renderContext = {
                    canvasContext: canvas.getContext('2d'),
                    viewport: viewport
                };
                return page.render(renderContext).promise;
            });
        }

        function handlePageDoubleClick(e) {
            if (e.target !== this) return; // Ignore if clicked on a field

            const pageNum = parseInt(this.dataset.pageNum);
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const fieldId = 'field_' + Date.now();
            const newField = {
                id: fieldId,
                name: 'campo_' + (fields.length + 1),
                page: pageNum,
                x: x - 60, // Center roughly on cursor
                y: y - 15,
                width: 120,
                height: 30
            };

            fields.push(newField);
            createFieldDOM(newField);
            selectField(fieldId);
        }

        function createFieldDOM(field) {
            const overlay = document.getElementById('page-overlay-' + field.page);
            if (!overlay) return;

            const element = document.createElement('div');
            element.className = 'interactive-field';
            element.id = field.id;
            element.style.left = field.x + 'px';
            element.style.top = field.y + 'px';
            element.style.width = field.width + 'px';
            element.style.height = field.height + 'px';

            const label = document.createElement('span');
            label.className = 'field-label';
            label.innerText = field.name;
            element.appendChild(label);

            const resizeHandle = document.createElement('div');
            resizeHandle.className = 'resize-handle';
            element.appendChild(resizeHandle);

            // Click to select
            element.addEventListener('mousedown', function(e) {
                if (e.target === resizeHandle) {
                    initResize(e, field.id);
                } else {
                    initDrag(e, field.id);
                }
                selectField(field.id);
            });

            overlay.appendChild(element);
        }

        function drawExistingFields() {
            fields.forEach(field => {
                createFieldDOM(field);
            });
        }

        // Drag Handler
        function initDrag(e, fieldId) {
            e.preventDefault();
            const element = document.getElementById(fieldId);
            const field = fields.find(f => f.id === fieldId);
            if (!element || !field) return;

            const startX = e.clientX;
            const startY = e.clientY;
            const origX = parseFloat(element.style.left);
            const origY = parseFloat(element.style.top);

            function onMouseMove(e) {
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;

                let newX = origX + dx;
                let newY = origY + dy;

                // Restrict boundaries to page
                const parent = element.parentElement;
                const maxX = parent.clientWidth - field.width;
                const maxY = parent.clientHeight - field.height;

                newX = Math.max(0, Math.min(newX, maxX));
                newY = Math.max(0, Math.min(newY, maxY));

                element.style.left = newX + 'px';
                element.style.top = newY + 'px';

                field.x = newX;
                field.y = newY;
            }

            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            }

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        }

        // Resize Handler
        function initResize(e, fieldId) {
            e.preventDefault();
            e.stopPropagation();
            const element = document.getElementById(fieldId);
            const field = fields.find(f => f.id === fieldId);
            if (!element || !field) return;

            const startX = e.clientX;
            const startY = e.clientY;
            const origWidth = parseFloat(element.style.width);
            const origHeight = parseFloat(element.style.height);

            function onMouseMove(e) {
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;

                let newW = origWidth + dx;
                let newH = origHeight + dy;

                newW = Math.max(40, newW);
                newH = Math.max(15, newH);

                element.style.width = newW + 'px';
                element.style.height = newH + 'px';

                field.width = newW;
                field.height = newH;

                document.getElementById('field-width').value = Math.round(newW);
                document.getElementById('field-height').value = Math.round(newH);
            }

            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            }

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        }

        function selectField(fieldId) {
            document.querySelectorAll('.interactive-field').forEach(el => {
                el.classList.remove('selected');
            });

            selectedFieldId = fieldId;
            const element = document.getElementById(fieldId);
            if (element) {
                element.classList.add('selected');
            }

            const field = fields.find(f => f.id === fieldId);
            if (field) {
                document.getElementById('no-selection-message').classList.add('d-none');
                document.getElementById('field-details-panel').classList.remove('d-none');

                document.getElementById('field-name').value = field.name;
                document.getElementById('field-width').value = Math.round(field.width);
                document.getElementById('field-height').value = Math.round(field.height);
            }
        }

        // Sidebar input events
        document.getElementById('field-name').addEventListener('input', function() {
            if (!selectedFieldId) return;
            const val = this.value.replace(/[^a-zA-Z0-9_]/g, '');
            this.value = val;

            const field = fields.find(f => f.id === selectedFieldId);
            if (field) {
                field.name = val;
                const element = document.getElementById(selectedFieldId);
                if (element) {
                    const label = element.querySelector('.field-label');
                    if (label) label.innerText = val;
                }
            }
        });

        document.getElementById('field-width').addEventListener('input', function() {
            if (!selectedFieldId) return;
            const val = Math.max(30, parseInt(this.value) || 30);
            const field = fields.find(f => f.id === selectedFieldId);
            if (field) {
                field.width = val;
                const element = document.getElementById(selectedFieldId);
                if (element) element.style.width = val + 'px';
            }
        });

        document.getElementById('field-height').addEventListener('input', function() {
            if (!selectedFieldId) return;
            const val = Math.max(15, parseInt(this.value) || 15);
            const field = fields.find(f => f.id === selectedFieldId);
            if (field) {
                field.height = val;
                const element = document.getElementById(selectedFieldId);
                if (element) element.style.height = val + 'px';
            }
        });

        document.getElementById('delete-field-btn').addEventListener('click', function() {
            if (!selectedFieldId) return;
            const element = document.getElementById(selectedFieldId);
            if (element) element.remove();

            fields = fields.filter(f => f.id !== selectedFieldId);
            selectedFieldId = null;

            document.getElementById('field-details-panel').classList.add('d-none');
            document.getElementById('no-selection-message').classList.remove('d-none');
        });

        // Save layout
        document.getElementById('save-btn').addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

            $.ajax({
                url: "{{ route('admin.material-pdfs.save-config', $material->id) }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    fields_config: fields
                },
                success: function(response) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save mr-1"></i> Guardar Cambios';
                    alert(response.message);
                },
                error: function(xhr) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save mr-1"></i> Guardar Cambios';
                    alert("Error al guardar la configuración.");
                    console.error(xhr);
                }
            });
        });
    </script>
@endsection
