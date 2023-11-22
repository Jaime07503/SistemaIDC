@extends('layout')

@section('title')
    Informe de Búsqueda de Información
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/topicSearchReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Informe de Búsqueda de Información</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
                <a class="view" href="">Tema</a>
                <a class="view" href=""> Etapas </a>
            </nav>
        </header>
        <section class="criteria">
            <header>
                <strong><h2>Criterios</h2></strong>
            </header>
            <div>

            </div>
        </section>
        <section class="report-content">
            <header>
                <strong><h2>Datos del informe</h2></strong>
            </header>
            <div class="informationReport">
                <form action="POST">
                    <div class="basic">
                        <input type="text" name="" placeholder="Orientación del Equipo">
                        <input type="text" name="" placeholder="Plan de Búsqueda">
                        <input type="text" name="" placeholder="Reuniones">
                        <input type="text" name="" placeholder="Objetivo General">
                    </div>
                    <div class="specificObjetives">
                        
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/topicSearchReport.js') }}"></script>
@endsection