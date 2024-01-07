@extends('layout')

@section('title')
    Tablero
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/tablero.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1 class="head-lbl">Tablero</h1>
        </header>
        <!-- Vista general de los equipos de investigación -->
        <section class="teams-content">
            <h2 class="title">Vista general de las investigaciones</h2>
            <div class="options-courses">
                <!-- Listbox estado del equipo de investigación -->
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
                <!-- Input búsqueda por tema de investigación -->
                <input class="custom-input" type="text" placeholder="Buscar...">
            </div>
            <!-- Equipos de investigación -->
            <aside class="teams">
                @foreach($teams as $team)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Equipo #{{ $team->teamId}}</h5>
                            <img src="{{ $team->avatar }}" alt="Imagen" class="card-image">
                            <a href="{{ route('stagesProcess', ['researchTopicId' => $team->researchTopicId]) }}" class="card-link">{{ $team->themeName }}</a>
                        </div>
                    </div>
                @endforeach
            </aside>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/tablero.js') }}"></script>
@endsection