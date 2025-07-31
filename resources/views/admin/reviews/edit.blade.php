@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Crear Review</h3>
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
                    {{-- Formulario para editar una review --}}
                    <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- <div class="form-group">
                            <label for="user_id">Usuario</label>
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $review->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_id">Curso</label>
                            <select name="course_id" id="course_id" class="form-control">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" {{ $review->course_id == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="user_id">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ $review->name }}">
                        </div>
                        <div class="form-group">
                            <label for="rating">Calificación</label>
                            <input type="number" name="rating" id="rating" class="form-control" min="1" max="5"
                                value="{{ $review->rating }}" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comentario</label>
                            <textarea name="comment" id="comment" class="form-control" rows="4" required>{{ $review->comment }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

