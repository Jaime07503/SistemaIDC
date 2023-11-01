@extends('layout')

@section('title')
    Temas de Investigación
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/temas.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Administración de Servidores</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" href="">Mis cursos</a>
                <a class="view" href="">IYA-ADS104-A-I24</a>
            </div>
        </div>
        <div class="second-content">
            <div>
                <h3>Temas de investigación</h3>
            </div>
            @foreach ($researchTopics as $topic)
            <div>
                <div class="researchTopics">
                    <div>
                        <img src="{{ asset('images/curso_logo.png') }}" class="avatarTopic" alt="Imagen">
                    </div>
                    <div class="topicContent">
                        <div class="title">
                            <div class="topic">
                                <a href="#" class="">{{ $topic->themeName }}</a>
                            </div>
                            <div class="stateStudent">
                                <div class="state">
                                    <h3>{{ $topic->state }}</h3>
                                </div>
                                <div class="students">
                                    <h3>15</h3>
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                        </div>
                        <p>{{ $topic->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/temas.js') }}"></script>
@endsection