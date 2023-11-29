@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="text-align: center"><strong> {{ $eventosID->name }}</strong></h1>
@stop

@section('content')

    <style>
        .card {
            background-color: #ffffff; /* Color de fondo del card */
            padding: 20px; /* Espaciado interno del card */
            margin: 20px; /* Margen exterior del card */
            border-radius: 10px; /* Bordes redondeados del card */
        }
    </style>

<div class="card" style="background-color: beige">
    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <p type="text" class="border rounded p-2">{{ $eventosID->start_date }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="hora">Hora:</label>
                    <p type="text" class="border rounded p-2">{{ $eventosID->start_time }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <p type="text" class="border rounded p-2">{{ $eventosID->detail }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <p type="text" class="border rounded p-2">{{ $eventosID->address }}</p>
                </div>
            </div>
        </div>

        <div class="form-group col-md-12">
            <label for="tipos_fotografias">Tipos de fotografías permitidas en el evento:</label>

            @if($eventosID->privacity == '1')
                <p type="text" class="border rounded p-2">Publicas</p>
            @elseif($eventosID->privacity == '2')
                <p type="text" class="border rounded p-2">Solamente invitados al evento</p>
            @elseif($eventosID->privacity == '3')
                <p type="text" class="border rounded p-2">Solamente fotos personales</p>
            @endif
        </div>

        <div class="text-right mb-3">
            <a href="{{route('events.guests', ['event' => $eventosID->id])}}" class="btn btn-primary"><strong>Lista de Invitados</strong></a>
            <a href="{{route('events.photographers', ['event' => $eventosID->id])}}" class="btn btn-success"><strong>Lista de Fotógrafos</strong></a>
        </div>

        <div class="form-group col-md-12 text-center">
            <button type="button" class="btn-enviar" onclick="window.location='{{ route('event.index') }}'">Atrás</button>
        </div>

    </div>
</div>


    
    

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

      <style>
          .centro{
              display:flex;
              justify-content: center;
              margin:2rem;
          }

          .btn-enviar{
              background-color:#ffffff;
              padding:0.56em;
              border-radius:8px;
              width:7rem;
          }

          .photo{
            margin:auto;
          }
      </style>
    
@stop

@section('plugins.Select2', true)

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var select = document.getElementById("tipos_fotografias");
        $('#select').select2({
                placeholder: 'Elija una opcion',
                dropdownAutoWidth: true,
            });
        var hiddenInput = document.getElementById("tipos_fotografias_seleccionadas");

        select.addEventListener("change", function () {
            var selectedOptions = Array.from(select.selectedOptions).map(option => option.value);
            hiddenInput.value = JSON.stringify(selectedOptions);
        });
    });
</script>

@stop