@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="text-align: center"><strong> Editar Evento </strong></h1>
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
            <form action="{{route('event.update', $eventoId->id)}}" method="POST" id="formulario">
                {{ method_field('PUT') }}
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">

                   {{--  campo nombre --}}
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ $eventoId->name }}">
                  </div>

                  {{-- campo fecha --}}
                  <div class="form-group col-md-3">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required value="{{ $eventoId->start_date }}">
                  </div>

                  {{-- campo hora --}}
                  <div class="form-group col-md-3">
                    <label for="hora">Hora</label>
                    <input type="time" class="form-control" id="hora" name="hora" required value="{{ $eventoId->start_time }}">
                  </div>
                </div>
                
                <div class="form-row">
                 {{-- campo descripcion --}}   
                <div class="form-group col-md-6">
                  <label for="descripcion">Descripcion</label>
                   <textarea class="form-control" id="descripcion" name="descripcion" style="text-align:left" required>
                    {{ $eventoId->detail}}
                  </textarea>
                </div>

                {{-- campo direccion --}}
                <div class="form-group col-md-6">
                    <label for="direccion">Direccion</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required value="{{ $eventoId->address }}">
                  </div>
                </div>
                
               
                {{-- <div class="form-group col-md-10 photo">
                    <label>Tipos de fotografias permitidas en el evento</label>
                    <select class="form-control select2" name="tipos_fotografias" id="tipos_fotografias" style="width: 100%;">
                        <option value="{{ null }}">Elija una opcion</option>
                        <option value="1" >Publicas</option>
                        <option value="2">Solamente invitados al evento</option>
                        <option value="3">Solamente fotos personales</option>
                    </select>
                </div> --}}

                <div class="form-group col-md-10 photo">
                    <label>Tipos de fotografias permitidas en el evento   {{ $eventoId->privacity }}</label>
                    
                    <select class="form-control select2" name="tipos_fotografias" id="tipos_fotografias" style="width: 100%;">
                        {{-- <option value="{{ null }}">Elija una opcion</option> --}}
                        <option value="1" {{ $eventoId->privacity == 1 ? 'selected' : '' }}>Publicas</option>
                        <option value="2" {{ $eventoId->privacity == 2 ? 'selected' : '' }}>Solamente invitados al evento</option>
                        <option value="3" {{ $eventoId->privacity == 3 ? 'selected' : '' }}>Solamente fotos personales</option>
                    </select>
                </div>

                

                
                {{-- boton de creacion de evento --}}
                <div class="form-row">
                    <div class="form-group col-md-12 text-right mt-4">
                        <button type="submit" class="btn-enviar">Actualizar</button>
                        <button type="button" class="btn-enviar" onclick="window.location='{{ route('event.index') }}'">Atrás</button>
                    </div>
                </div>
                
                
                
                
            </form>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var formulario = document.getElementById("formulario");
        var descripcionInput = document.getElementById("descripcion");

        formulario.addEventListener("submit", function (event) {
            if (!descripcionInput.value.trim()) {
                alert("Por favor, ingresa una descripción.");
                event.preventDefault(); // Evita que el formulario se envíe si la validación falla
            }
        });
    });
</script>

       

@stop