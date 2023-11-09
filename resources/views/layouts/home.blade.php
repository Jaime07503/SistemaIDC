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
            <img src="{{ asset('images/idc_logo.png') }}" alt="Logo IDC">
        </div>
        <!-- Contenido Vista general de los cursos -->
        <div class="courses-content">
            <div class="head-lbl">
                <h3>Vista general del curso</h3>
            </div>
            <div class="options-courses">
                @if($role === 'Docente' || $role === 'Estudiante')
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
                    <!-- Cursos -->
                    <div class="courses">
                        @foreach ($courses as $course)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->subjectCycle }}</h5>
                                <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                                <a href="{{ route('temas', ['subjectId' => $course->subjectId]) }}" class="card-link">{{ $course->nameSubject }} - {{ $course->section }} - {{ $course->teacher->user->name }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/home.js') }}"></script>
@endsection