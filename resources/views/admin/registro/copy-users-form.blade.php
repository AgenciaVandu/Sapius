@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $curso_programado->Curso->titulo }}
                </h3>
                <div class="d-flex align-items-center">
                    Lista de inscritos
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Selección de curso -->
        <div class="form-group">
            <label for="selectCurso">Selecciona un curso</label>
            <select id="selectCurso" class="form-control">
                <option value="" selected disabled>-- Selecciona un curso --</option>
                @foreach ($otros_cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->Curso->titulo }}</option>
                @endforeach
            </select>
        </div>

        <!-- Lista de alumnos inscritos con checkboxes -->
        <form id="formAgregarAlumnos" method="POST" action="{{ route('curso_programado.agregarAlumnos', $curso_programado->id) }}">
            @csrf
            <div id="listaAlumnos" class="mt-3">
                <ul>
                    @forelse($curso_programado->Inscritos as $alumno)
                        <li>
                            <input type="checkbox" name="alumnos[]" value="{{ $alumno->id }}"
                                id="alumno{{ $alumno->id }}" class="mx-2">
                            <div>
                                <label for="alumno{{ $alumno->id }}" class="ml-2">
                                    {{ $alumno->name }} - {{ $alumno->email }}
                                    @if ($alumno->pivot->aceptado)
                                        <span class="text-success">(Aceptado)</span>
                                    @endif
                                </label>
                            </div>
                        </li>
                    @empty
                        <li>No hay alumnos inscritos</li>
                    @endforelse
                </ul>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Agregar al curso programado</button>
        </form>

    </div>
@endsection

@section('css')
    <link href="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"
        rel="stylesheet">
@endsection

@section('javascript')
    <script src="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script>
        $(document).ready(function() {
            $('#selectCurso').change(function() {
                var cursoId = $(this).val();
                var url = '{{ route('cursos.inscritos', ['id' => ':id']) }}'.replace(':id', cursoId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(inscritos) {
                        var lista = '<ul>';
                        if (inscritos.length > 0) {
                            inscritos.forEach(function(alumno) {
                                lista += '<li>';
                                lista +=
                                    '<input type="checkbox" name="alumnos[]" value="' +
                                    alumno.id + '" id="alumno' + alumno.id + '">';
                                lista += '<label for="alumno' + alumno.id + '"> ' +
                                    alumno.nombre_completo + ' - ' + alumno.email;
                                if (alumno.pivot.aceptado) {
                                    lista +=
                                        ' <span class="text-success">(Aceptado)</span>';
                                }
                                lista += '</label></li>';
                            });
                        } else {
                            lista += '<li>No hay alumnos inscritos</li>';
                        }
                        lista += '</ul>';
                        $('#listaAlumnos').html(lista);
                    },
                    error: function() {
                        alert('Error al obtener los alumnos');
                    }
                });
            });
        });
    </script>
@endsection
