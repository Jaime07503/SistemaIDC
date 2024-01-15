@extends('layout')

@section('title')
    Temas de Investigación - {{ $subject->nameSubject }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/researchTopics.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Encabezado e Historial de vistas -->
        <header class="head-content">
            <h1 class="head-lbl">{{ $subject->nameSubject.' - '.$subject->section.' - '.$subject->teacher->user->name}}</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis cursos</a>
                <a class="history-view" href="">{{ $subject->code }}</a>
            </nav>
        </header>
        <!-- Vista general de los temas de investigación -->
        <section class="topics-content">
            <header class="head">
                <h2>Temas de investigación</h2>
                @if(session('role') === 'Docente' && $subject->teacher->idcQuantity === 0)
                    <a href="{{ route('newResearchTopic', ['subjectId' => $subject->subjectId]) }}" class="btn-postulate">
                        <h3>Postular Tema</h3>
                    </a>
                @endif
            </header>
            <!-- Opciones para filtrar los temas de investigación -->
            <div class="options-courses">
                <!-- Listbox estado del tema de investigación -->
                <div class="custom-listbox">
                    <div class="listbox-header">
                        <button id="listbox"><span class="selected-option">Todos</span></button>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li data-value="Todos" class="selected"><i class="fa-solid fa-check"></i> Todos</li>
                        <li data-value="Aprobados">Aprobados</li>
                        <li data-value="Por Aprobar">Por Aprobar</li>
                    </ul>
                </div>
                <!-- Input búsqueda por nombre de tema de investigación -->
                <input class="custom-input" type="text" placeholder="Buscar...">
            </div>
            <!-- Temas de investigación -->
            @if(isset($noTopics))
                <h3 class="empty">No hay temas de investigación</h3>
            @else
                <aside class="topics">
                    @foreach ($researchTopics as $topic)
                        <div class="card">
                            <h3 class="card-title">{{ $topic->state }}</h3>
                            <img src="{{ $topic->avatar }}" class="card-image" alt="Imagen">
                            <a href="{{ route('researchTopicInformation', ['researchTopicId' => $topic->researchTopicId, 'subjectId' => $subject->subjectId]) }}" class="card-link">{{ $topic->themeName }}</a>
                        </div>
                    @endforeach
                </aside>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/researchTopics.js') }}"></script>
@endsection