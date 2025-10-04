<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultados de Exámenes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            background-color: #f8f9fa;
            margin: 0;
        }

        header,
        footer {
            width: 100%;
        }

        header {
            background-color: #002146;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        header img {
            height: 50px;
            vertical-align: middle;
            margin-right: 15px;
        }

        main {
            display: block;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #002146;
            color: #fff;
        }

        .bajo {
            background-color: #FFCCCC;
            color: #a94442;
        }

        .alto {
            background-color: #D4EDDA;
            color: #155724;
        }

        .nopresentado {
            background-color: #FFFF8A;
            color: #948503;
        }

        .cerrado {
            background-color: #F8D7DA;
            color: #721c24;
        }

        .legend-container {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
            justify-content: center;
            flex-wrap: nowrap;
        }
        .legend-box {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 500;
            font-size: 0.85em;
            min-width: 120px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        .legend-nopresentado {
            background-color: #FFFF8A;
            color: #948503;
            border: 1px solid #e6e600;
        }
        .legend-bajo {
            background-color: #FFCCCC;
            color: #a94442;
            border: 1px solid #e57373;
        }
        .legend-alto {
            background-color: #D4EDDA;
            color: #155724;
            border: 1px solid #a3cfbb;
        }
        footer {
            background-color: #002146;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
        }
        .nota-cerrado {
            font-size: 0.95em;
            color: #721c24;
            margin-top: 4px;
            display: block;
        }
    </style>
</head>

<body>
    <header>
        <img src="https://sapius.com.mx/img/logo-sapius.png" alt="Logo">
        <br>
        <span style="font-size: 1.5em;">Resultados de Exámenes</span>
        <div style="margin-top: 18px; display: flex; justify-content: center; gap: 50px; font-size: 1.25em;">
            <div>
            <strong>Alumno: </strong> {{ $inscripcion->User->getNombreCompletoAttribute() }}
            </div>
            <div>
            <strong>Folio: </strong> {{ $inscripcion->User->folio ?? $inscripcion->User->id }}
            </div>
            <div>
            <strong>Curso: </strong> {{ $inscripcion->CursoProgramado->Curso->titulo }} 
            <br>
            <span style="color: #b0c4de;">({{ $inscripcion->CursoProgramado->identificador }})</span>
            </div>
        </div>
    </header>
    <div class="legend-container">
        <div class="legend-box legend-nopresentado">
            No presentado: El examen no ha sido contestado.
        </div>
        <div class="legend-box legend-bajo">
            Deficiencia en puntaje, tema o contenido.
        </div>
        <div class="legend-box legend-alto">
            Puntaje satisfactorio, demuestra buen dominio del contenido.
        </div>
    </div>
    <main>
        <table>
            <thead>
                <tr>
                    <th style="width:50%;">Examen</th>
                    <th style="width:25%;">Tipo</th>
                    <th style="width:25%;">Total Preguntas</th>
                    <th style="width:25%;">Correctas</th>
                    <th style="width:25%;">Puntaje final</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lecciones as $leccion)
                    @foreach ($leccion->pruebas as $prueba)
                        @if ($prueba->activo === 'si')
                            @php
                                $examen = $examenes->firstWhere('prueba_id', $prueba->id);
                            @endphp
                            @if ($examen)
                                <tr class="{{ $examen->eventos ? 'cerrado' : ($examen->score_total < 1200 ? 'bajo' : 'alto') }}">
                                    <td>{{ $examen->Prueba->titulo }}</td>
                                    <td>{{ $examen->Prueba->tipo }}</td>
                                    <td>{{ $examen->total_preguntas }}</td>
                                    <td>{{ $examen->total_correctas }}</td>
                                    <td>
                                        {{ $examen->score_total }}
                                        @if($examen->eventos)
                                            <span class="nota-cerrado">Examen cerrado por incumplir las normas del sitio</span>
                                        @endif
                                    </td>
                                </tr>
                            @else
                                <tr class="nopresentado">
                                    <td>{{ $prueba->titulo }}</td>
                                    <td>{{ $prueba->tipo }}</td>
                                    <td colspan="3">No Presentado</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Examen</th>
                    <th>Tipo</th>
                    <th>Total Preguntas</th>
                    <th>Correctas</th>
                    <th>Puntaje final</th>
                </tr>
            </tfoot>
        </table>
    </main>
    {{-- <footer>
        <span>Resultados generados por Sapius</span>
    </footer> --}}
</body>

</html>
