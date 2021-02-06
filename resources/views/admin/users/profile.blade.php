@extends('layouts.adminmart.default')

@section('content')
    <div class="card">
        <div class="card-body text-center">
            <div class="profile-pic mb-3 mt-3">
                <div class="row">
                    <div class="col">
                        @if(Auth::user()->foto !== null && Auth::user()->foto !== "")
                        <img src="{{ route(Auth::user()->rol[0]->slug.'.image',['file' => Auth::user()->foto]) }}" alt="user" class="rounded-circle"
                            width="150" height="150">
                        @else
                        <img src="{{ asset('vendor/adminmart/assets/images/big/icon.png') }}" alt="user" class="img-fluid rounded-circle"
                            >
                        @endif
                    </div>
                    <div class="col">
                        <h4 class="mt-3 mb-0">{{ Auth::user()->nombre_completo }}</h4>
                        <a href="mailto:danielkristeen@gmail.com">{{ Auth::user()->email }}</a>
                        <h4 class="mt-3 mb-0">{{ $role->name }}</h4>
                        <p>Usuario: {{ Auth::user()->username }}</p>
                    </div>
                </div>
            </div>
            <div class="badge badge-pill badge-light font-16">Teléfono: <a href="tel:{{ Auth::user()->telefono }}">{{ Auth::user()->telefono }}</a></div>
            {{-- <div class="badge badge-pill badge-light font-16">Sustentacion: {{ Auth::user()->fecha_sustentacion }}</div> --}}
            {{-- <div class="badge badge-pill badge-light font-16">Folio: {{ Auth::user()->folio }}</div> --}}
            {{-- <div class="badge badge-pill badge-info font-16" data-toggle="tooltip" data-placement="top" title="3 more">+3</div> --}}
        </div>
        <div class="p-4 border-top mt-3">
            <div class="row text-center">
                <div class="col-6 border-right">
                    <h4 class="link d-flex align-items-center justify-content-center font-weight-medium">Universidad de procedencia</h4>
                    {{-- <a href="#" class="link d-flex align-items-center justify-content-center font-weight-medium">
                        <i class="mdi mdi-message font-20 mr-1"></i>
                        Soporte
                    </a> --}}
                    <p>{{ Auth::user()->universidad_procedencia }}</p>
                    <p>Especialidad: {{ Auth::user()->especialidad }}</p>
                    <div class="badge badge-pill badge-light font-16">Sustentación: {{ Auth::user()->fecha_sustentacion }}</div>
                    <div class="badge badge-pill badge-light font-16">Folio: {{ Auth::user()->folio }}</div>
                </div>
                <div class="col-6">
                    <h4 class="link d-flex align-items-center justify-content-center font-weight-medium">Documentos digitales</h4>
                    {{-- <a href="#" class="link d-flex align-items-center justify-content-center font-weight-medium">
                        <i class="mdi mdi-developer-board font-20 mr-1"></i>
                        Documentos digitales
                    </a> --}}
                    <p>
                        @if(Auth::user()->pase_ingreso !== null && Auth::user()->pase_ingreso !== "")
                            <a href="{{ URL::route(Auth::user()->rol[0]->slug.'.pase',['file' => Auth::user()->pase_ingreso]) }}" class="btn btn-secondary">
                                Pase de ingreso <i class="fas fa-download"></i>
                            </a>
                            @else
                            No disponible
                        @endif
                        @if(Auth::user()->documento_identificacion !== null && Auth::user()->documento_identificacion !== "")
                            <a href="{{ URL::route(Auth::user()->rol[0]->slug.'.documento',['file' => Auth::user()->documento_identificacion]) }}" class="btn btn-secondary">
                                Identificacion <i class="fas fa-download"></i>
                            </a>
                            @else
                            No disponible
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
