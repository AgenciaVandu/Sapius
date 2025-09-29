@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Copiar un curso</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.menu', ['form' => 'Lecciones'])
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
                    <form action="{{ route('cursos.copy.create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="curso_id">Seleccione el curso a copiar</label>
                            <select class="form-control" id="curso_id" name="curso_id" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}">{{ $curso->titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Copiar Curso</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
