@extends('layout')

@section('title')
    Informe del Artículo Científico
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/scientificArticleReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1 class="head-lbl">Datos del Artículo Científico</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" >Mis cursos</a>
                <a class="history-view" href="">ADS104-A-I24</a>
                <a class="history-view" href="">Tema</a>
                <a class="history-view" href=""> Etapas </a>
            </nav>
        </header>
        <section class="scientific-article-content">
            <strong><h2>Datos del Informe</h2></strong>
            <form id="myForm" class="scientific-article" action="{{ route('generate-scientific-article') }}" method="POST">
                @csrf
                <textarea class="textarea" name="spanishSummary" placeholder="Resumen en español"></textarea>
                <textarea class="textarea" name="englishSummary" placeholder="Resumen en inglés"></textarea>
                <input type="text" id="comment" name="keywords" placeholder="Palabras clave" autocomplete="off">
                <textarea class="textarea" name="introduction" placeholder="Introducción"></textarea>
                <textarea class="textarea" name="methodology" placeholder="Metodología"></textarea>
                <!-- <textarea class="textarea" name="" placeholder="Desarrollo"></textarea> -->
                <textarea class="textarea" name="conclusion" placeholder="Conclusiones"></textarea>
                <textarea class="textarea" name="bibliographicReferences" placeholder="Referencias bibliográficas"></textarea>
                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                <button type="submit" class="btn">Agregar</button>
            </form>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/topicSearchReport.js') }}"></script>
@endsection