@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Configuraciones</h3>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        {{-- Apartado de imagenes de slider principal del index  --}}
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Imagenes de slider principal
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div>
                                        <div class="row justify-content-md-center mb-4" id="slides">
                                            @foreach ($slides as $slide)
                                                <div class="col col-lg-2 handle" data-id="{{ $slide->id }}">
                                                    <div class="card" style="width: 8rem;">
                                                        <img src="{{ asset('storage/' . $slide->img) }}" alt="Imagen subida"
                                                            width="100%" style="min-height: 8rem; max-height:8rem;">
                                                        <div class="card-body">
                                                            <a href="{{ route('admin.configuracion.slide,delete', $slide) }}"
                                                                class="btn btn-primary btn-sm">Eliminar</a>
                                                        </div>
                                                    </div>
                                                    <div class="handle">
                                                        <i class="fas fa-arrows-alt"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.configuracion.slide') }}" method="POST"
                                        enctype='multipart/form-data'>
                                        @csrf
                                        <input type="file" name="image">
                                        <button type="submit" class="btn btn-primary">Subir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Administracion orgullo Sapius
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p class="d-flex flex-row-reverse">
                                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Agregar nuevo
                                        </a>
                                    </p>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                            <form action="{{ route('admin.configuracion.pride') }}" method="POST"
                                                enctype='multipart/form-data'>
                                                @csrf
                                                <div class="form-group">
                                                    <label for="name">Nombre</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="text">Texto1</label>
                                                    <input type="text" class="form-control" id="text" name="text"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="text">Texto2</label>
                                                    <input type="text" class="form-control" id="text" name="text2"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="img">Foto</label>
                                                    <input type="file" name="image2" required>
                                                </div>
                                                <div class="d-flex flex-row-reverse mb-4">

                                                    <button type="submit" class="btn btn-primary">Subir</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <table class="table table-sm p-5">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Foto</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Texto 1</th>
                                                <th scope="col">Texto 2</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="prides">
                                            @foreach ($prides as $pride)
                                                <tr data-id="{{ $pride->id }}">
                                                    <td class="handle">
                                                        <i class="fas fa-arrows-alt"></i>
                                                    </td>
                                                    <th scope="row">
                                                        <img src="{{ asset('storage/' . $pride->img) }}"
                                                            class="img-fluid rounded-circle" style="width: 3.8rem;"
                                                            alt="">
                                                    </th>
                                                    <td>{{ $pride->name }}</td>
                                                    <td>{{ $pride->text }}</td>
                                                    <td>{{ $pride->text2 }}</td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal{{ $pride->id }}">
                                                            Editar
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal{{ $pride->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="exampleModalLabel{{ $pride->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLabel{{ $pride->id }}">
                                                                            Editar información</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('admin.configuracion.pride.update', $pride) }}"
                                                                            method="POST" enctype='multipart/form-data'>
                                                                            @method('PUT')
                                                                            @csrf
                                                                            <div class="form-group">
                                                                                <label for="name">Nombre</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="name" name="name"
                                                                                    value="{{ $pride->name }}" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="text">Texto1</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="text" name="text"
                                                                                    value="{{ $pride->text }}" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="text">Texto2</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="text" name="text2"
                                                                                    value="{{ $pride->text2 }}" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="img">Foto</label>
                                                                                <input type="file" name="image3">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{ route('admin.configuracion.pride.delete', $pride) }}"
                                                                                    class="btn btn-danger mr-auto">Eliminar</a>

                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Cancelar</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Guardar
                                                                                    cambios</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Administracion de maestros
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p class="d-flex flex-row-reverse">
                                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Agregar nuevo
                                        </a>
                                    </p>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                            <form action="{{ route('admin.configuracion.teacher') }}" method="POST"
                                                enctype='multipart/form-data'>
                                                @csrf
                                                <div class="form-group">
                                                    <label for="name">Nombre</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="text">Descripcion</label>
                                                    <input type="text" class="form-control" id="text"
                                                        name="description" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="img">Foto</label>
                                                    <input type="file" name="image4" required>
                                                </div>
                                                <div class="d-flex flex-row-reverse mb-4">

                                                    <button type="submit" class="btn btn-primary">Subir</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <table class="table table-sm p-5">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Foto</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Descripcion</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="teachers">
                                            @foreach ($teachers as $teacher)
                                                <tr data-id="{{ $teacher->id }}">
                                                    <td class="handle">
                                                        <i class="fas fa-arrows-alt"></i>
                                                    </td>
                                                    <th scope="row">
                                                        <img src="{{ asset('storage/' . $teacher->img) }}"
                                                            class="img-fluid rounded-circle" style="width: 3.8rem;"
                                                            alt="">
                                                    </th>
                                                    <td>{{ $teacher->name }}</td>
                                                    <td>{{ $teacher->description }}</td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-toggle="modal"
                                                            data-target="#exampleModalTeacher{{ $teacher->id }}">
                                                            Editar
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="exampleModalTeacher{{ $teacher->id }}" tabindex="-1"
                                                            aria-labelledby="exampleModalLabel{{ $teacher->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLabel{{ $teacher->id }}">
                                                                            Editar información</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('admin.configuracion.teacher.update', $teacher) }}"
                                                                            method="POST" enctype='multipart/form-data'>
                                                                            @method('PUT')
                                                                            @csrf
                                                                            <div class="form-group">
                                                                                <label for="name">Nombre</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="name" name="name"
                                                                                    value="{{ $teacher->name }}" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="text">Descripcion</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="text" name="description"
                                                                                    value="{{ $teacher->description }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="img">Foto</label>
                                                                                <input type="file" name="image5">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{ route('admin.configuracion.teacher.delete', $teacher) }}"
                                                                                    class="btn btn-danger mr-auto">Eliminar</a>

                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Cancelar</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Guardar
                                                                                    cambios</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        {{-- System Commands --}}
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        Comandos del Sistema
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p class="mb-3">Ejecutar manualmente el recordatorio de lecciones atrasadas (Envía correos y notificaciones).</p>
                                    <form action="{{ route('admin.configuracion.trigger-reminders') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-bell mr-2"></i> Ejecutar Recordatorios
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Sortable(teachers, {
                animation: 150,
                ghostClass: 'bg-primary',
                handle: '.handle',
                store: {
                    set: function(sortable) {
                        const teachers = sortable.toArray();
                        axios.post('{{ route('api.sort.teachers') }}', {
                            teachers: teachers
                        }).catch(function(error) {
                            console.error(error);
                        });
                    }
                }

            });

            new Sortable(prides, {
                animation: 150,
                ghostClass: 'bg-primary',
                handle: '.handle',
                store: {
                    set: function(sortable) {
                        const prides = sortable.toArray();
                        axios.post('{{ route('api.sort.prides') }}', {
                            prides: prides
                        }).catch(function(error) {
                            console.error(error);
                        });
                    }
                }

            });


            new Sortable(slides, {
                animation: 150,
                ghostClass: 'bg-primary',
                handle: '.handle',
                store: {
                    set: function(sortable) {
                        const slides = sortable.toArray();
                        axios.post('{{ route('api.sort.slides') }}', {
                            slides: slides
                        }).catch(function(error) {
                            console.error(error);
                        });
                    }
                }

            });
        });
    </script>
@endsection
