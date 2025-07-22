@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    {{ Auth::user()->nombre_completo }}</h2>
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Guias disponibles</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-columns">
                @foreach ($cursos as $curso)
                    @if ($curso->curso->activo == 'si' && $curso->category_id == $category->id)
                        <div class="card shadow">
                            <a href="javscript:void(0)"
                                onclick="event.preventDefault(); document.getElementById('curso-{{ $curso->id }}').submit();">
                                @if ($curso->Curso->imagen)
                                    <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                                        id="img" alt="..." class="img-thumbnail">
                                @else
                                    <img class="card-img-top img-fluid"
                                        src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                                        alt="Card image cap">
                                @endif
                            </a>
                            <form method="POST" action="{{ route('cursos.detallado') }}" id="curso-{{ $curso->id }}">
                                @csrf
                                <input name="curso_programado_id" type="hidden" value="{{ $curso->id }}">
                            </form>
                            <div class="card-body">
                                <h4 class="card-title">{{ $curso->Curso->titulo }} <span
                                        class="badge badge-primary">{{ $curso->identificador }}</span></h4>
                                <p class="card-text">{!! $curso->Curso->descripcion !!}</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4> ${{ $curso->precio_en_moneda }} MxN</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="{{ route('inscripcion.form',['curso_programado_id'=>$curso->id]) }}" class="btn btn-block btn-dark btn-detalle">Inscribir</a>
                                        <a href="javscript:void(0)" class="btn btn-primary btn btn-block mt-2"
                                            onclick="event.preventDefault(); document.getElementById('curso-{{ $curso->id }}').submit();">
                                            Mas detalles
                                        </a>
                                        <!-- Button trigger modal -->
                                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal{{ $curso->id }}">
                                            Inscribir
                                        </button> --}}

                                        <!-- Modal -->
                                        {{-- <div class="modal fade" id="exampleModal{{ $curso->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ $curso->Curso->titulo }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Estimado estudiante, este acceso está disponible exclusivamente para
                                                        aquellos alumnos que hayan completado su inscripción al curso y
                                                        enviado el comprobante de pago correspondiente.<br><br>

                                                        Instrucciones:<br><br>

                                                        <ul>
                                                            <li>Verifique su inscripción: <br>Asegúrese de haber realizado
                                                                el
                                                                pago
                                                                completo del curso.
                                                            </li><br>
                                                            <li>Envíe su comprobante de pago: <br>Este paso es necesario
                                                                para
                                                                procesar
                                                                su inscripción.</li><br>
                                                            <li class="text-danger">Si aún no ha realizado el pago del
                                                                curso, le solicitamos que
                                                                no
                                                                intente realizar esta acción para evitar cualquier
                                                                inconveniente en
                                                                el proceso de acceso a la plataforma.</li>
                                                        </ul>
                                                        Apreciamos su comprensión y estamos aquí para cualquier duda o
                                                        aclaración que pueda tener sobre el proceso de inscripción.
                                                        ¡Esperamos que tenga una excelente experiencia de aprendizaje!
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cerrar</button>
                                                        <form action="{{ route('inscripcion.pago') }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input name="curso_programado_id" type="hidden"
                                                                value="{{ $curso->id }}">
                                                            <button type="submit"
                                                                class="btn btn-primary">Confirmar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>



    {{-- <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <form action="{{ route('inscripcion.pago') }}" method="post">
                        @csrf
                        @method('POST')
                        <h5 class="modal-title">Titulo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Comprar</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('cursoid') // Extract info from data-* attributes
            console.log(id)
            //var id = button.getAttribute('data-cursoid');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            //var modal = $(this)
            //console.log(id)
            var b = document.querySelector(".modal-footer form input")
            console.log(b)
            //modal.find('.modal-footer form button').setAttribute('value',''+recipient);
            //var buttonid = console.log(modal.find('.modal-footer form button'))
            b.setAttribute("value", id)
        })
    </script>
@endsection
