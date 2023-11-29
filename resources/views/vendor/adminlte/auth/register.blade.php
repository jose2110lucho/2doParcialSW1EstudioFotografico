@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('auth_body')
    <form action="{{ $register_url }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="imagen-cont">
            <img id="img">
        </div>

        {{-- campo nombre --}}
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- campo email --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- campo contraseña --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('adminlte::adminlte.password') }}">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- campo confirmar contraseña --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="{{ __('adminlte::adminlte.retype_password') }}">

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- campo telefono --}}
        <div class="input-group mb-3">
            <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
                value="{{ old('telephone') }}" placeholder="{{ __('adminlte::adminlte.telephone') }}" autofocus>

            @error('telephone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- campo subir foto de perfil --}}
        <div class="form-group">
            <label for="imagen"><strong>Foto Perfil:</strong></label>
            <input accept="image/*" type="file" id="imagen" name="imagen"
                class="form-control @error('imagen') is-invalid @enderror" onchange="mostrar()">
            @error('imagen')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Boton registrar --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}"
            style="background-color: #6179B7; color: #ffffff; border-radius: 18px;">
            {{ __('adminlte::adminlte.register') }}
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop


@section('formularioImagen')
    <style>
        .imagen-cont img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin-bottom: 20px;
        }
    </style>
    <script>
        function mostrar() {
            var archivo = document.getElementById("imagen").files[0];
            var reader = new FileReader();
            if (imagen) {
                reader.readAsDataURL(archivo);
                reader.onloadend = function() {
                    document.getElementById("img").src = reader.result;
                }
            }
        }
    </script>
@endsection

<style>
    body {
               background-image: url('assets/img/fondo.jpg');
               background-size: cover;
               background-repeat: no-repeat;
               margin: 0;
           }
</style>
