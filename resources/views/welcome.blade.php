<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PicStudioApp</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

        <style>
            body {
                background-image: url('assets/img/fondo.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                margin: 0;
            }

            header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 80px;
                background-color: #6179B7;
                display: flex;
                justify-content: space-between; /* Alinea los elementos en el centro horizontalmente */
                align-items: center;
                padding: 0 20px;
            }

            h1 {
                margin: 0;
            }

            .header-buttons {
                display: flex;
                align-items: center;
            }

            .header-buttons a {
                margin-right: 10px;
                text-decoration: none;
            }
        </style>
    </head>
    <body class="antialiased">
        <header>
            <h1 style="color: #ffffff"><strong>PicStudioApp</strong></h1>
            <div class="header-buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" style="display: inline-block; padding: 15px 30px; background-color: #ffffff; color: #000000; text-decoration: none; border: none; border-radius: 18px; cursor: pointer;"><strong>Iniciar sesion</strong></a>
    
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" style="display: inline-block; padding: 15px 30px; background-color: #ffffff; color: #000000; text-decoration: none; border: none; border-radius: 18px; cursor: pointer;"><strong>Registrar</strong></a>
                        @endif
                    @endauth
                @endif
            </div>
        </header>
    </body>
</html>
