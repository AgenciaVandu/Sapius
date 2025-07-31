@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Reviews</h3>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    {{-- Botton para agregar nueva review --}}
                    <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">Agregar Nueva Review</a>
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
                    {{-- Table of Reviews --}}
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
                                <th>Nombre</th>
                                {{-- <th>Curso</th> --}}
                                <th>Calificación</th>
                                <th>Comentario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    {{-- <td>{{ $review->id }}</td> --}}
                                    <td>{{ $review->name }}</td>
                                    {{-- <td>{{ $review->title }}</td> --}}
                                    <td>{{ $review->rating }}</td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $review->comment }}</td>
                                    <td>
                                        <a href="{{ route('admin.reviews.edit', $review->id) }}"
                                            class="btn btn-sm btn-primary">Editar</a>
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
