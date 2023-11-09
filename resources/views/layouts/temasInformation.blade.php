@extends('layout')

@section('title')
    Información de {{ $researchTopic->themeName }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/temasInformation.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>{{ $researchTopic->themeName }}</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" href="">Mis cursos</a>
                <a class="view" href="">IYA-ADS104-A-I24</a>
                <a class="view" href="">{{ $researchTopic->themeName }}</a>
            </div>
        </div>
        <div class="information-content">
            <div class="left-content">
                <img src="{{ asset('images/curso_logo.png') }}" alt="" class="avatarTopic">
                <div class="information">
                    <p>{{ $researchTopic->description }}</p>
                </div>
                <button type="submit" class="btn">Postularse</button>
            </div>
            <div class="right-content">
                <h4>Grupos creados para este tema actualmente</h4>
                <div class="team-content">
                    <h3>Equipo 1</h3>
                    <div class="students">
                        <div class="student">
                            <img src="{{ session('avatarUrl') }}" alt="" class="ava">
                            <h4>Mario Jaime Martínez Herrera</h4>
                        </div>
                        <div class="student">
                            <img src="{{ session('avatarUrl') }}" alt="" class="ava">
                            <h4>Mario Jaime Martínez Herrera</h4>
                        </div>
                        <div class="student">
                            <img src="{{ session('avatarUrl') }}" alt="" class="ava">
                            <h4>Mario Jaime Martínez Herrera</h4>
                        </div>
                        <div class="student">
                            <img src="{{ session('avatarUrl') }}" alt="" class="ava">
                            <h4>Mario Jaime Martínez Herrera</h4>
                        </div>
                    </div>
                </div>
                <div class="team-content">
                    <h3>Equipo 2</h3>
                    <div class="students">
                        <div class="student">
                            <img src="{{ session('avatarUrl') }}" alt="" class="ava">
                            <h4>Mario Jaime Martínez Herrera</h4>
                        </div>
                        <div class="student">
                            <img src="{{ session('avatarUrl') }}" alt="" class="ava">
                            <h4>Mario Jaime Martínez Herrera</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection