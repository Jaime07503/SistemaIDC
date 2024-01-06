@extends('layout')

@section('title')
    Información de {{ $researchTopic->themeName }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/researchTopicInformation.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>{{ $researchTopic->themeName }}</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="{{ route('researchTopics', ['subjectId' => $subjectId]) }}">{{ $subject->code }}</a>
                <a class="view" href="">{{ $researchTopic->themeName }}</a>
            </div>
        </div>
        <div class="information-content">
            <div>
                <h2>Información general</h2>
            </div>
            <div class="information">
                <p>{{ $researchTopic->description }}</p>
                <!-- @if(session('role') === 'Estudiante')
                    @if($studentResearch->applicationCount < 2 
                        && (!$postulatedSubject || ($postulatedSubject->state !== 'Postulado' && $postulatedSubject->state !== 'Aprobado')))
                        <form action="{{ route('studentSubject.store') }}" method="POST" id="applicationForm">
                            @csrf
                            <input type="hidden" name="idStudent" class="idStudent" value="{{ session('studentId') }}">
                            <input type="hidden" name="idSubject" class="idSubject" value="{{ $subjectId }}">
                            <input type="hidden" name="researchTopicId" class="researchTopicId" value="{{ $researchTopic->researchTopicId }}">
                            <button type="submit" class="btn">Postularse</button>
                        </form>
                    @else
                        @if($postulatedSubject && ($postulatedSubject->state === 'Postulado' || $postulatedSubject->state === 'Aprobado'))
                            <h2 class="state">{{ $postulatedSubject->state }}</h2>
                        @endif
                    @endif
                @endif -->
            </div>
            <div class="top-content">
                <div>
                    <img src="{{ $researchTopic->importanceRegional }}" alt="" class="avatarTopic">
                </div>
                <div>
                    <img src="{{ $researchTopic->importanceGlobal }}" alt="" class="avatarTopic">
                </div>
            </div>
            <div class="head">
                <h2>Equipos de Investigación</h2>
                @if(session('role') === 'Docente')
                    <a href="{{ route('newTeam', ['researchTopicId' => $researchTopicId]) }}" class="btn">
                        <h4>Postular Equipo</h4>
                    </a>
                @endif
            </div>
            @if(empty($result))
                <h3 class="empty">No hay equipos postulados aún</h3>
            @else
                <div class="teams">
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
                </div>
            @endif
        </div>
    </main>
@endsection