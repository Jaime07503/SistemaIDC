@extends('layout')

@section('title')
    Etapas del Proceso
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/stagesProcess.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>{{ $researchTopic->themeName }}</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
                <a class="view" href="">{{ $researchTopic->themeName }}</a>
                <a class="view" href=""> Etapas </a>
            </nav>
        </header>
        <section class="stages-content">
            <div class="head">
                <i class="fa-solid fa-puzzle-piece"></i>
                <header><h2>Etapas del proceso</h2></header>
            </div>
            <div class="stages">
                <div class="stage">
                    <img src="{{ asset('images/robot.webp') }}" alt="" class="logo-stage">
                    <div class="footer-card">
                        <i class="fa-solid fa-circle-info"></i>
                        <a href="{{ url('/processInfo') }}" class="link">Información del Proceso</a>
                    </div>
                </div>
                <div class="stage">
                    <img src="{{ asset('images/search.webp') }}" alt="" class="logo-stage">
                    <div class="footer-card">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <a href="{{ url('/searchInformation') }}" class="link">Búsqueda de Información</a>
                    </div>
                </div>
                <div class="stage">
                    <img src="{{ asset('images/article.webp') }}" alt="" class="logo-stage">
                    <div class="footer-card">
                        <i class="fa-solid fa-atom"></i>
                        <a href="#" class="link">Artículo Científico</a>
                    </div>
                </div>
                <div class="stage">
                    <img src="{{ asset('images/end.webp') }}" alt="" class="logo-stage">
                    <div class="footer-card">
                        <i class="fa-solid fa-hourglass-end"></i>
                        <a href="#" class="link">Finalización del Proceso</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/stagesProcess.js') }}"></script>
@endsection