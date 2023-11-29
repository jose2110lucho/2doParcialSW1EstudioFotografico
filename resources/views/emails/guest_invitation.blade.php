<div>
    Hola, Espero que te encuentres bien. <br>
    Queríamos invitarte al evento llamado {{ $mailData['event_name'] }}. <br><br>
    Detalles del evento: <br>
    Fecha y hora: {{ $mailData['start_date'] }} - {{ $mailData['start_time'] }} <br>
    Lugar: {{ $mailData['address'] }} <br><br>
    Esperamos contar con tu presencia. Para confirmar tu asistencia, por favor haz clic en
    el siguiente enlace: <br><br>

    <a href="{{ $mailData['url'] }}">Ver invitacion</a> <br><br>

    Saludos <br>
    {{ $mailData['sender_name'] }}
</div>
