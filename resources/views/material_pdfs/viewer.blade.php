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
                    @if($material->allow_download)
                    <button id="download-resolved-btn" class="btn btn-success btn-rounded shadow">
                        <i class="fas fa-download mr-1"></i> Descargar Resuelto
                    </button>
                    @endif
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
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        .pdf-page-wrapper {
            position: relative;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            background-color: #fff;
            border-radius: 4px;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
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
            padding: 2px 4px;
            font-size: 11px;
            line-height: 1.3;
            font-family: inherit;
            color: #495057;
            box-sizing: border-box;
            outline: none;
            transition: all 0.2s ease-in-out;
            resize: none;
            white-space: pre-wrap;
            word-break: break-word;
            overflow-y: auto;
            user-select: text !important;
            -webkit-user-select: text !important;
            -moz-user-select: text !important;
            -ms-user-select: text !important;
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

            <div class="alert alert-info border-info show shadow-sm mb-3" role="alert" style="border-radius: 8px;">
                <h5 class="alert-heading font-weight-bold text-info mb-1"><i class="fas fa-info-circle mr-1"></i> Nota Importante sobre la Impresión y Campos de Texto</h5>
                <p class="mb-0 small text-dark">
                    La impresión o descarga del documento puede salir incompleta debido a que el texto introducido sobrepasa el tamaño visible del campo delimitador. Es normal que pase esto, por lo que te recomendamos ajustar tus respuestas a los límites visuales de cada recuadro.
                </p>
            </div>

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

        const pdfUrl = "{{ route('alumno.material-pdfs.download-raw', $material->id) }}?stream=true";
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

                const input = document.createElement('textarea');
                input.className = 'interactive-input';
                input.id = field.name;
                
                // Scale input dimensions to match current viewer zoom scale
                const fieldHeightPt = parseFloat(field.height);
                input.style.left = (parseFloat(field.x) * currentScale) + 'px';
                input.style.top = (parseFloat(field.y) * currentScale) + 'px';
                input.style.width = (parseFloat(field.width) * currentScale) + 'px';
                input.style.height = (fieldHeightPt * currentScale) + 'px';

                // Adjust font size dynamically if field height is small vs tall
                if (fieldHeightPt < 30) {
                    input.style.fontSize = Math.min(13, Math.max(10, fieldHeightPt * 0.45 * currentScale)) + 'px';
                } else {
                    input.style.fontSize = Math.min(15, Math.max(11, 11 * currentScale)) + 'px';
                }

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
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                contentType: "application/json",
                data: JSON.stringify({
                    respuestas: payload
                }),
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
        const downloadResolvedBtn = document.getElementById('download-resolved-btn');
        if (downloadResolvedBtn) {
            downloadResolvedBtn.addEventListener('click', async function() {
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

                    // Helper to split text into lines based on \n and word wrapping for pdf-lib
                    function getWrappedLines(textStr, font, fontSize, maxWidth) {
                        const rawParagraphs = textStr.split(/\r?\n/);
                        const resultLines = [];

                        rawParagraphs.forEach(para => {
                            if (!para.trim()) {
                                resultLines.push('');
                                return;
                            }
                            const words = para.split(' ');
                            let currentLine = '';

                            words.forEach(word => {
                                const testLine = currentLine ? (currentLine + ' ' + word) : word;
                                let testWidth = 0;
                                try {
                                    testWidth = font.widthOfTextAtSize(testLine, fontSize);
                                } catch (e) {
                                    testWidth = testLine.length * (fontSize * 0.5);
                                }
                                if (testWidth <= maxWidth || !currentLine) {
                                    currentLine = testLine;
                                } else {
                                    resultLines.push(currentLine);
                                    currentLine = word;
                                }
                            });
                            if (currentLine) {
                                resultLines.push(currentLine);
                            }
                        });

                        return resultLines;
                    }

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

                        // Determine font size and line height according to box height
                        let pdfFontSize = 10;
                        if (fieldH < 30) {
                            pdfFontSize = Math.min(12, Math.max(9, fieldH * 0.48));
                        } else {
                            pdfFontSize = Math.min(11, Math.max(9, 10));
                        }
                        const lineHeight = pdfFontSize * 1.25;

                        const colorHex = typeof ans === 'object' ? (ans.color || '#0038a8') : '#0038a8';
                        const textColors = hexToRgb(colorHex);

                        const paddingX = 3;
                        const paddingY = 3;
                        const maxTextWidth = Math.max(10, fieldW - (paddingX * 2));
                        const pdfX = fieldX + paddingX;

                        // pdf-lib y=0 is bottom left. Top edge of box in pdf-lib y-coordinates:
                        const boxTopY = page.getHeight() - fieldY;
                        const boxBottomY = page.getHeight() - (fieldY + fieldH);

                        // Get wrapped lines
                        const lines = getWrappedLines(text, helveticaFont, pdfFontSize, maxTextWidth);

                        // Draw each line from top to bottom
                        let currentY = boxTopY - paddingY - pdfFontSize;

                        lines.forEach(line => {
                            if (currentY >= boxBottomY - 2) {
                                if (line !== '') {
                                    try {
                                        page.drawText(line, {
                                            x: pdfX,
                                            y: currentY,
                                            size: pdfFontSize,
                                            font: helveticaFont,
                                            color: rgb(textColors.r, textColors.g, textColors.b)
                                        });
                                    } catch (err) {
                                        console.warn('Error drawing text line in PDF:', err);
                                    }
                                }
                            }
                            currentY -= lineHeight;
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
        }

        // ----------------------------------------------------
        // SISTEMA ANTI-PLAGIO Y PROTECCIÓN DE CONTENIDO (CTRL BLOCK)
        // ----------------------------------------------------
        let strikeCount = 0;
        const maxStrikes = 3;

        // Modal para alertar de Strike / Plagio
        const modalHtml = `
        <div class="modal fade" id="plagiarismWarningModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-danger shadow-lg">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-exclamation-triangle mr-2"></i> ADVERTENCIA DE SEGURIDAD Y PLAGIO</h5>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="fas fa-ban text-danger mb-3" style="font-size: 3.5rem;"></i>
                        <h4 class="text-dark font-weight-bold">Acción No Permitida</h4>
                        <p class="text-muted mt-2" id="plagiarism-modal-message">
                            Está prohibido el uso de atajos de teclado (Ctrl/Cmd), copiar o capturar contenido en esta sección.
                        </p>
                        <div class="alert alert-warning mb-0 font-weight-bold">
                            Strike acumulado: <span id="strike-counter-num" class="badge badge-danger badge-pill px-3 py-1 font-16">1</span> / ${maxStrikes}
                        </div>
                        <p class="text-xs text-danger mt-2 mb-0">Al acumular 3 strikes o detectar reincidencia, su cuenta podrá ser bloqueada o suspendida automáticamente.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger font-weight-bold px-4 btn-rounded" data-dismiss="modal">Entendido y Acepto</button>
                    </div>
                </div>
            </div>
        </div>`;
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        function triggerStrike(reason) {
            strikeCount++;
            document.getElementById('strike-counter-num').innerText = strikeCount;
            document.getElementById('plagiarism-modal-message').innerText = reason || 'El uso de atajos de teclado (Ctrl/Cmd) o la copia de contenido está prohibido.';
            
            // Ocultar contenido del PDF al activar strike
            hidePdfContainer();

            if (window.$ && $('#plagiarismWarningModal').length) {
                $('#plagiarismWarningModal').modal('show');
            } else {
                alert(`[ADVERTENCIA ANTI-PLAGIO]\nStrike ${strikeCount}/${maxStrikes}: ${reason}`);
                showPdfContainer();
            }

            if (strikeCount >= maxStrikes) {
                setTimeout(() => {
                    alert("Has alcanzado el límite de advertencias por uso indebido/plagio. Tu sesión se cerrará por motivos de seguridad.");
                    window.location.href = "{{ route('alumno.home') }}";
                }, 500);
            }
        }

        // Funciones para ocultar/mostrar el contenido del PDF
        function hidePdfContainer() {
            const container = document.getElementById('viewer-container');
            if (container) {
                container.style.filter = 'blur(25px)';
                container.style.opacity = '0.05';
                container.style.pointerEvents = 'none';
            }
        }

        function showPdfContainer() {
            const container = document.getElementById('viewer-container');
            if (container) {
                container.style.filter = 'none';
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        }

        // Al cerrar el modal de advertencia, volver a mostrar el PDF
        $(document).on('click', '#plagiarismWarningModal button', function() {
            if (strikeCount < maxStrikes) {
                showPdfContainer();
            }
        });

        // Ocultar PDF inmediatamente si la ventana pierde el foco (cambio de pestaña, captura externa o Alt+Tab)
        window.addEventListener('blur', function() {
            hidePdfContainer();
        });

        // Restaurar visor al volver a enfocar la pestaña
        window.addEventListener('focus', function() {
            showPdfContainer();
        });

        // Bloquear menú contextual (click derecho)
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            triggerStrike("El menú contextual (clic derecho) está desactivado para prevenir la copia no autorizada.");
        });

        function isPageInput(target) {
            if (!target) return false;
            const el = target.nodeType === 3 ? target.parentElement : target;
            if (!el || !el.tagName) return false;
            const tag = el.tagName.toUpperCase();
            if (tag === 'INPUT' || tag === 'TEXTAREA' || el.isContentEditable) return true;
            if (el.closest && el.closest('input, textarea, [contenteditable="true"], .interactive-input, .f3d-page-number')) return true;
            return false;
        }

        function isAllowedStrictKey(e) {
            if (/^[0-9]$/.test(e.key)) return true;
            if (e.code && e.code.startsWith('Numpad') && /^[0-9]$/.test(e.key)) return true;
            if (['Backspace', 'Delete', 'Enter'].includes(e.key)) return true;
            return false;
        }

        // Bloquear atajos con tecla Control (Ctrl) o Command (Cmd en Mac)
        document.addEventListener('keydown', function(e) {
            if (isPageInput(e.target)) {
                if (isAllowedStrictKey(e)) {
                    return true;
                }
                e.preventDefault();
                e.stopPropagation();
                return false;
            }

            const isCtrlOrCmd = e.ctrlKey || e.metaKey;
            
            // Bloqueo total si se presiona la tecla Ctrl sola o en combinación
            if (e.key === 'Control' || e.key === 'Meta' || isCtrlOrCmd) {
                const keyLower = e.key.toLowerCase();
                const forbiddenKeys = ['c', 'v', 'x', 'a', 'p', 's', 'u', 'i', 'j'];

                if (e.key === 'Control' || e.key === 'Meta' || forbiddenKeys.includes(keyLower)) {
                    e.preventDefault();
                    e.stopPropagation();
                    triggerStrike("Está completamente bloqueado el uso de la tecla Ctrl / Cmd y atajos de copia o inspección.");
                    return false;
                }
            }

            // Bloquear F12 o herramientas de desarrollador
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.key === 'J' || e.key === 'j'))) {
                e.preventDefault();
                triggerStrike("Acceso a Herramientas de Desarrollador bloqueado.");
                return false;
            }
        });

        // Prevenir copiar / cortar directo
        document.addEventListener('copy', function(e) {
            e.preventDefault();
            triggerStrike("Intentaste copiar contenido del documento.");
        });
        document.addEventListener('cut', function(e) {
            e.preventDefault();
            triggerStrike("Intentaste cortar contenido del documento.");
        });
    </script>
@endsection
