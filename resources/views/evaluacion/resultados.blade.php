@extends('layouts.adminmart.detalle')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Lista de resultados de la prueba "{{ $examen->titulo }}"</h4>
            @php
                $count = 1;
            @endphp
            @foreach ($examen->Examenes as $item)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="card-subtitle mt-2">Intento {{ $count++ }}</h6>
                        @php
                            $fecha_actual = date('Y-m-d H:i:s');
                            $fecha_fin = date('Y-m-d H:i:s',strtotime($item->updated_at." +".$examen->tiempo_caducidad." days"));
                        @endphp
                        @if($fecha_actual < $fecha_fin && $item->retro_visualizado == 'no')
                            <form method="POST" action="{{ route('examen.feedback') }}">
                                @csrf <input name="examen_id" type="hidden" value="{{ $item->id}}">
                                <button type="submit" class="btn btn-primary">
                                    Retroalimentación</button>
                            </form>
                        @endif
                        <canvas id="pie-chart-{{ $item->id }}" height="150"></canvas>
                        <input type="hidden" name="data{{ $item->id }}" value="{{ $item->id }},{{ $item->total_correctas }},{{ $item->total_preguntas}},{{ floor($item->score_total) }}">
                    </div>
                </div>
            @endforeach
            @php
            $imagenExamen = "";
            switch ($examen->tipo) {
                case "EXANI":
                    $imagenExamen = "aprobados--EXANII-.png";
                    break;
                case "EGEL":
                    $imagenExamen = "tabla-ceneval.jpg";
                    break;
                case "ENARM":
                    $imagenExamen = "Enarm.png";
                    break;
            }
            @endphp

            {{-- Crear tabla para que aqui vayan los datos --}}
            <div class="text-center p-3">
                <img src="{{ asset('vendor/adminmart/assets/images/'.$imagenExamen.'') }}" alt="wrapkit">
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('vendor/adminmart/assets/libs/chart.js/dist/Chart.min.js') }}"></script>
   <script>
        $(document).ready( function () {
            $(".modal-title").html("Resultados");
            $("#cancelar").html("Cerrar");
            $("#continuar").hide();

            $('input[name^="data"]').each(function( index ) {
                var datos = $(this).val().split(',');

                //alert(datos)

                new Chart(document.getElementById("pie-chart-" + datos[0]), {
                            type: 'pie',
                            data: {
                            labels: ["Correctas", "Incorrectas"],
                            datasets: [{
                                label: "Puntos",
                                backgroundColor: ["#002146", "#ED6A5A"],
                                data: [ datos[1], datos[2] - datos[1] ]
                            }]
                            },
                            options: {
                            title: {
                                display: true,
                                text: 'Resultados: ' + datos[1] + ' acertadas de un total de ' + datos[2] + ' reactivos. [ Puntaje: ' + datos[3] + ' ]'
                            }
                        }
                    });

            });
        });
    </script>
@endsection
