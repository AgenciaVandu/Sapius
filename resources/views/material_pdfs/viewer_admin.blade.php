@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Revisión de respuestas: {{ $material->titulo }}</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}" class="text-muted">Cursos</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Revisar Respuestas de {{ $alumno->nombre }} {{ $alumno->apellidos }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right btn-group">
                    <a href="javascript:history.back()" class="btn btn-secondary btn-rounded shadow mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
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
            background-color: rgba(230, 243, 255, 0.4);
            border: 1px solid #17a2b8;
            border-radius: 2px;
            padding: 2px 4px;
            font-size: 11px;
            line-height: 1.3;
            font-family: inherit;
            color: #495057;
            box-sizing: border-box;
            outline: none;
            resize: none;
            white-space: pre-wrap;
            word-break: break-word;
            overflow-y: auto;
        }
        .pdf-highlight {
            position: absolute;
            background-color: rgba(255, 255, 0, 0.4);
            border-radius: 2px;
            pointer-events: none;
            z-index: 5;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="mb-2 d-flex justify-content-between align-items-center bg-white p-2 rounded shadow-sm">
                <span class="text-dark font-weight-medium">
                    <i class="fas fa-user-edit text-info mr-1"></i> Respuestas del alumno: <strong>{{ $alumno->nombre }} {{ $alumno->apellidos }}</strong> ({{ $alumno->email }})
                </span>
                <div class="btn-group">
                    <button id="zoom-out-btn" class="btn btn-xs btn-outline-secondary"><i class="fas fa-search-minus"></i> Zoom -</button>
                    <button id="zoom-in-btn" class="btn btn-xs btn-outline-secondary"><i class="fas fa-search-plus"></i> Zoom +</button>
                </div>
            </div>

            <div id="loading-spinner" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando material...</span>
                </div>
                <h5 class="mt-2 text-muted">Cargando PDF y respuestas del alumno...</h5>
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

        const pdfUrl = "{{ route('admin.material-pdfs.download-raw', $material->id) }}";
        const fields = @json($material->fields_config ?? []);
        const savedAnswersRaw = @json($respuesta->respuestas ?? []);
        
        let savedAnswers = {};
        let savedHighlights = [];
        let selectedColor = '#0038a8';

        if (savedAnswersRaw) {
            if (savedAnswersRaw.inputs !== undefined) {
                savedAnswers = savedAnswersRaw.inputs || {};
                savedHighlights = savedAnswersRaw.highlights || [];
                selectedColor = savedAnswersRaw.color || '#0038a8';
            } else {
                savedAnswers = savedAnswersRaw;
            }
        }

        let highlights = [...savedHighlights];
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
            const container = document.getElementById('viewer-container');
            container.innerHTML = ''; // Clear existing wrappers

            const promises = [];
            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                promises.push(renderPage(pageNum));
            }

            Promise.all(promises).then(() => {
                overlayInputs();
                renderHighlights();
            });
        }

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

                document.getElementById('viewer-container').appendChild(wrapper);

                const renderContext = {
                    canvasContext: canvas.getContext('2d'),
                    viewport: viewport
                };
                return page.render(renderContext).promise;
            });
        }

        function overlayInputs() {
            fields.forEach(field => {
                const overlay = document.getElementById('page-overlay-' + field.page);
                if (!overlay) return;

                const input = document.createElement('textarea');
                input.className = 'interactive-input';
                input.id = field.name;
                input.readOnly = true; // Solo lectura para revisión
                
                // Scale input dimensions to match current viewer zoom scale
                const fieldHeightPt = parseFloat(field.height);
                input.style.left = (parseFloat(field.x) * currentScale) + 'px';
                input.style.top = (parseFloat(field.y) * currentScale) + 'px';
                input.style.width = (parseFloat(field.width) * currentScale) + 'px';
                input.style.height = (fieldHeightPt * currentScale) + 'px';

                // Adjust font size dynamically
                if (fieldHeightPt < 30) {
                    input.style.fontSize = Math.min(13, Math.max(10, fieldHeightPt * 0.45 * currentScale)) + 'px';
                } else {
                    input.style.fontSize = Math.min(15, Math.max(11, 11 * currentScale)) + 'px';
                }

                // Determine saved value and color
                let val = '';
                let col = '#0038a8';

                if (savedAnswers && savedAnswers[field.name] !== undefined) {
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

                overlay.appendChild(input);
            });
        }

        function renderHighlights() {
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
                        color: input.style.color || '#0038a8'
                    };
                }
            });
            return answers;
        }

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

                    const boxTopY = page.getHeight() - fieldY;
                    const boxBottomY = page.getHeight() - (fieldY + fieldH);

                    const lines = getWrappedLines(text, helveticaFont, pdfFontSize, maxTextWidth);

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
                link.download = "{{ $material->titulo }}_resuelto_{{ $alumno->nombre }}.pdf";
                link.click();

            } catch (err) {
                console.error(err);
                alert("Ocurrió un error al generar el PDF: " + err.message);
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-download mr-1"></i> Descargar Resuelto';
            }
        });
    </script>
@endsection
