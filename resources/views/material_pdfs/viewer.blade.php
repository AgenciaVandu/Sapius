@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Material: {{ $material->titulo }}</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('alumno.home') }}" class="text-muted">Inicio</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">{{ $material->titulo }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right btn-group">
                    <button id="save-answers-btn" class="btn btn-primary btn-rounded shadow mr-2">
                        <i class="fas fa-save mr-1"></i> Guardar Respuestas
                    </button>
                    <button id="download-resolved-btn" class="btn btn-success btn-rounded shadow">
                        <i class="fas fa-download mr-1"></i> Descargar Resuelto
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
            max-height: 72vh;
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
            pointer-events: none;
        }
        .interactive-input {
            position: absolute;
            pointer-events: auto;
            background-color: rgba(255, 235, 186, 0.4);
            border: 1px solid #ffc107;
            border-radius: 2px;
            padding: 1px 3px;
            font-size: 11px;
            font-family: inherit;
            color: #495057;
            box-sizing: border-box;
            outline: none;
            transition: all 0.2s ease-in-out;
        }
        .interactive-input:focus {
            background-color: #ffffff;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }
        .pdf-highlight {
            position: absolute;
            background-color: rgba(255, 255, 0, 0.4);
            border-radius: 2px;
            pointer-events: none;
            z-index: 5;
        }
        /* Active highlighter mode */
        .highlighter-mode-active .pdf-overlay {
            pointer-events: auto !important;
            cursor: crosshair;
        }
        .highlighter-mode-active .interactive-input {
            pointer-events: none !important;
        }
        .highlighter-mode-active .pdf-highlight {
            pointer-events: auto !important;
            cursor: pointer;
        }
        .highlighter-mode-active .pdf-highlight:hover {
            background-color: rgba(220, 53, 69, 0.5) !important;
        }
        .field-color-selector {
            transition: opacity 0.2s ease-in-out;
            opacity: 0.3;
        }
        .pdf-page-wrapper:hover .field-color-selector, .field-color-selector:hover {
            opacity: 1;
        }
        .field-color-dot {
            border: 1px solid #fff;
            box-shadow: 0 0 0 1px #d1d5db;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
        }
        .field-color-dot:hover {
            transform: scale(1.2);
        }
        .field-color-dot.active {
            transform: scale(1.3);
            box-shadow: 0 0 0 1.5px #007bff !important;
            border-color: #fff !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="mb-2 d-flex justify-content-between align-items-center bg-white p-2 rounded shadow-sm">
                <span class="text-dark font-weight-medium"><i class="fas fa-file-pdf text-danger mr-1"></i> Visualización del Documento</span>
                <div class="d-flex align-items-center">

                    <button id="highlighter-btn" class="btn btn-xs btn-outline-warning mr-2 shadow-sm font-weight-bold">
                        <i class="fas fa-highlighter mr-1"></i> Modo Marcatexto
                    </button>
                    <button id="clear-highlights-btn" class="btn btn-xs btn-outline-danger mr-3 shadow-sm">
                        <i class="fas fa-eraser mr-1"></i> Limpiar Resaltados
                    </button>
                    <div class="btn-group">
                        <button id="zoom-out-btn" class="btn btn-xs btn-outline-secondary"><i class="fas fa-search-minus"></i> Zoom -</button>
                        <button id="zoom-in-btn" class="btn btn-xs btn-outline-secondary"><i class="fas fa-search-plus"></i> Zoom +</button>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif

            <div id="loading-spinner" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando material...</span>
                </div>
                <h5 class="mt-2 text-muted">Cargando PDF y campos del material...</h5>
            </div>

            <div class="pdf-viewer-container d-none" id="viewer-container">
                <!-- Rendered PDF pages will go here -->
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <!-- Include PDF.js and pdf-lib libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        const pdfUrl = "{{ route('alumno.material-pdfs.download-raw', $material->id) }}";
        const fields = @json($material->fields_config ?? []);
        const savedAnswersRaw = @json($respuesta->respuestas ?? []);
        
        let savedAnswers = {};
        let savedHighlights = [];
        let selectedColor = '#0038a8'; // Default to notebook blue

        if (savedAnswersRaw) {
            if (savedAnswersRaw.inputs !== undefined) {
                savedAnswers = savedAnswersRaw.inputs || {};
                savedHighlights = savedAnswersRaw.highlights || [];
                selectedColor = savedAnswersRaw.color || '#0038a8';
            } else {
                // Retrocompatibilidad
                savedAnswers = savedAnswersRaw;
            }
        }

        let highlights = [...savedHighlights];
        let isHighlighterMode = false;
        let pdfDoc = null;
        let currentScale = 1.2;

        // Load Document
        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('loading-spinner').classList.add('d-none');
            document.getElementById('viewer-container').classList.remove('d-none');
            
            renderAllPages();
        });

        function renderAllPages() {
            // Keep track of values of inputs before clearing them to restore them
            const currentValues = getAnswersMap();

            const container = document.getElementById('viewer-container');
            container.innerHTML = ''; // Clear existing wrappers

            const promises = [];
            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                promises.push(renderPage(pageNum));
            }

            Promise.all(promises).then(() => {
                overlayInputs(currentValues);
                renderHighlights();
            });
        }

        let isDrawing = false;
        let startX, startY;
        let activePageOverlay = null;
        let currentHighlightEl = null;

        function initHighlighterDrawing(overlay, pageNum) {
            overlay.addEventListener('mousedown', function(e) {
                if (!isHighlighterMode) return;
                if (e.target !== overlay) return; // Only start drawing if clicked directly on overlay

                isDrawing = true;
                activePageOverlay = overlay;
                const rect = overlay.getBoundingClientRect();
                startX = e.clientX - rect.left;
                startY = e.clientY - rect.top;

                currentHighlightEl = document.createElement('div');
                currentHighlightEl.className = 'pdf-highlight';
                currentHighlightEl.style.left = startX + 'px';
                currentHighlightEl.style.top = startY + 'px';
                currentHighlightEl.style.width = '0px';
                currentHighlightEl.style.height = '0px';
                overlay.appendChild(currentHighlightEl);
            });
        }

        // Global mouse move and up handlers for highlighter drawing
        document.addEventListener('mousemove', function(e) {
            if (!isDrawing || !activePageOverlay || !currentHighlightEl) return;
            const rect = activePageOverlay.getBoundingClientRect();
            const currentX = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
            const currentY = Math.max(0, Math.min(e.clientY - rect.top, rect.height));

            const x = Math.min(startX, currentX);
            const y = Math.min(startY, currentY);
            const width = Math.abs(startX - currentX);
            const height = Math.abs(startY - currentY);

            currentHighlightEl.style.left = x + 'px';
            currentHighlightEl.style.top = y + 'px';
            currentHighlightEl.style.width = width + 'px';
            currentHighlightEl.style.height = height + 'px';
        });

        document.addEventListener('mouseup', function(e) {
            if (!isDrawing) return;
            isDrawing = false;

            if (currentHighlightEl) {
                const width = parseFloat(currentHighlightEl.style.width);
                const height = parseFloat(currentHighlightEl.style.height);

                // Ignore tiny clicks
                if (width > 5 && height > 5) {
                    const pageNum = parseInt(activePageOverlay.dataset.pageNum);
                    const highlightId = 'hl_' + Date.now();
                    currentHighlightEl.id = highlightId;
                    
                    const localHighlightEl = currentHighlightEl;
                    localHighlightEl.addEventListener('click', function(ev) {
                        if (isHighlighterMode) {
                            ev.stopPropagation();
                            localHighlightEl.remove();
                            highlights = highlights.filter(hl => hl.id !== highlightId);
                        }
                    });

                    // Save coordinates relative to scale = 1.0
                    highlights.push({
                        id: highlightId,
                        page: pageNum,
                        x: parseFloat(currentHighlightEl.style.left) / currentScale,
                        y: parseFloat(currentHighlightEl.style.top) / currentScale,
                        width: width / currentScale,
                        height: height / currentScale
                    });
                } else {
                    currentHighlightEl.remove();
                }
            }

            currentHighlightEl = null;
            activePageOverlay = null;
        });

        function renderPage(pageNum) {
            return pdfDoc.getPage(pageNum).then(function(page) {
                const viewport = page.getViewport({ scale: currentScale });

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
                wrapper.appendChild(overlay);

                // Initialize highlighter events
                initHighlighterDrawing(overlay, pageNum);

                document.getElementById('viewer-container').appendChild(wrapper);

                const renderContext = {
                    canvasContext: canvas.getContext('2d'),
                    viewport: viewport
                };
                return page.render(renderContext).promise;
            });
        }

        function overlayInputs(currentValues = null) {
            fields.forEach(field => {
                const overlay = document.getElementById('page-overlay-' + field.page);
                if (!overlay) return;

                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'interactive-input';
                input.id = field.name;
                
                // Scale input dimensions to match current viewer zoom scale
                input.style.left = (parseFloat(field.x) * currentScale) + 'px';
                input.style.top = (parseFloat(field.y) * currentScale) + 'px';
                input.style.width = (parseFloat(field.width) * currentScale) + 'px';
                input.style.height = (parseFloat(field.height) * currentScale) + 'px';

                // Determine default/saved value and color
                let val = '';
                let col = '#0038a8'; // default color is blue

                if (currentValues && currentValues[field.name] !== undefined) {
                    const data = currentValues[field.name];
                    if (data && typeof data === 'object') {
                        val = data.value || '';
                        col = data.color || '#0038a8';
                    } else {
                        val = data || '';
                    }
                } else if (savedAnswers && savedAnswers[field.name] !== undefined) {
                    const data = savedAnswers[field.name];
                    if (data && typeof data === 'object') {
                        val = data.value || '';
                        col = data.color || '#0038a8';
                    } else {
                        val = data || '';
                    }
                }

                input.value = val;
                input.style.color = col;
                input.dataset.color = col;

                // Create individual color selector next to the field
                const colorSelector = document.createElement('div');
                colorSelector.className = 'field-color-selector';
                colorSelector.style.position = 'absolute';
                // Position it 4px to the right of the input box, vertically centered
                colorSelector.style.left = ((parseFloat(field.x) + parseFloat(field.width)) * currentScale + 4) + 'px';
                colorSelector.style.top = (parseFloat(field.y) * currentScale + (parseFloat(field.height) * currentScale - 10) / 2) + 'px';
                colorSelector.style.display = 'flex';
                colorSelector.style.alignItems = 'center';
                colorSelector.style.gap = '3px';
                colorSelector.style.pointerEvents = 'auto';
                colorSelector.style.zIndex = '10';

                // Black dot
                const blackDot = document.createElement('button');
                blackDot.type = 'button';
                blackDot.className = 'btn p-0 rounded-circle field-color-dot' + (col === '#000000' ? ' active' : '');
                blackDot.style.width = '10px';
                blackDot.style.height = '10px';
                blackDot.style.backgroundColor = '#000000';
                blackDot.title = 'Negro';

                // Blue dot
                const blueDot = document.createElement('button');
                blueDot.type = 'button';
                blueDot.className = 'btn p-0 rounded-circle field-color-dot' + (col === '#0038a8' ? ' active' : '');
                blueDot.style.width = '10px';
                blueDot.style.height = '10px';
                blueDot.style.backgroundColor = '#0038a8';
                blueDot.title = 'Azul Pluma';

                blackDot.addEventListener('click', (e) => {
                    e.stopPropagation();
                    input.style.color = '#000000';
                    input.dataset.color = '#000000';
                    blackDot.classList.add('active');
                    blueDot.classList.remove('active');
                });

                blueDot.addEventListener('click', (e) => {
                    e.stopPropagation();
                    input.style.color = '#0038a8';
                    input.dataset.color = '#0038a8';
                    blueDot.classList.add('active');
                    blackDot.classList.remove('active');
                });

                colorSelector.appendChild(blackDot);
                colorSelector.appendChild(blueDot);

                overlay.appendChild(input);
                overlay.appendChild(colorSelector);
            });
        }

        function renderHighlights() {
            // Remove existing highlights DOM
            document.querySelectorAll('.pdf-highlight').forEach(el => el.remove());

            highlights.forEach(hl => {
                const overlay = document.getElementById('page-overlay-' + hl.page);
                if (!overlay) return;

                const element = document.createElement('div');
                element.className = 'pdf-highlight';
                element.id = hl.id;
                element.style.left = (hl.x * currentScale) + 'px';
                element.style.top = (hl.y * currentScale) + 'px';
                element.style.width = (hl.width * currentScale) + 'px';
                element.style.height = (hl.height * currentScale) + 'px';

                element.addEventListener('click', function(ev) {
                    if (isHighlighterMode) {
                        ev.stopPropagation();
                        element.remove();
                        highlights = highlights.filter(h => h.id !== hl.id);
                    }
                });

                overlay.appendChild(element);
            });
        }

        function getAnswersMap() {
            const answers = {};
            fields.forEach(field => {
                const input = document.getElementById(field.name);
                if (input) {
                    answers[field.name] = {
                        value: input.value,
                        color: input.dataset.color || '#0038a8'
                    };
                }
            });
            return answers;
        }

        // Toggle Highlighter Mode
        document.getElementById('highlighter-btn').addEventListener('click', function() {
            isHighlighterMode = !isHighlighterMode;
            const container = document.getElementById('viewer-container');
            if (isHighlighterMode) {
                container.classList.add('highlighter-mode-active');
                this.classList.remove('btn-outline-warning');
                this.classList.add('btn-warning');
            } else {
                container.classList.remove('highlighter-mode-active');
                this.classList.remove('btn-warning');
                this.classList.add('btn-outline-warning');
            }
        });

        // Clear All Highlights
        document.getElementById('clear-highlights-btn').addEventListener('click', function() {
            if (confirm('¿Estás seguro de que deseas limpiar todos los resaltados?')) {
                highlights = [];
                renderHighlights();
            }
        });

        // Zoom handlers
        document.getElementById('zoom-in-btn').addEventListener('click', function() {
            if (currentScale < 3.0) {
                currentScale += 0.2;
                renderAllPages();
            }
        });

        document.getElementById('zoom-out-btn').addEventListener('click', function() {
            if (currentScale > 0.6) {
                currentScale -= 0.2;
                renderAllPages();
            }
        });

        // Helper to convert hex to RGB for pdf-lib (normalized 0.0 to 1.0)
        function hexToRgb(hex) {
            if (!hex) return { r: 0.0, g: 0.0, b: 0.0 };
            const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
            hex = hex.replace(shorthandRegex, (m, r, g, b) => r + r + g + g + b + b);
            const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16) / 255,
                g: parseInt(result[2], 16) / 255,
                b: parseInt(result[3], 16) / 255
            } : { r: 0.0, g: 0.0, b: 0.0 };
        }

        // Save Answers AJAX
        document.getElementById('save-answers-btn').addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

            const answers = getAnswersMap();
            const payload = {
                inputs: answers,
                highlights: highlights,
                color: selectedColor
            };

            $.ajax({
                url: "{{ route('alumno.material-pdfs.save-answers', $material->id) }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    respuestas: payload
                },
                success: function(response) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save mr-1"></i> Guardar Respuestas';
                    alert(response.message);
                },
                error: function(xhr) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save mr-1"></i> Guardar Respuestas';
                    alert("Error al guardar tus respuestas.");
                    console.error(xhr);
                }
            });
        });
        // Download PDF with answers burned into it using pdf-lib
        document.getElementById('download-resolved-btn').addEventListener('click', async function() {
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando...';

            try {
                // Fetch original PDF bytes
                const existingPdfBytes = await fetch(pdfUrl).then(res => res.arrayBuffer());
                
                // Load into pdf-lib
                const { PDFDocument, rgb, StandardFonts } = PDFLib;
                const pdfDoc = await PDFDocument.load(existingPdfBytes);
                const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);
                const pages = pdfDoc.getPages();
                
                const answers = getAnswersMap();

                // Draw Highlights first so text goes on top
                highlights.forEach(hl => {
                    const pageIndex = hl.page - 1;
                    if (pageIndex < 0 || pageIndex >= pages.length) return;

                    const page = pages[pageIndex];
                    const hlX = parseFloat(hl.x);
                    const hlY = parseFloat(hl.y);
                    const hlW = parseFloat(hl.width);
                    const hlH = parseFloat(hl.height);

                    // y-coordinate in pdf-lib is from bottom up
                    const pdfY = page.getHeight() - (hlY + hlH);

                    page.drawRectangle({
                        x: hlX,
                        y: pdfY,
                        width: hlW,
                        height: hlH,
                        color: rgb(1.0, 1.0, 0.0), // Yellow
                        opacity: 0.35
                    });
                });

                // Draw Text fields
                fields.forEach(field => {
                    const ans = answers[field.name];
                    if (!ans) return;

                    const text = typeof ans === 'object' ? (ans.value || '') : (ans || '');
                    if (!text.trim()) return;

                    const pageIndex = field.page - 1;
                    if (pageIndex < 0 || pageIndex >= pages.length) return;

                    const page = pages[pageIndex];

                    const fieldX = parseFloat(field.x);
                    const fieldY = parseFloat(field.y);
                    const fieldW = parseFloat(field.width);
                    const fieldH = parseFloat(field.height);

                    // Since DB coordinates are stored at scale=1.0, they map 1-to-1 to original PDF points.
                    // Map coordinates to PDF space (0,0 is bottom-left in PDF)
                    const pdfX = fieldX;
                    const pdfY = page.getHeight() - (fieldY + (fieldH * 0.72));
                    const pdfFontSize = fieldH * 0.48;

                    const colorHex = typeof ans === 'object' ? (ans.color || '#0038a8') : '#0038a8';
                    const textColors = hexToRgb(colorHex);

                    // Draw text on page
                    page.drawText(text, {
                        x: pdfX + 3, // subtle left padding
                        y: pdfY,
                        size: pdfFontSize,
                        font: helveticaFont,
                        color: rgb(textColors.r, textColors.g, textColors.b)
                    });
                });

                // Serialize PDF to bytes
                const pdfBytes = await pdfDoc.save();

                // Trigger file download
                const blob = new Blob([pdfBytes], { type: "application/pdf" });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "{{ $material->titulo }}_resuelto.pdf";
                link.click();

            } catch (err) {
                console.error(err);
                alert("Ocurrió un error al generar el PDF con tus respuestas: " + err.message);
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-download mr-1"></i> Descargar Resuelto';
            }
        });
    </script>
@endsection
