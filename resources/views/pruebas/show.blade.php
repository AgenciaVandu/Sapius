@extends('layouts.adminmart.detalle')

@section('content')

<table class="table table-borderless table-striped">
    <tbody>
        <tr>
            <th scope="row">Titulo:</th>
            <td>{{ $prueba->titulo }}<td>
        </tr>
        <tr>
            <th scope="row">Descripcion:</th>
            <td>{!! $prueba->descripcion !!}<td>
        </tr>
    </tbody>
</table>

@endsection

@section('javascript')
   <script>
        $(".modal-title").html("Detalles");
    </script>
@endsection
