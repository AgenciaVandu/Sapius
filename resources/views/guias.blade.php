<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        .solid-container {
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="solid-container">

    </div>

</body>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/html2canvas.min.js') }}"></script>
<script src="{{ asset('js/three.min.js') }}"></script>
<script src="{{ asset('js/pdf.min.js') }}"></script>
<script src="{{ asset('js/3dflipbook.min.js') }}"></script>

<!-- To create 3D FlipBook from PDF -->
{{-- <script type="text/javascript">
    $('.solid-container').FlipBook({
        pdf: '{{ asset('templates/FoxitPdfSdk.pdf') }}',
        controlsProps: {
            downloadURL: 'books/pdf/FoxitPdfSdk.pdf',
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
                cmdFullScreen: {
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
        }
    });
</script> --}}


<script>
    var options = {
        pdf: '{{ $file }}', // you should use this property or pageCallback and pages to specify your book
        pageCallback: function(n) { // this function has to return source description for FlipBook page
            // for image sources
            var imageDescription = {
                type: 'image',
                src: 'example/' + n + '.jpg',
                interactive: false
            };
            // for html sources
            var htmlDescription = {
                type: 'html',
                src: 'example/' + n + '.html',
                interactive: true // or false - if your page interact with the user then use true
            };
            // for blank page
            var blankDescription = {
                type: 'blank'
            };
            return htmlDescription; // or imageDescription or blankDescription
        },
        controlsProps: { // set of optional properties that allow to customize 3D FlipBook control
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
        /* propertiesCallback: function(props) {
            props.page.depth /= 2;
            props.cover.binderTexture = 'exampleTexture.jpg';
            props.cssLayersLoader = function(n, clb) {
                clb([{
                    css: '.heading {margin-top: 200px;background-color: red;}',
                    html: '<h1 class="heading">Hello</h1>',
                    js: function(jContainer,
                    props) {
                        console.log('init');
                        return { // set of callbacks
                            hide: function() {
                                console.log('hide');
                            },
                            hidden: function() {
                                console.log('hidden');
                            },
                            show: function() {
                                console.log('show');
                            },
                            shown: function() {
                                console.log('shown');
                            },
                            dispose: function() {
                                console.log('dispose');
                            }
                        };
                    }
                }]);
            };
            return props;
        }, */
        template: { // by means this property you can choose appropriate skin
            html: '{{ asset('templates/default-book-view.html') }}',
            styles: [
                '{{ asset('css/black-book-view.css') }}' // or one of white-book-view.css, short-white-book-view.css, shart-black-book-view.css
            ],
            links: [{
                rel: 'stylesheet',
                href: '{{ asset('css/font-awesome.min.css') }}'
            }],
            script: '{{ asset('js/default-book-view.js') }}',
            printStyle: undefined, // or you can set your stylesheet for printing ('print-style.css')
            sounds: {
                startFlip: '{{ asset('sounds/start-flip.mp3') }}',
                endFlip: '{{ asset('sounds/end-flip.mp3') }}'
            }
        },
        pdfLinks: {
            handler: function(type,
            destination) { // type: 'internal' (destination - page number), 'external' (destination - url)
                return true; // true - prevent default handler, false - call default handler
            }
        },
        autoNavigation: {
            urlParam: 'fb3d-page', // url query param name for deep linking: http://example.com?fb3d-page=10
            navigates: 1, // number of instances that will be navigated automatically,
            pageN: undefined // auto open page pageN
        },
        bookStyle: 'volume', // volume, flat or volume-paddings
        /* activateFullScreen: false, // activate fullscreen if it is possible (API can only be initiated by a user gesture) */
        ready: function(scene) { // optional function - this function executes when loading is complete

        },
        error: function(e) { // optional function for notification about errors

        }
    };
    var book = $('.solid-container').FlipBook(options);
</script>

</html>
