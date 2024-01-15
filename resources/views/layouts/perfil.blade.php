@extends('layout')

@section('title')
    {{ session('name')}}: Perfil público
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/perfil.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1 class="head-lbl">Perfil del usuario</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" href="">Perfil</a>
            </div>
        </header>
        <section class="user-info-content">
            <div class="info-top">
                <div class="perfil">
                    <img class="avatar-user" src="{{ session('avatarUrl') }}" alt="Avatar">
                    <h2>{{ $user->name }}</h2>
                    <a href="">Editar Perfil</a>
                    <h4>Dirección Email</h4>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="datos-perfil">
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
                    <p>{{ $user->firstLogin }}</p>
                    <h4>Último acceso al sitio</h4>
                    <p>Thursday, 28 de September de 2023, 15:37  (3 segundos)</p>
                </div>
            </div>
            <aside class="info-bottom">
                <h2>Detalles de las investigaciones de catedra</h2>
                <a href="">Servidores web</a>
                <a href="">Servidores de correo</a>
                <a href="">Servidores de archivos</a>
            </aside>
        </section>
    </main>
@endsection