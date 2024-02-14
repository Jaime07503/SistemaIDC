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
                <h3 class="greeting">Bienvenido, {{ auth()->user()->name }} 👋</h3>
            </div>
            <img src="{{ asset('images/idc_logo.webp') }}" class="image-idc" alt="Logo IDC">
        </header>
        @if(auth()->user()->role === 'Docente' || auth()->user()->role === 'Estudiante')
            <!-- Vista general del curso -->
            <section class="courses-content">
                <h2 class="head-lbl">Vista general del curso</h2>
                <!-- Input búsqueda por nombre de curso -->
                <input id="input-subject" class="custom-input" type="text" placeholder="Buscar...">
                <!-- Cursos -->
                @if(isset($noContent))
                    <h3 class="empty">No tienes cursos disponibles</h3>
                @else
                    @if(isset($noCourses))
                        <h3 class="empty">No tienes cursos disponibles</h3>
                    @else
                        <div class="courses">
                            @foreach ($courses as $course)
                                <div class="card card-courses">
                                    <h3 class="card-title">{{ $course->cycle }}</h3>
                                    <img src="{{ $course->avatar }}" class="card-image" alt="Imagen">
                                    <a href="{{ route('researchTopics', ['subjectId' => $course->subjectId]) }}" class="card-link">
                                        {{ $course->nameSubject }} - {{ $course->section }} - {{ $course->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </section>
        @endif
        <!-- Vista general de los equipos de investigación -->
        <section class="teams-content">
            <h2 class="head-lbl">Vista general de las investigaciones</h2>
            <!-- Input búsqueda por tema de investigación -->
            <input id="input-team" class="custom-input" type="text" placeholder="Buscar...">
            <!-- Equipos de investigación -->
            @if(isset($noContent))
                @if(auth()->user()->role === 'Docente')
                    <h3 class="empty">No tienes <strong>Equipos Aprobados</strong></h3>
                @else
                    <h3 class="empty">No perteneces a <strong>Equipos Aprobados</strong></h3>
                @endif
            @else
                @if(isset($noTeams))
                    @if(auth()->user()->role === 'Docente')
                        <h3 class="empty">No tienes <strong>Equipos Aprobados</strong></h3>
                    @else
                        <h3 class="empty">No perteneces a <strong>Equipos Aprobados</strong></h3>
                    @endif
                @else
                    <div class="teams">
                        @foreach ($teams as $team)
                            <div class="card card-teams">
                                <h5 class="card-title">Equipo #{{ $team->teamId}}</h5>
                                <img src="{{ $team->avatar }}" alt="Imagen" class="card-image">
                                <a href="{{ route('stagesProcess', ['researchTopicId' => $team->researchTopicId, 
                                'teamId' => $team->teamId, 'idcId' => $team->idcId]) }}" class="card-link">
                                    {{ $team->themeName }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/tablero.js') }}"></script>
@endsection