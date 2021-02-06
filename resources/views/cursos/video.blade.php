@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Agregar Curso</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.menu',['form' => 'Lecciones'])
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
                    <video width="600" height="337.5" controls controlsList="nodownload" src="http://elearning.dev.local/alumno/cursos/stream/laravel.mp4">
                        Your browser does not support the video tag.
                    </video>
                    <hr>
                    Video
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready( function () {

        } );
    </script>
@endsection
