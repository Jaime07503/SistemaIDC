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
            </div>
        </div>
        <div class="info-content">
            <div class="header-title">
                <h2>Informacion Explicita sobre los IDC</h2>
            </div>
                <div class="datos-perfil">

                    <H5>Videos Explicativos</H5>
                </div>
                <div class="datos-perfil">
                    <h5>Presentaciones</h5>

                </div>
            </div>
            <div class="info-bottom">
                <h5>Documentacion</h5>

            </div>
        </div>
    </main>
@endsection
