<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <p id="strike-msg" style="font-weight: bold; font-size: 1.2em; color: #ffeb3b;"></p>
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
            let strikes = 0;
            const maxStrikes = 3;

            function registerStrike(reason) {
                const msg = document.getElementById('strike-msg');
                const warning = document.getElementById('warning-overlay');

                // Call backend first to register and get accurate count
                fetch('{{ route('alumno.register-strike') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(`Strike registered: ${reason}`, data);

                        if (data.status === 'blocked') {
                            msg.textContent =
                                "Has excedido el límite de advertencias. Tu cuenta será bloqueada.";
                            warning.style.display = 'flex';
                            setTimeout(() => {
                                window.location.href = "{{ route('alumno.locked') }}";
                            }, 2000);
                        } else if (data.status === 'warning') {
                            strikes = data.strikes; // Sync local strikes with DB
                            msg.textContent = `Advertencia ${strikes} de ${maxStrikes}`;
                            warning.style.display = 'flex';

                            setTimeout(() => {
                                if (strikes < maxStrikes) warning.style.display = 'none';
                            }, 4000);
                        }
                    })
                    .catch(err => console.error(err));
            }

            // Expose for external calls if needed
            window.mostrarAdvertenciaCaptura = () => registerStrike("External call");

            function handleKeyEvent(e) {
                // Windows PrintScreen
                if (e.key === 'PrintScreen' || e.keyCode === 44) {
                    e.preventDefault();
                    if (document.getElementById('warning-overlay').style.display !== 'flex') registerStrike(
                        "PrintScreen");
                    return;
                }

                const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
                const isCtrlOfTheOS = isMac ? e.metaKey : e.ctrlKey;
                const isShift = e.shiftKey;

                // Mac Screenshots: Cmd+Shift+3, 4, 5
                if (isMac && e.metaKey && e.shiftKey && ['3', '4', '5'].includes(e.key)) {
                    e.preventDefault();
                    registerStrike("Mac Screenshot");
                    return;
                }

                // Windows Snipping Tool: Win+Shift+S (Hard to intercept Win key in some browsers, but Shift+S with Win might trigger)
                // Note: Win key (Meta) often not interceptable.

                // Block Ctrl/Cmd + P (Print), S (Save), C (Copy)
                if (isCtrlOfTheOS && ['p', 's', 'c', 'u'].includes(e.key.toLowerCase())) {
                    e.preventDefault();
                    registerStrike(`Shortcut ${e.key}`);
                    return;
                }

                // DevTools F12
                if (e.key === 'F12') {
                    e.preventDefault();
                    registerStrike("F12");
                    return;
                }

                // DevTools Ctrl+Shift+I/J/C
                if (isCtrlOfTheOS && isShift && ['i', 'j', 'c'].includes(e.key.toLowerCase())) {
                    e.preventDefault();
                    registerStrike("DevTools");
                    return;
                }
            }

            document.addEventListener('keydown', handleKeyEvent);
            document.addEventListener('keyup', (e) => {
                if (e.key === 'PrintScreen' || e.keyCode === 44) {
                    e.preventDefault();
                    // Avoid double counting if keydown caught it
                }
            });

            // Block Right Click
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                registerStrike("Right Click");
            });
        });
    </script>

</body>

</html>
