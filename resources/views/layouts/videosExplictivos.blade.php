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
                <a class="view" href="{{ url('/videosExplicativos}}">Videos</a>
            </div>
            <div class="main-content-ms">
                <div class="container-info">
                    <h3>Videos Sobre los IDC</h3>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen autoplay></iframe>
                </div>
            </div>
@endsection
