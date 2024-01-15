@extends('layout')

@section('title')
    Informe de Temas para siguiente IDC
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/topicSearchReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Datos del informe de temas para siguiente IDC</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
                <a class="view" href="">Tema</a>
                <a class="view" href=""> Etapas </a>
            </nav>
        </header>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/topicSearchReport.js') }}"></script>
@endsection