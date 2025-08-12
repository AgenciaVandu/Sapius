@component('emails.message')
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background:#f9f9f9; border-radius:8px; font-family:Arial, sans-serif; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
    <tr>
        <td style="padding:32px 24px 16px 24px; text-align:center;">
            <h2 style="color:#2d3748; margin-bottom:8px;">¡Hola {{ $datos['name_alumno'] }}!</h2>
            <p style="color:#4a5568; font-size:16px; margin:0;">
                Has adquirido exitosamente el curso. <br>¡Gracias por tu compra!
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 24px;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:6px;">
                <tr>
                    <td style="padding:16px 0;">
                        <strong style="color:#2b6cb0;">Curso:</strong>
                        <span style="color:#2d3748;">{{ $datos['identificador'] }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 0; border-bottom:1px solid #e2e8f0;">
                        <strong style="color:#2b6cb0;">Monto:</strong>
                        <span style="color:#2d3748;">${{ number_format($datos['precio'], 2) }} MXN</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 0; border-bottom:1px solid #e2e8f0;">
                        <strong style="color:#2b6cb0;">Id Transaccion:</strong>
                        <span style="color:#2d3748;">{{ $datos['id_carge'] }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:16px 24px 32px 24px; text-align:center;">
            <p style="color:#718096; font-size:14px; margin:0;">
                {{-- Ha solicitado la ficha de pago por concepto de "Inscripción de Nuevo Ingreso" adjunto a este correo. --}}
                Si tienes alguna duda, responde a este correo y te ayudaremos.<br>
                <strong style="color:#e53e3e;">Nota:</strong> Debes esperar la aprobación de tu pago para poder acceder al contenido del curso.
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
