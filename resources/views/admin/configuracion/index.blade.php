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
                                        <div class="row justify-content-md-center mb-4">
                                            @foreach ($slides as $slide)
                                                <div class="col col-lg-2">
                                                    <div class="card" style="width: 8rem;">
                                                        <img src="{{ asset('storage/' . $slide->img) }}" alt="Imagen subida"
                                                            width="100%" height="auto">
                                                        <div class="card-body">
                                                            <a href="{{ route('admin.configuracion.slide,delete', $slide) }}"
                                                                class="btn btn-primary btn-sm">Eliminar</a>
                                                        </div>
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

                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Foto</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Texto 1</th>
                                                <th scope="col">Texto 2</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prides as $pride)
                                                <tr>
                                                    <th scope="row">
                                                        <img src="{{ asset('storage/' . $pride->img) }}" class="img-fluid img-thumbnail" style="width: 5.8rem;" alt="">
                                                    </th>
                                                    <td>{{ $pride->name }}</td>
                                                    <td>{{ $pride->text }}</td>
                                                    <td>{{ $pride->text2 }}</td>
                                                    <td>
                                                        <a href="" class="text-secondary">Editar</a>
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
                                        Funciones adicionales
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    Por definir
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
