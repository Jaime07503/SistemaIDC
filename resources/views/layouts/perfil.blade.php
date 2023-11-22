@extends('layout')

@section('title')
    {{ session('name')}}: Perfil público
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/perfil.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Perfil del usuario</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" href="{{ url('/perfil') }}">Perfil</a>
            </div>
        </div>
        <div class="info-content">
            <div class="header-title">
                <h2>Datos generales</h2>
            </div>
            <div class="info-top">
                <div class="perfil">
                    <img class="avatar-user" src="{{ session('avatarUrl') }}" alt="Avatar">
                    <h2>{{ session('name') }}</h2>
                    <a href="">Editar Perfil</a>
                </div>
                <div class="datos-perfil">
                    <h3>Detalles del usuario</h3>
                    <h4>Dirección Email</h4>
                    <p>mario.martinez4@catolica.edu.sv</p>
                    <h4>Insignias IDC</h4>
                    <div class="badge">
                        <i class="fa-solid fa-certificate"></i>
                        <i class="fa-solid fa-certificate"></i>
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                </div>
                <div class="datos-perfil">
                    <h3>Actividad de ingresos</h3>
                    <h4>Primer acceso al sitio</h4>
                    <p>Thursday, 5 de January de 2023, 20:12  (265 días 19 horas)</p>
                    <h4>Último acceso al sitio</h4>
                    <p>Thursday, 28 de September de 2023, 15:37  (3 segundos)</p>
                </div>
            </div>
            <div class="info-bottom">
                <h2>Detalles de las investigaciones de catedra</h2>
                <a href="">Servidores web</a>
                <a href="">Servidores de correo</a>
                <a href="">Servidores de archivos</a>
            </div>
        </div>
    </main>
@endsection