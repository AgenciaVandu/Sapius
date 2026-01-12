<!DOCTYPE html>
<html>

<head>
    <title>¡Cuenta Desbloqueada!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
        }

        .button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>¡Tu cuenta ha sido reactivada!</h1>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $user->nombre }}</strong>,</p>
            <p>Nos complace informarte que tu cuenta en Sapius ha sido desbloqueada exitosamente.</p>
            <p>Se han restablecido tus permisos y ahora puedes acceder nuevamente a todo el contenido y funcionalidades
                de la plataforma.</p>
            <a href="{{ route('login') }}" class="button">Acceder a mi cuenta</a>
        </div>
        <div class="footer">
            <p>Si tienes alguna duda, por favor contacta a soporte técnico.</p>
            <p>&copy; {{ date('Y') }} Sapius. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>
