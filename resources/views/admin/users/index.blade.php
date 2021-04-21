@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    @if($active == "enable")
                        Administración de usuarios
                    @else
                        Administración de usuarios Inactivos
                    @endif
                </h3>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <div class="dropdown float-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if($active == "enable")
                                    <a class="dropdown-item" href="{{ URL::route('users.index',['active' => 'disable']) }}">Usuarios inactivos</a>
                                    @else
                                    <a class="dropdown-item" href="{{ URL::route('users.index') }}">Usuarios activos</a>
                                    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if(session()->get('success'))
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Actualizado ! - </strong> {{ session()->get('success') }}
                </div>
                {{-- <div class="alert alert-success">
                {{ session()->get('success') }}
                </div><br /> --}}
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Rol</th>
                                    @if($active == "enable")
                                    <th class="no-sort">Editar</th>
                                    @endif
                                    <th class="no-sort" >
                                        @if($active == "enable")
                                        Desactivar
                                        @else
                                        Activar
                                        @endif
                                    </th>
                                    <th class="no-sort">Detalles</th>
                                    <th>Validado</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->nombre }}</td>
                                    <td>{{ $user->apellido }}</td>
                                    <td>{{ $user->roles[0]->name }}</td>
                                    @if($active == "enable")
                                    <td><a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}"><i class="far fa-edit"></i></a></td>
                                    @endif
                                    <td>
                                        {{ Form::open(['route' => ['users.destroy', $user->id],'class'=> 'btn-group inline']) }}
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-primary" type="submit">@if($active == "enable")<i class="fas fa-trash"></i> @else <i class="fas fa-check"></i> @endif</button>
                                    {{ Form::close() }}
                                    </td>
                                    <td><a class="btn btn-primary btn-detalle" href="javascript:void(0)" id="{{ route('users.show',$user->id) }}"><i class="fas fa-eye"></i></a></td>
                                    <td>
                                     @if($user->validado == "si")
                                     SI
                                     @else
                                     NO
                                     @endif
                                    </td>
                                    <td>
                                        {{-- <a class="btn btn-primary btn-detalle" href="javascript:void(0)" id="{{ route('users.show',$user->id) }}"><i class="fas fa-clipboard-check"></i></a> --}}
                                        <div class="dropleft">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Acciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                {{-- @if($user->validado == "no") --}}
                                                <a class="btn btn-primary btn-detalle ml-2" href="javascript:void(0)" id="{{ route('users.verify',$user->id) }}">
                                                    <i class="fas fa-clipboard-check"></i> Validar datos
                                                </a>
                                                {{-- @endif --}}
                                            </div>
                                          </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="thead-light">
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Rol</th>
                                    @if($active == "enable")
                                    <th>Editar</th>
                                    @endif
                                    <th>
                                        @if($active == "enable")
                                        Desactivar
                                        @else
                                        Activar
                                        @endif
                                    </th>
                                    <th>Detalles</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('javascript')
    <script src="{{ asset('vendor/adminmart/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/users/index.datatables.js') }}"></script>
    <script src="{{ asset('js/funciones.js') }}"></script>
@endsection
