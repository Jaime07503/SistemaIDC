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
                <a class="history-view" href="{{ route('tablero') }}">Tablero</a>
                <a class="history-view">Mis cursos</a>
                <a class="history-view" href="">{{ $subject->code }}</a>
            </nav>
        </header>
        <!-- Vista general de los temas de investigación -->
        <section class="topics-content">
            <header class="head">
                <h2>Temas de investigación</h2>
                @if(auth()->user()->role === 'Docente' && $subject->teacher->idcQuantity === 0)
                    <a href="{{ route('newResearchTopic', ['subjectId' => $subject->subjectId]) }}" class="btn-postulate">
                        <i class="fa-solid fa-bookmark"></i> Postular Tema</h3>
                    </a>
                @elseif(auth()->user()->role === 'Docente' && $subject->teacher->idcQuantity > 0)
                    <a href="{{ route('topicsApproveIdc', ['subjectId' => $subject->subjectId]) }}" class="btn-postulate">
                        <i class="fa-solid fa-hand-pointer"></i> Seleccionar Temas</h3>
                    </a>
                @endif
            </header>
            <!-- Input búsqueda por nombre de tema de investigación -->
            <input id="input-researchTopic" class="custom-input" type="text" placeholder="Buscar...">
            <!-- Temas de investigación -->
            @if(isset($noTopics))
                @if(auth()->user()->role === 'Docente')
                    <h3 class="empty">No tienes temas de investigación <strong>Aprobados</strong> ó <strong>Postulados</strong></h3>
                @else
                    <h3 class="empty">No hay temas de investigación <strong>Aprobados</strong> ó <strong>Postulados</strong></h3>
                @endif
            @else
                <div class="topics">
                    @foreach ($researchTopics as $topic)
                        <div class="card cards-researchTopics">
                            <h3 class="card-title">{{ $topic->state }}</h3>
                            <img src="{{ $topic->avatar }}" class="card-image" alt="Imagen">
                            <a href="{{ route('researchTopicInformation', ['researchTopicId' => $topic->researchTopicId, 'subjectId' => $subject->subjectId]) }}" class="card-link">{{ $topic->themeName }}</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/researchTopics.js') }}"></script>
@endsection