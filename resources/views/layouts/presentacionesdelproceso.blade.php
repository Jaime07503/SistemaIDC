@extends('layout')

@section('title')
    {{ session('name')}}: Informacion del proceso
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/perfil.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Informacion del Proceso</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" href="{{ url('/perfil') }}">Mis Cursos</a>
                <a class="view" href="{{ url('/perfil') }}">TE-A-I2024</a>
                <a class="view" href="{{ url('/perfil') }}">MLI2024</a>
                <a class="view" href="{{ url('/perfil') }}">Informacion</a>
                <a class="view" href="{{ url('/perfil') }}">Presentaciones</a>
            </div>
            <div class="main-content">
                <h3>Presentaciones sobre el Proceso</h3>
                <div class="main-center">
                    <h2><strong>Informacion de busqueda de informacion</strong></h2>
                    <h4>Presentacion sobre como crear el informe de busqueda de informacion del tema.</h4>
                    <i class="fi fi-sr-file-powerpoint">Elaboracion-del-informe-busqueda-de-informacion.pptx</i>
                </div>
                <div class="main-center">
                    <h2><strong>Articulo Bibliografico</strong></h2>
                    <h4>Presentacion sobre como crear el informe de busqueda de informacion del tema.</h4>
                    <i class="fi fi-sr-file-powerpoint">Partes-de-un-articulo-bibliografco.pptx</i>
                </div>
            </div>
        </div>
    </main>
@endsection

