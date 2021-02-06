@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Hola {{ Auth::user()->nombre_completo }}</h2>
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Calendario de Clases</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="eventos" value="{{ $eventos }}">
            <div id="calendar"></div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('vendor/adminmart/assets/libs/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" />
@endsection

@section('javascript')
    <script src="{{ asset('vendor/adminmart/assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/fullcalendar/dist/locale/es.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/dist/js/pages/calendar/cal-init.js') }}"></script>
    
    <script>
        $(document).ready( function () {
            $('#calendar').fullCalendar("next");
            $('#calendar').fullCalendar("today");
        } );
    </script>
@endsection
