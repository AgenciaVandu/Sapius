<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>3D FlipBook</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        .solid-container {
            height: 100vh;
        }

        #warning-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #052443;
            color: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            display: none;
        }

        #warning-overlay img {
            max-width: 200px;
            margin-bottom: 20px;
        }

        #warning-overlay p {
            font-size: 20px;
        }

        /* IMPEDIR impresión mostrando solo advertencia */
        @media print {
            body * {
                visibility: hidden !important;
            }

            #warning-overlay,
            #warning-overlay * {
                visibility: visible !important;
            }

            #warning-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: #052443 !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                color: white !important;
                font-size: 24px;
            }
        }
    </style>
</head>


<body>
    <div class="solid-container"></div>

    <div id="warning-overlay">
        <img src="https://sapius.com.mx/img/logo-sapius.png" alt="Logo Sapius">
        <p>Está prohibido tomar capturas de pantalla o imprimir este contenido.<br>No se permite plagiar esta obra.</p>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <script src="{{ asset('js/three.min.js') }}"></script>
    <script src="{{ asset('js/pdf.min.js') }}"></script>
    <script src="{{ asset('js/3dflipbook.js') }}"></script>

    <script>
        const showWarning = () => {
            const warning = document.getElementById('warning-overlay');
            warning.style.display = 'flex';
            setTimeout(() => {
                warning.style.display = 'none';
            }, 5000);
        };

        document.addEventListener('keydown', function(e) {
            const forbiddenKeyCodes = [16, 17, 18, 44, 51, 52, 91, 93];

            if (forbiddenKeyCodes.includes(e.keyCode || e.which)) {
                showWarning();
            }

            // Bloquear impresión (Ctrl+P o Cmd+P)
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'p') {
                e.preventDefault();
                showWarning();
            }

            // Detectar PrintScreen
            if (e.key === 'PrintScreen') {
                e.preventDefault();
                navigator.clipboard.writeText('');
                showWarning();
            }

            // Detectar combinaciones comunes en Mac (Cmd+Shift+4, Cmd+Shift+3)
            if ((e.metaKey && e.shiftKey && (e.key === '3' || e.key === '4'))) {
                showWarning();
            }
        });

        // Detectar intento de abrir herramientas de desarrollo (opcional)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C'))) {
                e.preventDefault();
                showWarning();
            }
        });

        var options = {
            pdf: '{{ $file }}',
            pageCallback: function(n) {
                return {
                    type: 'html',
                    src: 'example/' + n + '.html',
                    interactive: true
                };
            },
            controlsProps: {
                downloadURL: '{{ asset('templates/FoxitPdfSdk.pdf') }}',
                actions: {
                    cmdSmartPan: {
                        enabled: false,
                        enabledInNarrow: false
                    },
                    cmdPan: {
                        enabled: false,
                        enabledInNarrow: false
                    },
                    cmdZoomIn: {
                        enabled: false,
                        enabledInNarrow: false
                    },
                    cmdZoomOut: {
                        enabled: false,
                        enabledInNarrow: false
                    },
                    cmdShare: {
                        enabled: false,
                        enabledInNarrow: false
                    },
                    cmdPrint: {
                        enabled: false,
                        enabledInNarrow: false
                    },
                    cmdSave: {
                        enabled: false,
                        enabledInNarrow: false
                    },
                    cmdFastBackward: {
                        enabled: false,
                        enabledInNarrow: false
                    },
                },
            },
            template: {
                html: '{{ asset('templates/default-book-view.html') }}',
                styles: ['{{ asset('css/black-book-view.css') }}'],
                links: [{
                    rel: 'stylesheet',
                    href: '{{ asset('css/font-awesome.min.css') }}'
                }],
                script: '{{ asset('js/default-book-view.js') }}',
                printStyle: undefined,
                sounds: {
                    startFlip: '{{ asset('sounds/start-flip.mp3') }}',
                    endFlip: '{{ asset('sounds/end-flip.mp3') }}'
                }
            },
            pdfLinks: {
                handler: function(type, destination) {
                    return true;
                }
            },
            autoNavigation: {
                urlParam: 'fb3d-page',
                navigates: 1,
                pageN: undefined
            },
            bookStyle: 'volume'
        };

        var book = $('.solid-container').FlipBook(options);
    </script>
</body>

</html>
