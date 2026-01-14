@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Hola
                    {{ Auth::user()->nombre_completo }}</h2>
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Calendario de Clases</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        @if (isset($weekly_calendars) && $weekly_calendars->count() > 0)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title">Calendarios Semanales</h4>
                        @foreach ($weekly_calendars as $cal)
                            <div class="mb-3">
                                <a href="javascript:void(0)"
                                    onclick="showImage('{{ asset('storage/' . $cal->image_path) }}')">
                                    <img src="{{ asset('storage/' . $cal->image_path) }}" class="img-fluid"
                                        alt="Calendario Semanal" style="cursor: pointer;">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        {{-- <div class="col-md-12">
            <input type="hidden" id="eventos" value="{{ $eventos }}">
            <div id="calendar"></div>
        </div> --}}
    </div>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Vista Previa del Calendario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid" alt="Calendario Grande">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('vendor/adminmart/assets/libs/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" />
@endsection

@section('javascript')
    {{-- <script src="{{ asset('vendor/adminmart/assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/fullcalendar/dist/locale/es.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/dist/js/pages/calendar/cal-init.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar("next");
            $('#calendar').fullCalendar("today");
        });
    </script> --}}

    <script>
        function showImage(src) {
            $('#modalImage').attr('src', src);
            $('#imageModal').modal('show');
        }
    </script>
@endsection
