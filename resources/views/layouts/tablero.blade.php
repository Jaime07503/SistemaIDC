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
                <h2>Vista general de las investigaciones</h2>
            </div>
            <div class="options-courses">
                <!-- Listbox -->
                <div class="custom-listbox">
                    <div class="listbox-header">
                        <button id="listbox"><span class="selected-option">Todos</span></button>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li data-value="Todos" class="selected"><i class="fa-solid fa-check"></i> Todos</li>
                        <li data-value="En progreso">En progreso</li>
                        <li data-value="Pasados">Pasados</li>
                    </ul>
                </div>
                <!-- Input Search RT -->
                <div class="custom-input">
                    <input type="text" placeholder="Buscar">
                </div>
                <!-- Listbox -->
                <div class="custom-listbox">
                    <div class="listbox-header">
                        <button id="listbox"><span class="selected-option">Nombre del curso</span></button>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li data-value="Nombre del curso" class="selected"><i class="fa-solid fa-check"></i> Nombre del curso</li>
                        <li data-value="Último accedido">Último accedido</li>
                    </ul>
                </div>
            </div>
            <!-- Teams -->
            <div class="courses">
                @foreach($teams as $team)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Equipo #{{ $team->teamId}}</h5>
                            <img src="{{ $team->avatar }}" alt="Imagen">
                            <a href="{{ route('stagesProcess', ['researchTopicId' => $team->researchTopicId]) }}" class="card-link">{{ $team->themeName }}</a>
                            <!-- <progress value="50" max="100"></progress>
                            <h4>100% progreso</h4> -->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/tablero.js') }}"></script>
@endsection