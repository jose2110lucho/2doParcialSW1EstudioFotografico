@extends('adminlte::page')

@section('title', 'Evento | Invitados')

@section('content')
    @if ($response['status'] == 'success')
        @switch($response['invitation']['status'])
            @case(0)
                invitacion al evento {{ $response['invitation']['event_name'] }}

                <a href="{{ route('guests.invitations.reject', $response['invitation']['id']) }}" class="btn btn-primary">Rechazar</a>
                <a href="{{ route('guests.invitations.accept', $response['invitation']['id']) }}" class="btn btn-primary">Aceptar</a>
            @break

            @case(1)
                La invitacion al evento "{{ $response['invitation']['event_name'] }}" ha sido aceptada.
            @break

            @case(2)
                La invitacion al evento "{{ $response['invitation']['event_name'] }}" ha sido rechazada.
            @break

            @default
        @endswitch
    @else
        {{ $response['message'] }}
    @endif

@stop

@section('js')

@stop
