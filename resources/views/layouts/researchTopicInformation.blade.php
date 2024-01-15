@extends('layout')

@section('title')
    Información de {{ $researchTopic->themeName }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/researchTopicInformation.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Encabezado e Historial de vistas -->
        <header class="head-content">
            <h1>{{ $subject->nameSubject.' - '.$subject->section.' - '.$researchTopic->themeName }}</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" >Mis cursos</a>
                <a class="history-view" href="{{ route('researchTopics', ['subjectId' => $subjectId]) }}">{{ $subject->code }}</a>
                <a class="history-view" href="">{{ $researchTopic->code }}</a>
            </nav>
        </header>
        <!-- Información general del tema de investigación -->
        <section class="information-content">
            <h2>Información general</h2>
            <!-- Información del tema de investigación -->
            <div class="information">
                <p class="information-paragraph">{{ $researchTopic->description }}</p>
                <p class="information-paragraph">{{ $researchTopic->currentInformation }}</p>
                <div class="information-images">
                    <img src="{{ $researchTopic->importanceRegional }}" alt="" class="information-images-importance">
                    <img src="{{ $researchTopic->importanceGlobal }}" alt="" class="information-images-importance">
                </div>
            </div>
            @if(session('role') === 'Estudiante')
                @if($studentResearch->applicationCount < 2 
                    && (!$postulatedSubject || ($postulatedSubject->state !== 'Postulado' && $postulatedSubject->state !== 'Aprobado')))
                    <form action="{{ route('studentSubject.store') }}" method="POST" id="applicationForm">
                        @csrf
                        <input type="hidden" name="idStudent" class="idStudent" value="{{ session('studentId') }}">
                        <input type="hidden" name="idSubject" class="idSubject" value="{{ $subjectId }}">
                        <input type="hidden" name="researchTopicId" class="researchTopicId" value="{{ $researchTopic->researchTopicId }}">
                        <button type="submit" class="btn-postulate">Postularse</button>
                    </form>
                @else
                    @if($postulatedSubject && ($postulatedSubject->state === 'Postulado' || $postulatedSubject->state === 'Aprobado'))
                    <!-- Postularse al tema (Estudiante) -->
                    <h2 class="state">{{ $postulatedSubject->state }}</h2>
                    @endif
                @endif
            @endif
            <!-- Información de los equipos de investigación -->
            <div class="head">
                <h2>Equipos de Investigación</h2>
                <!-- Postular Equipos (Docente) -->
                @if(session('role') === 'Docente')
                    <a href="{{ route('newTeam', ['researchTopicId' => $researchTopicId]) }}" class="btn-postulate">
                        <h3>Postular Equipo</h3>
                    </a>
                @endif
            </div>
            @if(empty($result))
                <h3 class="empty">No hay equipos postulados aún</h3>
            @else
                <!-- Equipos de investigación -->
                <aside class="teams">
                    @foreach($result as $teamResult)
                        @if(isset($teamResult['team']) && $teamResult['team'] !== null && isset($teamResult['students']) && $teamResult['students'] !== null)
                            <div class="team-content">
                                <header class="top">
                                    <h3>Equipo #{{ $teamResult['team']->teamId }} </h3>
                                    <h3>{{ $teamResult['team']->state }}</h3>
                                    <div class="integrants">
                                        <i class="fa-solid fa-users"></i>
                                        <h3>{{ $teamResult['team']->integrantQuantity }}</h3>
                                    </div>
                                </header>
                                <div class="students">
                                    @foreach($teamResult['user'] as $student)
                                        <div class="student">
                                            <img src="{{ $student->avatar }}" alt="{{ $student->name }} Avatar" class="ava">
                                            <h4>{{ $student->name.' '.$student->email }}</h4>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </aside>
            @endif
        </section>
    </main>
@endsection