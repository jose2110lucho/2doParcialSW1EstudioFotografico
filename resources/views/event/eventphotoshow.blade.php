@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="text-align: center"><strong> {{ $eventosID->name }}</strong></h1>
@stop

@section('content')

    <style>
        .card {
            background-color:beige;
            /* Color de fondo del card */
            padding: 20px;
            /* Espaciado interno del card */
            margin: 20px;
            /* Margen exterior del card */
            border-radius: 10px;
            /* Bordes redondeados del card */
        }
    </style>

    <div class="card">
        <div class="card-body" style="min-height: 480px;">

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

            <div class="row">
                <div class="col-md-6">
                    <label for="tipos_fotografias">Tipos de fotografías permitidas en el evento:</label>

                    @if ($eventosID->privacity == '1')
                        <p type="text" class="border rounded p-2">Publicas</p>
                    @elseif($eventosID->privacity == '2')
                        <p type="text" class="border rounded p-2">Solamente invitados al evento</p>
                    @elseif($eventosID->privacity == '3')
                        <p type="text" class="border rounded p-2">Solamente fotos personales</p>
                    @endif

                    <div class="row">
                        <button type="button" class="btn-enviar"
                            onclick="window.location='{{ route('events.listEvents.photographer') }}'">Atrás</button> <br>
                        <button type="button" class="btn-enviar"
                            onclick="window.location='{{ route('event.gallery.index', $eventosID) }}'">Ver galeria</button>
                    </div>
                </div>

                <div style="border" class="col-md-6">
                    <label for="qrcode"> Llave de acceso</label>
                        <div id="qrcode"></div>                  
                </div>
            </div>
        </div>
    </div>





@stop

@section('css')
    <style>
        .centro {
            display: flex;
            justify-content: center;
            margin: 2rem;
        }

        .btn-enviar {
            background-color: #ffffff;
            padding: 0.56em;
            border-radius: 8px;
            width: 7rem;
        }

        .photo {
            margin: auto;
        }

        .border img {
            border: 1px solid black;
            background-color: red
        }

        #qrcode {
            width: 50px;
            height: 50px;
            margin: 0px;
        }

        #qrcode {
        
        }
    </style>

@stop

@section('plugins.Select2', true)

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        var qrcode = new QRCode("qrcode", {
            text: "{{$token}}",
            width: 250,
            height: 250,
            colorDark: "#000000",
            colorLight: "#FFFFFF",
            correctLevel: QRCode.CorrectLevel.H
        });
     /*   const imageFin = qrcode._oDrawing._elImage;
        imageFin.addEventListener("load", function() {
            document.getElementById('qrimage').src = imageFin.src;
            const ref = document.getElementById('reference')
             ref.href = imageFin.src;
             ref.download = "QRinvitation.png";
        });*/

        $("#text").
        on("blur", function() {
            makeCode();
        }).
        on("keydown", function(e) {
            if (e.keyCode == 13) {
                makeCode();
            }
        });
    </script>
@stop
