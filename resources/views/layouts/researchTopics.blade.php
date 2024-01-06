@extends('layout')

@section('title')
    Temas de Investigación - {{ $subject->nameSubject }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/researchTopics.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>{{ $subject->nameSubject.' - '.$subject->section.' - '.$subject->teacher->user->name}}</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">{{ $subject->code }}</a>
            </div>
        </div>
        <div class="topics-content">
            <div class="head">
                <h2>Temas de investigación</h2>
                @if(session('role') === 'Docente' && $subject->teacher->idcQuantity === 0)
                    <a href="{{ route('newResearchTopic', ['subjectId' => $subject->subjectId]) }}" class="btn-login">
                        <i class="fa-solid fa-plus"></i>
                        <h4>Postular Tema</h4>
                    </a>
                @endif
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
                        <li data-value="Aprobados">Aprobados</li>
                        <li data-value="Por Aprobar">Por Aprobar</li>
                    </ul>
                </div>
                <!-- Entrada de Texto -->
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
            <div class="topics">
                @foreach ($researchTopics as $topic)
                <div class="researchTopics">
                    <div>
                        <h3 class="card-title">{{ $topic->state }}</h3>
                        <img src="{{ $topic->avatar }}" class="avatarTopic" alt="Imagen">
                    </div>
                    <div class="topicContent">
                        <div class="title">
                            <div class="topic">
                                <a href="{{ route('researchTopicInformation', ['researchTopicId' => $topic->researchTopicId, 'subjectId' => $subject->subjectId]) }}" class="">{{ $topic->themeName }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/researchTopics.js') }}"></script>
@endsection