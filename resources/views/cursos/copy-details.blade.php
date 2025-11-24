@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    Selección de contenido del curso que se desea copiar
                </h3>
                <div class="d-flex align-items-center">
                    @include('genericos.menu', ['form' => 'Lecciones'])
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right"></div>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    @php
                        // Agrupar módulos y clases
                        $modulos = $curso->Lecciones->where('leccion_id', 0);
                        $clases = $curso->Lecciones->where('leccion_id', '!=', 0)->groupBy('leccion_id');
                    @endphp

                    <form action="{{ route('admin.cursos.content.copy') }}" method="POST">
                        @csrf
                        <input type="hidden" name="curso_id" value={{ $curso->id }}>
                        <div class="mb-3">
                            <label style="font-weight: bold;">
                                <input type="checkbox" id="select-all"> Seleccionar todo
                            </label>
                        </div>

                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="50">Seleccionar</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($modulos as $modulo)
                                    <!-- MÓDULO -->
                                    <tr class="table-primary">
                                        <td>
                                            <input type="checkbox" class="modulo-checkbox main-checkbox"
                                                data-modulo="{{ $modulo->id }}" name="items[]"
                                                value="{{ $modulo->id }}">
                                        </td>
                                        <td><strong>{{ $modulo->titulo }}</strong></td>
                                        <td><span class="badge badge-info">Módulo</span></td>
                                    </tr>

                                    <!-- CLASES DEL MÓDULO -->
                                    @if (isset($clases[$modulo->id]))
                                        @foreach ($clases[$modulo->id] as $clase)
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                        class="clase-checkbox main-checkbox clase-de-{{ $modulo->id }}"
                                                        data-modulo="{{ $modulo->id }}" name="items[]"
                                                        value="{{ $clase->id }}">
                                                </td>
                                                <td class="pl-4">— {{ $clase->titulo }}</td>
                                                <td><span class="badge badge-secondary">Clase</span></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-success mt-3">
                            Copiar selección
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- OVERLAY DE CARGA -->
    <div id="loading-overlay"
        style="
            position: fixed;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(255,255,255,0.9);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        ">

        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;"></div>

        <p class="mt-4" style="font-size: 18px; font-weight: bold; color:#333;">
            Estamos copiando tu curso…
            <br>
            Por favor, no cierres ni recargues la página.
        </p>

    </div>


    {{-- SCRIPT PARA CHECKBOX Y LOADER --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selectAll = document.getElementById('select-all');

            // 1. SELECCIONAR TODO
            selectAll.addEventListener('change', function() {
                const allChecks = document.querySelectorAll('.main-checkbox');
                allChecks.forEach(ch => ch.checked = selectAll.checked);
            });

            // 2. MARCAR MÓDULO → MARCAR CLASES
            document.querySelectorAll('.modulo-checkbox').forEach(modulo => {
                modulo.addEventListener('change', function() {
                    let moduloId = this.dataset.modulo;
                    document.querySelectorAll('.clase-de-' + moduloId)
                        .forEach(clase => clase.checked = this.checked);

                    actualizarSeleccionGeneral();
                });
            });

            // 3. MARCAR CLASES → MODULO PERMANECE SI ALGUNA ESTA MARCADA
            document.querySelectorAll('.clase-checkbox').forEach(clase => {
                clase.addEventListener('change', function() {
                    let moduloId = this.dataset.modulo;
                    let moduloCheckbox = document.querySelector('.modulo-checkbox[data-modulo="' +
                        moduloId + '"]');
                    let clases = document.querySelectorAll('.clase-de-' + moduloId);

                    let algunaMarcada = Array.from(clases).some(c => c.checked);

                    moduloCheckbox.checked = algunaMarcada;

                    actualizarSeleccionGeneral();
                });
            });

            // 4. ACTUALIZAR "SELECCIONAR TODO"
            function actualizarSeleccionGeneral() {
                const allChecks = document.querySelectorAll('.main-checkbox');
                const allMarcados = Array.from(allChecks).every(c => c.checked);
                selectAll.checked = allMarcados;
            }

            // 5. MOSTRAR LOADER AL ENVIAR FORMULARIO
            const form = document.querySelector('form');

            form.addEventListener('submit', function() {
                document.getElementById('loading-overlay').style.display = 'flex';

                const btn = form.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.innerText = "Procesando...";
                }
            });

        });
    </script>
@endsection
