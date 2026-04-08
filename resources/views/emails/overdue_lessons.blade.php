@component('emails.message')

<div style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <h2 style="color: #2D3748; font-size: 24px; font-weight: 700; margin-bottom: 16px;">Hola {{ $student->nombre }},</h2>
    
    <p style="color: #4A5568; font-size: 16px; line-height: 1.6; margin-bottom: 24px;">
        Hemos notado que te has atrasado en el contenido de tu curso. Mantener un ritmo constante es clave para completar tu formación con éxito.
    </p>

    <h3 style="color: #718096; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; border-bottom: 1px solid #E2E8F0; padding-bottom: 8px;">
        Lecciones pendientes de completar:
    </h3>

    @foreach ($overdueLessons as $lesson)
    <div style="background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; padding: 20px; margin-bottom: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="padding-bottom: 8px;">
                    <span style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">{{ $lesson['modulo'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 12px;">
                    <div style="color: #2D3748; font-size: 18px; font-weight: 700; line-height: 1.3;">{{ $lesson['titulo'] }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="width: 50%;">
                                <div style="color: #718096; font-size: 13px;">Fecha Límite:</div>
                                <div style="color: #4A5568; font-size: 14px; font-weight: 600;">{{ $lesson['fecha_final'] }}</div>
                            </td>
                            <td style="width: 50%; text-align: right; vertical-align: bottom;">
                                @if($lesson['is_expired'] ?? false)
                                    <span style="display: inline-block; background-color: #FFF5F5; color: #C53030; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 9999px; border: 1px solid #FEB2B2;">
                                        CERRADA
                                    </span>
                                @else
                                    <span style="display: inline-block; background-color: #FFFBEB; color: #B7791F; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 9999px; border: 1px solid #FCEEB8;">
                                        ATRASADA
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    @endforeach

    <p style="color: #4A5568; font-size: 16px; line-height: 1.6; margin-top: 32px; margin-bottom: 24px;">
        Te animamos a retomar tus clases lo antes posible para no perder el hilo del aprendizaje.
    </p>

    <div style="text-align: center; margin-bottom: 40px;">
        <a href="{{ route('alumno.home') }}" style="display: inline-block; background-color: #2B6CB0; color: #FFFFFF; font-size: 16px; font-weight: 700; text-decoration: none; padding: 14px 32px; border-radius: 8px; box-shadow: 0 4px 6px rgba(43, 108, 176, 0.2);">
            Ir a mis cursos
        </a>
    </div>

    <p style="color: #718096; font-size: 14px; border-top: 1px solid #E2E8F0; padding-top: 24px;">
        Si tienes alguna duda o necesitas apoyo técnico, no dudes en contactarnos.<br>
        Atentamente,<br>
        <strong>El equipo de {{ config('app.name') }}</strong>
    </p>
</div>

<style>
    @media only screen and (max-width: 480px) {
        h2 { font-size: 20px !important; }
        .card-content { padding: 16px !important; }
        div[style*="font-size: 18px"] { font-size: 16px !important; }
    }
</style>

@endcomponent
