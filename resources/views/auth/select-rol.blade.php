<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rol de usuario</title>
    <link rel="stylesheet" href="/css/select-rol-styles.css">
    <style>
        .box__option {
            text-align: center;
            margin-bottom: 20px; /* Espaciado entre las opciones */
        }

        .opcion-container {
            background-color: #ffffff; /* Color de fondo del recuadro */
            padding: 20px; /* Espaciado interno del recuadro */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra ligera */
        }

        .boton {
            display: inline-block;
            padding: 15px 30px;
            background-color: #ffffff;
            color: #000000;
            text-decoration: none;
            border: none;
            border-radius: 18px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Estilos para las imágenes */
        .box__option img {
            max-width: 200px; /* Ajusta el ancho máximo según tus necesidades */
            margin-bottom: 10px; /* Espaciado entre la imagen y el texto */
        }

        .opcion-container p {
            text-align: justify; /* Justificar el texto */
            margin: 0; /* Eliminar el margen predeterminado para que no haya espaciado adicional */
            line-height: 1.5; /* Ajustar la altura de línea para mejorar la legibilidad */
        }
    </style>
</head>
<body>
    <main>
        {{-- <div class="box"> --}}
            <div class="box__option">
                <div class="opcion-container">
                    <!-- Imagen para "Entrar como Fotógrafo" -->
                    <img src="assets/img/fotografo.jpg" alt="Fotógrafo">
                    <a class="boton" href="{{url('/select-rol/1')}}">
                        Entrar como Fotografo
                    </a>
                    <p>Sube fotografías de eventos, participa en eventos<br> sociales y vende tu contenido fotográfico.</p>
                </div>
            </div>
            <div class="box__option">
                <div class="opcion-container">
                    <!-- Imagen para "Entrar como Organizador" -->
                    <img src="assets/img/organizador.png" alt="Organizador">
                    <a class="boton" href="{{url('/select-rol/0')}}">
                        Entrar como Organizador
                    </a>
                    <p>Organiza eventos sociales, contacta con fotógrafos para cubrir<br> tus eventos, envía invitaciones por correo a tus invitados.</p>
                </div>
            </div>
        {{-- </div> --}}
    </main>
</body>
<style>
    body {
               background-image: url('assets/img/fondo.jpg');
               background-size: cover;
               background-repeat: no-repeat;
               margin: 0;
           }
</style>
</html>

