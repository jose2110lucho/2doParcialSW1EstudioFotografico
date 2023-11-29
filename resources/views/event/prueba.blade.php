@extends('adminlte::page')

@section('title', 'Evento | Invitados')

@section('content')
    <form action="{{ route('procesar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="file"><strong>image:</strong></label>
            <input type="file" id="image" name="image" class="form-control">
        </div>
        <button type="submit">procesar</button>
    </form>
@stop