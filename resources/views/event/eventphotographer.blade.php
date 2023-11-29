@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop

@section('content')

<div class="card" style="background-color: beige">
    <div class="card-header">
        <h1 style="text-align: center"><strong>Lista De Eventos</strong></h1>
    </div>
    <div class="card-body">
        <div class="table-responsive">

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
                                <td>{{ $evento->event()->name }}</td>
                                <td>
                                    <a href="{{ route('events.listEvents.photographer.show', $evento->event()->id) }}" class="btn btn-light" ><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('event.gallery.create', $evento->event()->id) }}" class="btn btn-light" ><i class="fa fa-upload" aria-hidden="true"></i></a>
                                    <a href="{{ route('event.gallery.index', $evento->event()->id) }}" class="btn btn-light" ><i class="fa fa-archive" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        
        </div>
    </div>
  </div>







@stop
