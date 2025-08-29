<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Visualizador de archivos Sapius</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        header {
            background-color: #052443;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* <-- cambio aquí */
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header img {
            max-height: 60px;
        }

        .back-button {
            background-color: #ed6a5a;
            color: #ffffff;
            border: 1px solid #ed6a5a;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .back-button:hover {
            background-color: #f0f0f0;
            border: 1px solid #f0f0f0;
            color: #052443;
        }

        .solid-container {
            background-color: #ffffff;
            height: calc(100vh - 80px);
            /* padding: 10px; */
            box-sizing: border-box;
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

    <header>
        <img src="https://sapius.com.mx/img/logo-sapius.png" alt="Logo Sapius">
        <button onclick="history.back()" class="back-button">Regresar al sitio de cursos</button>
    </header>


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
                        enabled: false
                    },
                    cmdPan: {
                        enabled: false
                    },
                    cmdZoomIn: {
                        enabled: true
                    },
                    cmdZoomOut: {
                        enabled: true
                    },
                    cmdShare: {
                        enabled: false
                    },
                    cmdPrint: {
                        enabled: false
                    },
                    cmdSave: {
                        enabled: false
                    },
                    cmdFastBackward: {
                        enabled: false
                    }
                }
            },
            template: {
                html: '{{ asset('templates/default-book-view.html') }}',
                styles: ['{{ asset('css/short-black-book-view.css') }}'],
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


    <!-- Script que define y expone la función de advertencia -->
    <script>
        function showWarning() {
            const warning = document.getElementById('warning-overlay');
            warning.style.display = 'flex';
            setTimeout(() => {
                warning.style.display = 'none';
            }, 5000);
        }

        // Exponer la función globalmente para que pueda ser llamada desde otros contextos
        window.mostrarAdvertenciaCaptura = showWarning;
    </script>

    <!-- Script que detecta teclas y llama a la función de advertencia -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const advertencia = window.parent?.mostrarAdvertenciaCaptura || window.mostrarAdvertenciaCaptura;

            const forbiddenKeyCodes = [16, 17, 18, 44, 91, 93]; // Shift, Ctrl, Alt, PrintScreen, Cmd

            function handleKeyEvent(e, tipo) {
                console.log(`[${tipo}] Tecla: ${e.key} | Código: ${e.keyCode || e.which}`);

                if (forbiddenKeyCodes.includes(e.keyCode || e.which)) {
                    if (typeof advertencia === 'function') advertencia();
                }

                // Ctrl+P o Cmd+P
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'p') {
                    e.preventDefault();
                    if (typeof advertencia === 'function') advertencia();
                }

                // PrintScreen
                if (e.key === 'PrintScreen' || e.keyCode === 44) {
                    e.preventDefault();
                    try {
                        navigator.clipboard.writeText('');
                    } catch (err) {}
                    if (typeof advertencia === 'function') advertencia();
                }

                // Cmd+Shift+3 o 4 (MacOS screenshots)
                if (e.metaKey && e.shiftKey && (e.key === '3' || e.key === '4')) {
                    if (typeof advertencia === 'function') advertencia();
                }

                // F12 o Ctrl+Shift+I/J/C
                if (
                    e.key === 'F12' ||
                    (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key.toUpperCase()))
                ) {
                    e.preventDefault();
                    if (typeof advertencia === 'function') advertencia();
                }
            }

            document.addEventListener('keydown', (e) => handleKeyEvent(e, 'keydown'));
            document.addEventListener('keyup', (e) => handleKeyEvent(e, 'keyup'));
            document.addEventListener('keypress', (e) => handleKeyEvent(e, 'keypress'));

            // Bloqueo del clic derecho (menú contextual)
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                if (typeof advertencia === 'function') advertencia();
                console.log('[contextmenu] Clic derecho bloqueado');
            });
        });
    </script>

</body>

</html>
