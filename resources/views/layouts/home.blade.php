@extends('layout')

@section('title')
    Inicio del Sitio
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/home.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Título IDC -->
        <header class="head-content">
            <h1 class="title">Investigaciones de Cátedra</h1>
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
            <aside class="courses">
                @foreach ($courses as $course)
                    <div class="card">
                        <h3 class="card-title">{{ $course->subjectCycle.' '.$course->subjectYear }}</h3>
                        <img src="{{ $course->avatar }}" class="card-image" alt="Imagen">
                        <a href="{{ route('researchTopics', ['subjectId' => $course->subjectId]) }}" class="card-link">{{ $course->nameSubject }} - {{ $course->section }} - {{ $course->teacher->user->name }}</a>
                    </div>
                @endforeach
            </aside>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/home.js') }}"></script>
@endsection