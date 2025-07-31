@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Administrables</h3>
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
                        {{-- Simuladores Medicina --}}
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Tabla Simuladores Medicina
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p class="d-flex flex-row-reverse">
                                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Agregar nuevo
                                        </a>
                                    </p>
                                    <div class="collapse" id="collapseExample">
                                        <form action="{{ route('admin.manageable.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="type" value="simuladores">
                                            <input type="hidden" name="category" value="medicina">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="titulo">Título</label>
                                                    <input id="titulo" type="text"
                                                        class="form-control @error('nombre') is-invalid @enderror"
                                                        name="titulo" value="" required autocomplete="titulo"
                                                        autofocus>

                                                    @error('titulo')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="descripcion1">Descripción</label>
                                                    <textarea id="descripcion1" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" required
                                                        autocomplete="descripcion" autofocus>{{ old('descripcion') }}</textarea>
                                                    @error('descripcion')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="descripcion">Imagen</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input"
                                                            id="inputGroupFile02" accept="image/*" required>
                                                        <label class="custom-file-label" for="inputGroupFile02"
                                                            aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                                    </div>
                                                    @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                            {{-- Button Submit --}}
                                            <div class="form-group row">
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-sm p-5">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Titulo</th>
                                            <th scope="col">Description</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="simulatormedicines">
                                        @foreach ($manageable_simulator_medicine as $manageable_simulator_medicine_item)
                                            <tr data-id="{{ $manageable_simulator_medicine_item->id }}">
                                                <td class="handle">
                                                    <i class="fas fa-arrows-alt"></i>
                                                </td>
                                                <td>{{ $manageable_simulator_medicine_item->titulo }}</td>
                                                <td>{!! $manageable_simulator_medicine_item->descripcion !!}</td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalTeacher{{ $manageable_simulator_medicine_item->id }}">
                                                        Editar
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade"
                                                        id="exampleModalTeacher{{ $manageable_simulator_medicine_item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel{{ $manageable_simulator_medicine_item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalLabel{{ $manageable_simulator_medicine_item->id }}">
                                                                        Editar información</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('admin.manageable.update') }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="type"
                                                                            value="simuladores">
                                                                        <input type="hidden" name="category"
                                                                            value="medicina">
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $manageable_simulator_medicine_item->id }}">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <label for="titulo">Título</label>
                                                                                <input id="titulo" type="text"
                                                                                    class="form-control @error('nombre') is-invalid @enderror"
                                                                                    name="titulo"
                                                                                    value="{{ $manageable_simulator_medicine_item->titulo }}"
                                                                                    required autocomplete="titulo"
                                                                                    autofocus>

                                                                                @error('titulo')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="sumulador_medicine{{ $manageable_simulator_medicine_item->id }}">Descripción</label>
                                                                                <textarea id="sumulador_medicine{{ $manageable_simulator_medicine_item->id }}"
                                                                                    class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" required
                                                                                    autocomplete="descripcion" autofocus>{{ $manageable_simulator_medicine_item->descripcion }}</textarea>
                                                                                @error('descripcion')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <label for="descripcion">Imagen</label>
                                                                                <div class="custom-file">
                                                                                    <input type="file" name="image"
                                                                                        class="custom-file-input"
                                                                                        id="inputGroupFile02"
                                                                                        accept="image/*" required>
                                                                                    <label class="custom-file-label"
                                                                                        for="inputGroupFile02"
                                                                                        aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                                                                </div>
                                                                                @error('image')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div> --}}
                                                                        {{-- Button Submit --}}
                                                                        <div class="modal-footer">
                                                                            <a href="{{ route('admin.manageablesimulatormedicine.delete', $manageable_simulator_medicine_item->id) }}"
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
                        {{-- Simuladores Nutricion --}}
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                                        aria-controls="collapseTwo">
                                        Tabla Simuladores Nutricion
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
                                        <form action="{{ route('admin.manageable.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="type" value="simuladores">
                                            <input type="hidden" name="category" value="nutricion">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="titulo">Título</label>
                                                    <input id="titulo" type="text"
                                                        class="form-control @error('nombre') is-invalid @enderror"
                                                        name="titulo" value="" required autocomplete="titulo"
                                                        autofocus>

                                                    @error('titulo')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="descripcion">Descripción</label>
                                                    <textarea id="descripcion2" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                                                        required autocomplete="descripcion" autofocus>{{ old('descripcion') }}</textarea>
                                                    @error('descripcion')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="descripcion">Imagen</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input"
                                                            id="inputGroupFile02" accept="image/*">
                                                        <label class="custom-file-label" for="inputGroupFile02"
                                                            aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- Button Submit --}}
                                            <div class="form-group row">
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-sm p-5">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Titulo</th>
                                            <th scope="col">Description</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="simulatornutritions">
                                        @foreach ($manageable_simulator_nutrition as $manageable_simulator_nutrition_item)
                                            <tr data-id="{{ $manageable_simulator_nutrition_item->id }}">
                                                <td class="handle">
                                                    <i class="fas fa-arrows-alt"></i>
                                                </td>
                                                <td>{{ $manageable_simulator_nutrition_item->titulo }}</td>
                                                <td>{!! $manageable_simulator_nutrition_item->descripcion !!}</td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalTeacher2{{ $manageable_simulator_nutrition_item->id }}">
                                                        Editar
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade"
                                                        id="exampleModalTeacher2{{ $manageable_simulator_nutrition_item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel{{ $manageable_simulator_nutrition_item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalLabel{{ $manageable_simulator_nutrition_item->id }}">
                                                                        Editar información</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('admin.manageable.update') }}"
                                                                        method="POST" enctype='multipart/form-data'>
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <input type="hidden" name="type"
                                                                            value="simuladores">
                                                                        <input type="hidden" name="category"
                                                                            value="nutricion">
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $manageable_simulator_nutrition_item->id }}">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <label for="titulo">Título</label>
                                                                                <input id="titulo" type="text"
                                                                                    class="form-control @error('titulo') is-invalid @enderror"
                                                                                    name="titulo"
                                                                                    value="{{ $manageable_simulator_nutrition_item->titulo }}"
                                                                                    required autocomplete="titulo"
                                                                                    autofocus>
                                                                                @error('titulo')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="sumulador_nutrition{{ $manageable_simulator_nutrition_item->id }}">Descripción</label>
                                                                                <textarea id="sumulador_nutrition{{ $manageable_simulator_nutrition_item->id }}"
                                                                                    class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" required
                                                                                    autocomplete="descripcion" autofocus>{{ $manageable_simulator_nutrition_item->descripcion }}</textarea>
                                                                                @error('descripcion')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="form-group">
                                                                            <label for="img">Foto</label>
                                                                            <input type="file" name="image5">
                                                                        </div> --}}
                                                                        <div class="modal-footer">
                                                                            <a href="{{ route('admin.manageablesimulatornutrition.delete', $manageable_simulator_nutrition_item->id) }}"
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
                        {{-- Guias Medicina --}}
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                                        aria-controls="collapseThree">
                                        Tabla Guias Medicina
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
                                        <form action="{{ route('admin.manageable.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="type" value="guias">
                                            <input type="hidden" name="category" value="medicina">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="titulo">Título</label>
                                                    <input id="titulo" type="text"
                                                        class="form-control @error('nombre') is-invalid @enderror"
                                                        name="titulo" value="" required autocomplete="titulo"
                                                        autofocus>

                                                    @error('titulo')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="descripcion">Descripción</label>
                                                    <textarea id="descripcion3" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                                                        required autocomplete="descripcion" autofocus>{{ old('descripcion') }}</textarea>
                                                    @error('descripcion')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="descripcion">Imagen</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input"
                                                            id="inputGroupFile02" accept="image/*">
                                                        <label class="custom-file-label" for="inputGroupFile02"
                                                            aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- Button Submit --}}
                                            <div class="form-group row">
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-sm p-5">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Titulo</th>
                                            <th scope="col">Description</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="guiamedicines">
                                        @foreach ($manageable_guia_medicine as $manageable_guia_medicine_item)
                                            <tr data-id="{{ $manageable_guia_medicine_item->id }}">
                                                <td class="handle">
                                                    <i class="fas fa-arrows-alt"></i>
                                                </td>
                                                <td>{{ $manageable_guia_medicine_item->titulo }}</td>
                                                <td>{!! $manageable_guia_medicine_item->descripcion !!}</td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalTeacher4{{ $manageable_guia_medicine_item->id }}">
                                                        Editar
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade"
                                                        id="exampleModalTeacher4{{ $manageable_guia_medicine_item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel{{ $manageable_guia_medicine_item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalLabel{{ $manageable_guia_medicine_item->id }}">
                                                                        Editar información</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('admin.manageable.update') }}"
                                                                        method="POST" enctype='multipart/form-data'>
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <input type="hidden" name="type"
                                                                            value="guias">
                                                                        <input type="hidden" name="category"
                                                                            value="medicina">
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $manageable_guia_medicine_item->id }}">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <label for="titulo">Título</label>
                                                                                <input id="titulo" type="text"
                                                                                    class="form-control @error('titulo') is-invalid @enderror"
                                                                                    name="titulo"
                                                                                    value="{{ $manageable_guia_medicine_item->titulo }}"
                                                                                    required autocomplete="titulo"
                                                                                    autofocus>

                                                                                @error('titulo')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                            </div>ass="form-group">
                                                                            <label for="text">Descripcion</label>
                                                                            <textarea id="guias_medicine{{ $manageable_guia_medicine_item->id }}"
                                                                                class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" required
                                                                                autocomplete="descripcion" autofocus>{{ $manageable_guia_medicine_item->descripcion }}</textarea>
                                                                            @error('descripcion')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        {{-- <div class="form-group">
                                                                            <label for="img">Foto</label>
                                                                            <input type="file" name="image5">
                                                                        </div> --}}
                                                                        <div class="modal-footer">
                                                                            <a href="{{ route('admin.manageableguiamedicine.delete', $manageable_guia_medicine_item->id) }}"
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
                        {{-- Guias Nutricion --}}
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
                                        aria-controls="collapseFour">
                                        Tabla Guias Nutricion
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p class="d-flex flex-row-reverse">
                                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Agregar nuevo
                                        </a>
                                    </p>
                                    <div class="collapse" id="collapseExample">
                                        <form action="{{ route('admin.manageable.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="type" value="guias">
                                            <input type="hidden" name="category" value="nutricion">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="titulo">Título</label>
                                                    <input id="titulo" type="text"
                                                        class="form-control @error('nombre') is-invalid @enderror"
                                                        name="titulo" value="" required autocomplete="titulo"
                                                        autofocus>
                                                    @error('titulo')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="descripcion">Descripción</label>
                                                    <textarea id="descripcion4" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                                                        required autocomplete="descripcion" autofocus>{{ old('descripcion') }}</textarea>
                                                    @error('descripcion')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="descripcion">Imagen</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input"
                                                            id="inputGroupFile02" accept="image/*">
                                                        <label class="custom-file-label" for="inputGroupFile02"
                                                            aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- Button Submit --}}
                                            <div class="form-group row">
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-sm p-5">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Titulo</th>
                                            <th scope="col">Description</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="guianutritions">
                                        @foreach ($manageable_guia_nutrition as $manageable_guia_nutrition_item)
                                            <tr data-id="{{ $manageable_guia_nutrition_item->id }}">
                                                <td class="handle">
                                                    <i class="fas fa-arrows-alt"></i>
                                                </td>
                                                <td>{{ $manageable_guia_nutrition_item->titulo }}</td>
                                                <td>{!! $manageable_guia_nutrition_item->descripcion !!}</td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalTeacher5{{ $manageable_guia_nutrition_item->id }}">
                                                        Editar
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade"
                                                        id="exampleModalTeacher5{{ $manageable_guia_nutrition_item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel{{ $manageable_guia_nutrition_item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalLabel{{ $manageable_guia_nutrition_item->id }}">
                                                                        Editar información</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('admin.manageable.update') }}"
                                                                        method="POST" enctype='multipart/form-data'>
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <input type="hidden" name="type"
                                                                            value="guias">
                                                                        <input type="hidden" name="category"
                                                                            value="nutricion">
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $manageable_guia_nutrition_item->id }}">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <label for="titulo">Título</label>
                                                                                <input id="titulo" type="text"
                                                                                    class="form-control @error('titulo') is-invalid @enderror"
                                                                                    name="titulo"
                                                                                    value="{{ $manageable_guia_nutrition_item->titulo }}"
                                                                                    required autocomplete="titulo"
                                                                                    autofocus>
                                                                                @error('titulo')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="guias_nutrition{{ $manageable_guia_nutrition_item->id }}">Descripción</label>
                                                                                <textarea id="guias_nutrition{{ $manageable_guia_nutrition_item->id }}"
                                                                                    class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" required
                                                                                    autocomplete="descripcion" autofocus>{{ $manageable_guia_nutrition_item->descripcion }}</textarea>
                                                                                @error('descripcion')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="form-group">
                                                                            <label for="img">Foto</label>
                                                                            <input type="file" name="image5">
                                                                        </div> --}}
                                                                        <div class="modal-footer">
                                                                            <a href="{{ route('admin.manageableguianutrition.delete', $manageable_guia_nutrition_item->id) }}"
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
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('vendor/summernote/summernote.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Sortable(simulatormedicines, {
                animation: 150,
                ghostClass: 'bg-primary',
                handle: '.handle',
                store: {
                    set: function(sortable) {
                        const simulatormedicines = sortable.toArray();
                        axios.post('{{ route('api.sort.simuladores.medicina') }}', {
                            simulatormedicines: simulatormedicines
                        }).catch(function(error) {
                            console.error(error);
                        });
                    }
                }
            });
            new Sortable(simulatornutritions, {
                animation: 150,
                ghostClass: 'bg-primary',
                handle: '.handle',
                store: {
                    set: function(sortable) {
                        const simulatornutritions = sortable.toArray();
                        axios.post('{{ route('api.sort.simuladores.nutricion') }}', {
                            simulatornutritions: simulatornutritions
                        }).catch(function(error) {
                            console.error(error);
                        });
                    }
                }
            });
            new Sortable(guiamedicines, {
                animation: 150,
                ghostClass: 'bg-primary',
                handle: '.handle',
                store: {
                    set: function(sortable) {
                        const guiamedicines = sortable.toArray();
                        axios.post('{{ route('api.sort.guias.medicines') }}', {
                            guiamedicines: guiamedicines
                        }).catch(function(error) {
                            console.error(error);
                        });
                    }
                }
            });
            new Sortable(guianutritions, {
                animation: 150,
                ghostClass: 'bg-primary',
                handle: '.handle',
                store: {
                    set: function(sortable) {
                        const guianutritions = sortable.toArray();
                        axios.post('{{ route('api.sort.guias.nutricion') }}', {
                            guianutritions: guianutritions
                        }).catch(function(error) {
                            console.error(error);
                        });
                    }
                }
            });
        });
    </script>

    <script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //cambiar nombre de input importar
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                if (fileName) {
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                } else {
                    $(this).siblings(".custom-file-label").addClass("selected").html("Selecciona archivo");
                }
            });

            for (let i = 1; i <= 4; i++) {
                $('#descripcion' + i).summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                    ],
                });

            }
            /*
            $('#descripcion3').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });
            $('#descripcion4').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });
            $('#descripcion5').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            }); */



        });
    </script>

    <script>
        const manageable_simulator_medicines = @json($manageable_simulator_medicine);
        const manageable_simulator_nutritions = @json($manageable_simulator_nutrition);
        const manageable_guia_medicines = @json($manageable_guia_medicine);
        const manageable_guia_nutritions = @json($manageable_guia_nutrition);

        /* console.log(manageable_simulator_medicines) */
        manageable_simulator_medicines.forEach(function(item) {
            $('#sumulador_medicine' + item.id).summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });
        });

        manageable_simulator_nutritions.forEach(function(item) {
            $('#sumulador_nutrition' + item.id).summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });
        });
        manageable_guia_medicines.forEach(function(item) {
            $('#guias_medicine' + item.id).summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });
        });
        manageable_guia_nutritions.forEach(function(item) {
            $('#guias_nutrition' + item.id).summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });
        });
    </script>
@endsection
