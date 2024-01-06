@extends('layout')

@section('title')
    Artículo Científico
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/searchInformation.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Artículo Científico</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
                <a class="view" href="">Tema</a>
                <a class="view" href=""> Etapas </a>
            </nav>
        </div>
        <div class="info-content">
            <header>
                <strong><h2>Estatus de la Entrega</h2></strong>
            </header>
            <table class="table content-table">
                <tbody>
                    <tr>
                        <td><strong>Estatus del informe</strong></td>
                        <td>Sin intento</td>
                    </tr>
                    <tr>
                        <td><strong>Estatus de calificación</strong></td>
                        <td>No calificado</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de entrega</strong></td>
                        <td>Miercoles 16 de marzo 2024</td>
                    </tr>
                    <tr>
                        <td><strong>Tiempo restante</strong></td>
                        <td>1 hora 30 minutos 60 segundos</td>
                    </tr>
                    <tr>
                        <td><strong>Archivo generado</strong></td>
                        <td>Sin intento</td>
                    </tr>
                    <tr>
                        <td><strong>Comentarios al envío</strong></td>
                        <td>No hay comentarios por el momento</td>
                    </tr>
                </tbody>
            </table>
            <div class="title">
                <a href="{{ url('/scientificArticleReport') }}" class="btn-login">
                    <i class="fa-solid fa-square-plus"></i>
                    <h4>Crear Informe</h4>
                </a>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/searchInformation.js') }}"></script>
@endsection