@extends('layout')

@section('title')
    Búsqueda de Información
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/searchInformation.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Informe y ordenamiento de búsqueda del tema</h1>
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
                <strong><h2>Status de la Entrega</h2></strong>
            </header>
            <table class="table content-table">
                <tbody>
                    <tr>
                        <td><strong>Status del informe</strong></td>
                        <td>Sin intento</td>
                    </tr>
                    <tr>
                        <td><strong>Status de calificación</strong></td>
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
                        <td><strong>Comentarios al envío</strong></td>
                        <td>No hay comentarios por el momento</td>
                    </tr>
                </tbody>
            </table>
            <div class="title">
                <a href="{{ url('/topicSearchReport') }}" class="btn-login">
                    <i class="fa-solid fa-square-plus"></i>
                    <h4>Crear Informe</h4>
                </a>
            </div>
        </div>
        <!-- <div class="info-content">
            <div class="status">
                <h2>Status de la entrega</h2>
                <div class="title">
                    <h3>Estatus del informe</h3>
                    <h3>Sin intento</h3>
                </div>
                <div class="title">
                    <h3>Tiempo restante</h3>
                    <h3>1 hora 30 minutos 60 segundos</h3>
                </div>
                <div class="title">
                    <h3>Fecha de entrega</h3>
                    <h3>Miercoles 16 de marzo 2024</h3>
                </div>
                <div class="title">
                    <h3>Comentarios al envío</h3>
                    <h3>--------------------</h3>
                </div>
                <div class="title">
                    <a href="{{ url('/topicSearchReport') }}" class="btn-login">
                        <i class="fa-solid fa-square-plus"></i>
                        <h4>Crear Informe</h4>
                    </a>
                </div>
            </div>
        </div> -->
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/searchInformation.js') }}"></script>
@endsection