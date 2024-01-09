@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
    <h1>Panel de administración</h1>
@endsection

@section('content')
    <p>Hola, {{Auth::user()->name}}! Desde aquí podrás administrar el sistema</p>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@endsection

@section('js')
    <script> console.log('Hi!'); </script>
@endsection