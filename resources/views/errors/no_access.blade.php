<!DOCTYPE html>
<html lang="es">
<head>
    <title>Acceso Restringido</title>
    <script>
        window.onload = function() {
            if (navigator.maxTouchPoints > 0 || 'ontouchstart' in window) {
                document.body.innerHTML = "<h1>Acceso Restringido</h1><p>No puedes acceder desde un móvil o tablet.</p>";
            }
        };
    </script>
</head>
<body>
    <h1>Acceso Restringido</h1>
    <p>No puedes acceder desde un móvil o tablet.</p>
</body>
</html>
