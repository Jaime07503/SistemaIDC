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
                        <input class="selected-option" id="listbox" placeholder="Todos" readonly></input>
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
                        <input class="selected-option" id="listbox" placeholder="Nombre del curso" readonly></input>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li>Nombre del curso</li>
                        <li>Último accedido</li>
                    </ul>
                </div>
            </div>
            <!-- Research Topics -->
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