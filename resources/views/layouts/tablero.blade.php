@extends('layout')

@section('title')
    Tablero
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/tablero.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Tablero</h1>
        </div>
        <!-- Contenido Vista general de las investigaciones -->
        <div class="courses-content">
            <div class="head-lbl">
                <h3>Vista general de las investigaciones</h3>
            </div>
            <div class="options-courses">
                <!-- Listbox -->
                <div class="custom-listbox">
                    <div class="listbox-header">
                        <span class="selected-option">Todos</span>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li>Todos</li>
                        <li>En progreso</li>
                        <li>Pasados</li>
                    </ul>
                </div>
                <!-- Entrada de Texto -->
                <div class="custom-input">
                    <input type="text" placeholder="Buscar">
                </div>
                <!-- Listbox -->
                <div class="custom-listbox">
                    <div class="listbox-header">
                        <span class="selected-option">Nombre del curso</span>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li>Nombre del curso</li>
                        <li>Último accedido</li>
                    </ul>
                </div>
            </div>
            <!-- Investigaciones -->
            <div class="courses">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ciclo I 2024</h5>
                            <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                            <a href="#" class="card-link">Servidores Web</a>
                            <h4>100% progreso</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ciclo I 2024</h5>
                            <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                            <a href="#" class="card-link">Servidores de correo</a>
                            <h4>100% progreso</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ciclo I 2024</h5>
                            <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                            <a href="#" class="card-link">Servidores de archivos</a>
                            <h4>80% progreso</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection