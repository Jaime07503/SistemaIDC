@extends('layout')

@section('title')
    Tablero
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/tablero.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Título IDC -->
        <header class="head-content">
            <div>
                <h1 class="head-title">Investigaciones de Cátedra</h1>
                <h3 class="greeting">Bienvenido {{ $role }}</h3>
            </div>
            <img src="{{ asset('images/idc_logo.webp') }}" class="image-idc" alt="Logo IDC">
        </header>
        <!-- Vista general del curso -->
        <section class="courses-content">
            <h2 class="head-lbl">Vista general del curso</h2>
            <!-- Opciones para filtrar los cursos -->
            <header class="options-courses">
                <!-- Listbox estado del curso -->
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
                <!-- Input búsqueda por nombre de curso -->
                <input class="custom-input" type="text" placeholder="Buscar...">
            </header>
            <!-- Cursos -->
            @if(isset($noContent))
                <h3 class="empty">No hay cursos disponibles</h3>
            @else
                @if(isset($noCourses))
                    <h3 class="empty">No hay cursos disponibles</h3>
                @else
                    <aside class="courses">
                        @foreach ($courses as $course)
                            <div class="card">
                                <h3 class="card-title">{{ $course->cycle }}</h3>
                                <img src="{{ $course->avatarSubject }}" class="card-image" alt="Imagen">
                                <a href="{{ route('researchTopics', ['subjectId' => $course->subjectId]) }}" class="card-link">{{ $course->nameSubject }} - {{ $course->section }} - {{ $course->name }}</a>
                            </div>
                        @endforeach
                    </aside>
                @endif
            @endif
        </section>
        <!-- Vista general de los equipos de investigación -->
        <section class="teams-content">
            <h2 class="head-lbl">Vista general de las investigaciones</h2>
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
            @if(isset($noContent))
                <h3 class="empty">No perteneces a un equipo aún</h3>
            @else
                @if(isset($noTeams))
                    <h3 class="empty">No perteneces a un equipo aún</h3>
                @else
                    <aside class="teams">
                        @foreach ($teams as $team)
                            <div class="card">
                                <h5 class="card-title">Equipo #{{ $team->teamId}}</h5>
                                <img src="{{ $team->avatar }}" alt="Imagen" class="card-image">
                                <a href="{{ route('stagesProcess', ['researchTopicId' => $team->researchTopicId, 
                                    'teamId' => $team->teamId, 'idcId' => $team->idcId]) }}" class="card-link">{{ $team->themeName }}
                                </a>
                            </div>
                        @endforeach
                    </aside>
                @endif
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/tablero.js') }}"></script>
@endsection