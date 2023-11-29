@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="text-align: center"><strong>Lista De Eventos</strong></h1>
@stop

@section('content')

<div class="table-responsive" style="background-color: beige">

    <table class="table caption-top" id="table_productos">
        <caption></caption>
        <thead>
            <tr>

                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Accion</th>

            </tr>
        </thead>
        <tbody>
            <p hidden>{{ $counter=1 }}</p>
            @foreach ($eventos as $evento)
                    <tr>
                        <td>{{ $counter++}}</td>
                        <td>{{ $evento->name }}</td>
                        <td>
                            <a href="{{ route('event.edit', $evento->id) }}" class="btn btn-light" ><i class="fa fa-pen"></i></a>
                            <a href="{{ route('event.show', $evento->id) }}" class="btn btn-light" ><i class="fa fa-eye"></i></a>
                            <a href="{{ route('verify.token',$evento->id) }}" class="btn btn-light"><i class="fas fa-list-alt"></i></a>
                            <form action="{{ route('event.destroy', $evento->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light" onclick="return confirm('¿Estas Seguro de Eliminarlo?')"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>

</div>
@stop

{{-- @section('js')
<script>
    function confirmarEliminacion(d) {
        if (confirm('¿Estás seguro de que quieres eliminar este evento?')) {
            // Si el usuario confirma, enviar el formulario de eliminación
            document.getElementById('form-eliminar-' + d).submit();
        }
    }
</script>
@endsection --}}