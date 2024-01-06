@extends('layout')

@section('title')
    Informe del Artículo Científico
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/topicSearchReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Datos del Artículo Científico</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
                <a class="view" href="">Tema</a>
                <a class="view" href=""> Etapas </a>
            </nav>
        </div>
        <div class="first-section article-info">
            <header>
                <strong><h2>Datos del Informe</h2></strong>
            </header>
            <div class="info-team">
                <textarea class="textarea" name="orientation" placeholder="Resumen en español"></textarea>
                <textarea class="textarea" name="orientation" placeholder="Resumen en inglés"></textarea>
                <input type="text" id="comment" placeholder="Palabras clave" autocomplete="off">
                <textarea class="textarea" name="orientation" placeholder="Introducción"></textarea>
                <textarea class="textarea" name="orientation" placeholder="Metodología"></textarea>
                <textarea class="textarea" name="orientation" placeholder="Desarrollo"></textarea>
                <textarea class="textarea" name="orientation" placeholder="Conclusiones"></textarea>
                <textarea class="textarea" name="orientation" placeholder="Referencias bibliográficas"></textarea>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/topicSearchReport.js') }}"></script>
@endsection