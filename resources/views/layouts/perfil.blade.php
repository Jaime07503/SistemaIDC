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
            <div class="info-top">
                <div class="perfil">
                    <img class="avatar-user" src="{{ session('avatarUrl') }}" alt="Avatar">
                    <h2>{{ session('name') }}</h2>
                </div>
                <div class="datos-perfil">
                    <h2>Detalles del usuario</h2>
                    <h3>Dirección Email</h3>
                    <a href="">mario.martinez4@catolica.edu.sv</a>
                    <h3>Insignias IDC</h3>
                    <div class="badge">
                        <i class="fa-solid fa-certificate"></i>
                        <i class="fa-solid fa-certificate"></i>
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                </div>
                <div class="datos-perfil">
                    <h2>Actividad de ingresos</h2>
                    <h3>Primer acceso al sitio</h3>
                    Thursday, 5 de January de 2023, 20:12  (265 días 19 horas)
                    <h3>Último acceso al sitio</h3>
                    Thursday, 28 de September de 2023, 15:37  (3 segundos)
                </div>
            </div>
            <div class="info-bottom">
                <h2>Detalles de las investigaciones de catedra</h2>
                <a href="">Tiristores</a>
                <a href="">Flip-Flop</a>
                <a href="">Servidores web</a>
            </div>
        </div>
    </main>
@endsection