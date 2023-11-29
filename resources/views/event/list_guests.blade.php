@extends('adminlte::page')

@section('title', 'Evento | Invitados')

@section('content')
    
@stop


@section('js')
    <script>
        var form = document.getElementById("invitationForm");
        form.addEventListener("submit", function(event) {
            event.preventDefault();

            var datos = new FormData(form);
            datos.append('event_id', '{{$event->id}}');
            console.log(datos);

            var request = fetch('{{ route('api.invitations.store') }}', {
                method: "POST",
                body: datos
            });

            request.then(function(response) {
                if (response.ok) {
                    $('#email_receiver').val('');
                    $('#inviteModal').modal('hide');
                    $('#email_receiver').val('');
                } else {
                    console.log(response);
                    throw new Error("Ha ocurrido un problema con la petición");
                }
            }).then(function(texto) {
                console.log(texto);
            }).catch(function(error) {
                console.error(error);
            });
        });
    </script>
@stop

@section('content_top_nav_right')
    @include('notifications.dropdown')
@endsection
