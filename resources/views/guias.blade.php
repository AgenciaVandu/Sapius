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
<script type="text/javascript">
    $('.solid-container').FlipBook({
        pdf: '{{ asset('test-book-2.pdf') }}',
        controlsProps: {
            download: {
                enabled: false
            },
            print: {
                enabled: false
            },
            share: {
                enabled: false
            },
            zoomIn: {
                enabled: false
            },
            zoomOut: {
                enabled: false
            },
            fullscreen: {
                enabled: false
            }
        }
    });
</script>

</html>
