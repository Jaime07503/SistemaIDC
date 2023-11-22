@extends('layout')

@section('title')
    Búsqueda de Información
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/searchInformation.css') }}">
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
        <section class="description-content">
            <h2>Descripción del tema</h2>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur atque nisi, aut fuga voluptatum fugiat incidunt ut aliquam earum placeat animi accusamus recusandae aspernatur qui quos. Fugiat, esse adipisci! Ipsa!</p>
        </section>
        <section class="info-content">
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
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/searchInformation.js') }}"></script>
@endsection