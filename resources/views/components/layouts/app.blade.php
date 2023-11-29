@extends('adminlte::page')

@section('title', $title ?? 'Page Title')

@section('content')
    {{ $slot }}
@stop

@section('js')

@endsection

@section('plugins.Select2', true)
