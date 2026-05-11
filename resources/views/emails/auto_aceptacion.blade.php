@component('emails.message')
<div style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:inherit;background-color:rgb(255,254,248)">
    <div style="line-height:inherit;min-width:320px;max-width:650px;word-break:break-word;margin:0px auto;background-color:transparent">
        <div style="line-height:inherit;border-collapse:collapse;display:table;width:650px;background-color:transparent">
            <div style="line-height:inherit;min-width:320px;max-width:650px;display:table-cell;vertical-align:top;width:650px">
                <div style="line-height:inherit;width:650px">
                    <div style="line-height:inherit;border-width:0px;border-style:solid;border-color:transparent;padding:15px 0px 0px">
                        <div style="line-height:1.2;color:rgb(9,47,74);font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;padding:30px 10px 15px">
                            <div style="line-height:1.2;font-size:12px">
                                <p style="line-height:1.2;text-align:center;font-size:34px;word-break:break-word;margin:0px">
                                    <span style="line-height:inherit"><strong style="line-height:inherit">Curso {{ $inscripcion->CursoProgramado->identificador }}</strong></span>
                                </p>
                                <br>
                                <p style="line-height:1.2;text-align:center;font-size:34px;word-break:break-word;margin:0px">
                                    <span style="line-height:inherit"><strong style="line-height:inherit">Modalidad online</strong></span>
                                </p>
                            </div>
                        </div>
                        <div style="line-height:1.2;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;padding:30px">
                            <div style="line-height:1.2;font-size:12px">
                                <p style="line-height:1.2;word-break:break-word;text-align:center;margin:0px">
                                    <span style="line-height:inherit"><strong style="line-height:inherit"><span style="line-height:inherit;font-size:24px;background-color:rgb(255,255,255)"><font color="#cc0000">Nosotros sabemos el enorme esfuerzo y compromiso dedicado a la preparación de tu examen {{ $inscripcion->CursoProgramado->identificador }}.</font></span></strong></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:inherit;background-image:url('https://d1oco4z2z1fhwp.cloudfront.net/templates/default/591/bg2.png');background-position:50% 0%;background-repeat:repeat;background-color:rgb(194,71,14)">
    <div style="line-height:inherit;min-width:320px;max-width:650px;word-break:break-word;margin:0px auto;background-color:rgb(255,255,255)">
        <div style="line-height:inherit;border-collapse:collapse;display:table;width:650px">
            <div style="line-height:inherit;min-width:320px;max-width:650px;display:table-cell;vertical-align:top;width:650px">
                <div style="line-height:inherit;width:650px">
                    <div style="line-height:inherit;border-width:0px;border-style:solid;border-color:transparent;padding:10px 0px 0px">
                        <div style="line-height:1.5;padding:25px 60px 25px 45px">
                            <div style="line-height:1.5">
                                <div style="margin:0.5em 0px 0px">
                                    <div style="text-align:center">
                                        <p><b>¡Buenos días, {{ $inscripcion->User->nombre_completo }}!</b></p>
                                        <p><br></p>
                                        <p><b>Confirmamos la recepción de tu pago, por el cual ya cuentas con acceso a: {{ $inscripcion->CursoProgramado->identificador }}.</b></p>
                                        <p><b>Usuario: </b> {{ $inscripcion->User->username }}</p>
                                        
                                        @if($inscripcion->CursoProgramado->category && $inscripcion->CursoProgramado->category->name == 'Guias')
                                            <p><i>Esta guía se encuentra disponible para su descarga y consulta inmediata en tu panel de alumno.</i></p>
                                            <p>Te compartimos un documento PDF adjunto con las instrucciones para ingresar a la plataforma y descargar tu guía. En caso de que presentes alguna duda, comunícate a <b>Sapius Soporte vía WhatsApp al 999 364 8594.</b></p>
                                        @elseif($inscripcion->CursoProgramado->category && $inscripcion->CursoProgramado->category->name == 'Simuladores')
                                            <p><i>Estos simuladores se encuentran divididos en tres áreas y cada examen incluye dos intentos con su respectiva retroalimentación.</i></p>
                                            <p>Te compartimos un documento PDF adjunto con las instrucciones para ingresar a la plataforma y al apartado de simuladores. En caso de que presentes alguna duda, comunícate a <b>Sapius Soporte vía WhatsApp al 999 364 8594.</b></p>
                                        @else
                                            <p><i>Ya puedes acceder a todas las lecciones, videos y material complementario de tu curso.</i></p>
                                            <p>Te compartimos un documento PDF adjunto con las instrucciones para ingresar a la plataforma y comenzar tus clases. En caso de que presentes alguna duda, comunícate a <b>Sapius Soporte vía WhatsApp al 999 364 8594.</b></p>
                                        @endif

                                        <p><u>Nota: El acceso se abre el {{ \Carbon\Carbon::parse($inscripcion->CursoProgramado->fecha_inicio)->translatedFormat('d \d\e F') }} y se cierra el {{ \Carbon\Carbon::parse($inscripcion->CursoProgramado->fecha_fin)->translatedFormat('d \d\e F') }} a las 11:59 pm.</u></p>
                                        <p>📌 Factura</p>
                                        <p>Si requieres factura, favor de enviarnos tu Constancia de Situación Fiscal antes del día 25 del mes en curso.</p>
                                        <hr>
                                        <h3>🔒 Normas importantes de la plataforma:</h3>
                                        <ul>
                                            <li style="margin-left:15px; text-align:left;">No debe abrirse en dispositivos móviles (tabletas o smartphones). En caso contrario, se negará el acceso de manera permanente.</li>
                                            <li style="margin-left:15px; text-align:left;">Solo se permite un acceso por usuario y dispositivo. Compartir contraseña o permitir acceso a terceros ocasionará la suspensión definitiva.</li>
                                            <li style="margin-left:15px; text-align:left;">Durante la presentación del simulador no se debe tener abierta ninguna otra página ni aplicación, incluyendo servicios de mensajería como WhatsApp.</li>
                                            <li style="margin-left:15px; text-align:left;">Al concluir el examen, no se debe revisar en automático la retroalimentación. Es obligatorio cerrar el examen y la sesión de Sapius; únicamente después de 20 minutos o más se podrá ingresar nuevamente para visualizar la retroalimentación.</li>
                                            <li style="margin-left:15px; text-align:left;">Está prohibido realizar capturas de pantalla, grabaciones, fotografías, impresiones o copias del material. El incumplimiento implica la cancelación inmediata del acceso.</li>
                                            <li style="margin-left:15px; text-align:left;">Solo se permite un intento por examen y retroalimentación (ambos con tiempo límite). Si se cierra o incurre en alguna falta, se pierde el intento.</li>
                                            <li style="margin-left:15px; text-align:left;">La retroalimentación se cierra automáticamente al agotarse el tiempo asignado.</li>
                                            <li style="margin-left:15px; text-align:left;">No se puede usar el teclado ni realizar zoom durante el examen o la retroalimentación.</li>
                                            <li style="margin-left:15px; text-align:left;">No se permite abrir otras páginas o aplicaciones mientras el examen o retroalimentación están activos.</li>
                                            <li style="margin-left:15px; text-align:left;">Se recomienda el uso de mouse externo.</li>
                                            <li style="margin-left:15px; text-align:left;">Es indispensable colocar una fotografía formal (rostro o medio cuerpo) como foto de perfil para identificación del estudiante.</li>
                                            <li style="margin-left:15px; text-align:left;">Para cada examen se recomienda tener a la mano: calculadora, lápiz, bolígrafo, borrador y sacapuntas.</li>
                                            <li style="margin-left:15px; text-align:left;">Dispones de un calendario para visualizar tus actividades.</li>
                                        </ul>
                                        <hr>
                                        <p>📞 Contacto para dudas de facturación:</p>
                                        <p>Vía WhatsApp al 999 298 8744</p>
                                        <p><br></p>
                                        <p>Cualquier duda o pregunta, quedamos a tus órdenes.</p>
                                        <p><br></p>
                                        <p>🌟 ¡Te deseamos mucho éxito!</p>
                                        <p>Recuerda que en Sapius… “Tu formación, nuestra pasión”</p>
                                    </div>
                                </div>
                                <div style="text-align:center;font-family:inherit">
                                    <span style="font-family:inherit"><b>Contacto:</b></span>
                                </div>
                                <div style="text-align:center;font-family:inherit">
                                    <span style="font-family:inherit">Correo: </span><a href="mailto:sapius.com.mx@gmail.com" target="_blank">sapius.com.mx@gmail.com</a><br>
                                </div>
                                <div dir="auto" style="text-align:center;font-family:inherit">Móvil: 9992-98-87-44</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:inherit;background-color:rgb(85,85,85)">
    <div style="line-height:inherit;min-width:320px;max-width:650px;word-break:break-word;margin:0px auto;background-color:transparent">
        <div style="line-height:inherit;border-collapse:collapse;display:table;width:650px;background-color:transparent">
            <div style="line-height:inherit;min-width:320px;max-width:650px;display:table-cell;vertical-align:top;width:650px">
                <div style="line-height:inherit;width:650px">
                    <div style="line-height:inherit;border-width:0px;border-style:solid;border-color:transparent;padding:0px">
                        <div style="line-height:1.2;color:rgb(9,47,74);font-family:Bitter,Georgia,Times,'Times New Roman',serif;padding:10px">
                            <div style="line-height:1.2;font-size:12px">
                                <p style="line-height:1.2;font-size:20px;word-break:break-word;text-align:center;margin:0px;color:white;">¡Bienvenido a la familia Sapius!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcomponent
