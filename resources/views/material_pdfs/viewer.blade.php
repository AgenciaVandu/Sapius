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
            max-height: 78vh;
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
            border-radius: 3px;
            padding: 2px 5px;
            font-size: 13px;
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
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
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
        const savedAnswers = @json($respuesta->respuestas ?? []);
        let pdfDoc = null;
        const pageViewports = {}; // Cache viewports for scaling

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
                // Overlay text inputs
                overlayInputs();
            });
        });

        function renderPage(pageNum) {
            return pdfDoc.getPage(pageNum).then(function(page) {
                const viewport = page.getViewport({ scale: 1.2 });
                pageViewports[pageNum] = viewport; // Save viewport for coordinate scaling

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

                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'interactive-input';
                input.id = field.name;
                input.style.left = field.x + 'px';
                input.style.top = field.y + 'px';
                input.style.width = field.width + 'px';
                input.style.height = field.height + 'px';

                // Pre-fill answer if exists
                if (savedAnswers && savedAnswers[field.name]) {
                    input.value = savedAnswers[field.name];
                }

                overlay.appendChild(input);
            });
        }

        function getAnswersMap() {
            const answers = {};
            fields.forEach(field => {
                const input = document.getElementById(field.name);
                if (input) {
                    answers[field.name] = input.value;
                }
            });
            return answers;
        }

        // Save Answers AJAX
        document.getElementById('save-answers-btn').addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

            const answers = getAnswersMap();

            $.ajax({
                url: "{{ route('alumno.material-pdfs.save-answers', $material->id) }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    respuestas: answers
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

                fields.forEach(field => {
                    const text = answers[field.name] || '';
                    if (!text.trim()) return;

                    const pageIndex = field.page - 1;
                    if (pageIndex < 0 || pageIndex >= pages.length) return;

                    const page = pages[pageIndex];
                    const viewport = pageViewports[field.page];
                    if (!viewport) return;

                    const fieldX = parseFloat(field.x);
                    const fieldY = parseFloat(field.y);
                    const fieldW = parseFloat(field.width);
                    const fieldH = parseFloat(field.height);

                    // Calculate scale factor between viewport (HTML space) and original PDF size
                    const scaleFactorX = page.getWidth() / parseFloat(viewport.width);
                    const scaleFactorY = page.getHeight() / parseFloat(viewport.height);

                    // Map coordinates to PDF space (0,0 is bottom-left in PDF)
                    const pdfX = fieldX * scaleFactorX;
                    const pdfY = page.getHeight() - ((fieldY + (fieldH * 0.72)) * scaleFactorY);
                    const pdfFontSize = (fieldH * 0.48) * scaleFactorY;

                    // Draw text on page
                    page.drawText(text, {
                        x: pdfX + (4 * scaleFactorX), // subtle padding
                        y: pdfY,
                        size: pdfFontSize,
                        font: helveticaFont,
                        color: rgb(0.1, 0.1, 0.4) // Navy/blue color for student answers
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
