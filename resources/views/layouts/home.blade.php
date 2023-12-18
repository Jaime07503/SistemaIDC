@extends('layout')

@section('title')
    Home
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/home.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Contenido Titulo IDC -->
        <div class="head-content">
            <h1>Investigaciones de Cátedra</h1>
            <img src="{{ asset('images/idc_logo.webp') }}" alt="Logo IDC">
        </div>
        <!-- Contenido Vista general de los cursos -->
        <div class="courses-content">
            <div class="head-lbl">
                <h2>Vista general del curso</h2>
            </div>
            <div class="options-courses">
                @if($role === 'Docente' || $role === 'Estudiante')
                    <!-- Listbox -->
                    <div class="custom-listbox">
                        <div class="listbox-header">
                            <input class="selected-option" id="listbox" value="Todos" readonly></input>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            <li>Todos</li>
                            <li>En progreso</li>
                            <li>Pasados</li>
                        </ul>
                    </div>
                    <!-- Input Search RT -->
                    <div class="custom-input">
                        <input type="text" placeholder="Buscar">
                    </div>
                    <!-- Listbox -->
                    <div class="custom-listbox">
                        <div class="listbox-header">
                            <input class="selected-option" id="listbox" value="Nombre del curso" readonly></input>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            <li>Nombre del curso</li>
                            <li>Último accedido</li>
                        </ul>
                    </div>
                @endif
            </div>
            <!-- Cursos -->
            <div class="courses">
                @foreach ($courses as $course)
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{ $course->subjectCycle.' '.$course->subjectYear }}</h3>
                        <img src="{{ $course->avatar }}" alt="Imagen">
                        <a href="{{ route('researchTopics', ['subjectId' => $course->subjectId]) }}" class="card-link">{{ $course->nameSubject }} - {{ $course->section }} - {{ $course->teacher->user->name }}</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/home.js') }}"></script>
@endsection