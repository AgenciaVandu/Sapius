@component('emails.message')
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background:#f9f9f9; border-radius:8px; font-family:Arial, sans-serif; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
    <tr>
        <td style="padding:20px 24px 0 24px; text-align:center;">
            <span style="display:inline-flex; align-items:center; justify-content:center; background:#FFF3CD; color:#856404; border-radius:8px; width:64px; height:64px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <svg width="36" height="36" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="img">
                    <path d="M12 2l10 18H2L12 2z" fill="#856404"/>
                    <rect x="11" y="8" width="2" height="6" rx="1" fill="#ffffff"/>
                    <rect x="11" y="15" width="2" height="2" rx="1" fill="#ffffff"/>
                </svg>
            </span>
        </td>
    </tr>

    <tr>
        <td style="padding:32px 24px 16px 24px; text-align:center;">
            <h2 style="color:#2d3748; margin-bottom:8px;">¡Hola {{ $usuario->getNombreCompletoAttribute() ?? 'usuario' }}!</h2>
            <p style="color:#4a5568; font-size:16px; margin:0;">
                Te recordamos que para completar y validar tu perfil necesitamos que subas los documentos solicitados.
            </p>
        </td>
    </tr>

    <tr>
        <td style="padding:12px 24px;">
            @php
                $faltantes = [];
                if (empty($usuario->documento_identificacion)) {
                    $faltantes[] = 'Documento de identidad';
                }
                if (empty($usuario->pase_ingreso)) {
                    $faltantes[] = 'Pase de ingreso / ficha de pago';
                }
            @endphp

            @if (count($faltantes) > 0)
                <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:6px; border:1px solid #ffe9e9;">
                    <tr>
                        <td style="padding:16px;">
                            <strong style="color:#c53030;">Acción requerida:</strong>
                            <p style="color:#2d3748; margin:8px 0 0 0;">
                                Para validar tu perfil necesitamos que completes la siguiente información:
                            </p>

                            <ul style="color:#2d3748; margin:12px 0 0 20px; padding:0; list-style: disc;">
                                @foreach ($faltantes as $item)
                                    <li style="margin-bottom:6px;">{{ $item }}</li>
                                @endforeach
                            </ul>

                            <p style="margin:12px 0 0 0;">
                                <a href="{{ url('https://sapius.com.mx/alumno') }}" style="display:inline-block; background:#2b6cb0; color:#ffffff; padding:10px 16px; border-radius:6px; text-decoration:none;">
                                    Subir documentos ahora
                                </a>
                            </p>

                            <p style="color:#718096; font-size:13px; margin:12px 0 0 0;">
                                Una vez subidos, revisaremos y te notificaremos cuando tu perfil esté validado. Si ya subiste alguno de estos archivos y consideras que hay un error, responde a este correo.
                            </p>
                        </td>
                    </tr>
                </table>
            @else
                <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:6px;">
                    <tr>
                        <td style="padding:16px 0;">
                            <strong style="color:#2b6cb0;">Estado de documentos:</strong>
                            <span style="color:#2d3748;">Completos. Tu perfil está validado. Gracias por enviar la documentación.</span>
                        </td>
                    </tr>
                </table>
            @endif
        </td>
    </tr>

    <tr>
        <td style="padding:16px 24px 32px 24px; text-align:center;">
            <p style="color:#718096; font-size:14px; margin:0;">
                Recuerda: tu perfil será validado una vez que los documentos sean revisados. Si necesitas ayuda, responde a este correo.
            </p>
        </td>
    </tr>
</table>
<style>
@media only screen and (max-width: 600px) {
    table[width="100%"] {
        width: 100% !important;
    }
    td {
        padding: 12px !important;
    }
    h2 {
        font-size: 20px !important;
    }
    p, span, strong {
        font-size: 15px !important;
    }
}
</style>

@endcomponent
