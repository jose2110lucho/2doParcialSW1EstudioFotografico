@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1 style="text-align: center"><strong>MI PERFIL</strong></h1> --}}
@stop

@section('content')

<div class="card">
  <div class="card-header" style="background-color: beige">
    <h1 style="text-align: center"><strong>MI PERFIL</strong></h1>
  </div>
  <div class="card-body" style="background-color: beige">
    <main>
      <div class="photo">
        <img id="previewImage" src="{{$user->profilePhotos()->first()->profile_photo_path}}" alt="Not found">
      </div>
        <div class="form">
          <form class="form-elements" action="{{route('profile.update',$user)}}" method="post" enctype="multipart/form-data">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="{{$user->name}}" required>
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" value="{{$user->email}}" required>
            <label for="inputImagen">Imagen:</label>
            <input type="file" name="imagen" id="inputImagen" accept="image/*" onchange="previsualizarImagen()">
            <label for="password">Contraseña anterior:</label>
            <input type="password" id="password" name="password" placeholder="Contraseña anterior" required>
            <label for="newpassword">Nueva contraseña:</label>
            <input type="password" id="newpassword" name="newpassword" placeholder="Nueva contraseña" required>
            <label for="telephone">Telefono:</label>
            <input type="number" id="telephone" name="telephone" placeholder="Numero de telefono" value="{{$user->numberContacts()->first()->number}}" required>
            @if (isset($mensaje))
            <p style="color:red">
             Datos introducidos incorrectos
            </p>                
            @endif
            <input class="btn btn-success" type="submit" value="Guardar cambio">
            @csrf
            @method('POST')
            <div class="btn-container">
              @if ($user->roles->first()->name == 'Fotografo')
                <a class="btn btn-secondary" href="{{url('/select-rol/0')}}">
                  Cambiar a organizador
                </a>
              @else
              <a class="btn btn-secondary" href="{{url('/select-rol/1')}}">
                  Cambiar a Fotografo
                </a>
              @endif
            </div>
                
            
          </form>
      </div>
    </main>
    
  </div>
</div>





@stop

@section('css')
    <link rel="stylesheet" href="/css/profile-form.css">
    <style>
    form.form-elements {
    display: flex;
    flex-direction: column;
    max-width: width auto;; /* Ajusta el ancho máximo según tus necesidades */
    margin: auto;
    }

label {
    margin-top: 10px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"],
input[type="file"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.btn-container {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

input[type="submit"],
a.btn {
    background-color: #ffffff; /* Color de fondo del botón */
    color: #000000;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

a.btn-secondary {
    background-color: #ffffff; /* Color de fondo del botón secundario */
    flex: 1; /* Hace que los botones ocupen todo el espacio disponible */
    margin-right: 10px; /* Ajusta el margen derecho entre los botones según tus necesidades */
    text-align: center; /* Alinea el texto al centro dentro de los botones */
}

.photo {
    text-align: center;
}

#previewImage {
    max-width: 100%;
    height: auto;
    margin: 10px 0;
    border-radius: 300px;
    border: 1px solid #ccc;
}
    </style>
@stop

@section('js')
<script>
    function previsualizarImagen() {
        var input = document.getElementById('inputImagen');
        var imagen = document.getElementById('previewImage');

        var file = input.files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagen.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    }

    function enableChangePassword() {
        var element = document.getElementById('password-form-id');
        element.disabled = false;
        element.style.visibility = 'visible';
    }
    
</script>
@stop
