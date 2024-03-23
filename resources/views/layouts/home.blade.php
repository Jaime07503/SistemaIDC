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
            <div>
                <h1 class="head-title">Investigaciones de Cátedra</h1>
                <h3 class="greeting">Bienvenido, {{ auth()->user()->name }} 👋</h3>
            </div>
            <img src="{{ asset('images/idc_logo.webp') }}" class="image-idc" alt="Logo IDC">
        </header>
        <section class="facultys-content">
            @if(auth()->user()->role === 'Administrador del Sistema')
                <div class="action-content">
                    <div class="action-link-content">
                        <i class="fa-solid fa-arrows-spin action-icon"></i>
                        <a href="{{ route('cycle') }}" class="action-link">Ciclos</a>
                    </div>
                    <div class="action-link-content">
                        <i class="fa-solid fa-building-columns action-icon"></i>
                        <a href="{{ route('faculty') }}" class="action-link">Facultades</a>
                    </div>
                    <div class="action-link-content">
                        <i class="fa-solid fa-flag-checkered action-icon"></i>
                        <a href="{{ route('career') }}" class="action-link">Carreras</a>
                    </div>
                    <div class="action-link-content">
                        <i class="fa-solid fa-brain action-icon"></i>
                        <a href="{{ route('subject') }}" class="action-link">Materias</a>
                    </div>
                    <div class="action-link-content">
                        <i class="fa-regular fa-user action-icon"></i>
                        <a href="{{ route('user') }}" class="action-link">Usuarios</a>
                    </div>
                </div>
            @else
                <div class="action-content">
                    <div class="action-link-content">
                        <i class="fa-regular fa-calendar action-icon"></i>
                        <a href="{{ route('idcDates') }}" class="action-link">Asignación de Fechas IDC</a>
                    </div>
                    <div class="action-link-content">
                        <i class="fa-solid fa-chalkboard-user action-icon"></i>
                        <a href="{{ route('assignSubject') }}" class="action-link">Asignación de Materias a Docentes</a>
                    </div>
                    <div class="action-link-content">
                        <i class="fa-solid fa-flask action-icon"></i>
                        <a href="{{ route('approveResearchTopics') }}" class="action-link">Aprobación de Temas de Investigación</a>
                    </div>
                    <div class="action-link-content">
                        <i class="fa-solid fa-people-group action-icon"></i>
                        <a href="{{ route('approveTeam') }}" class="action-link">Aprobación de Equipos de Investigación</a>
                    </div>
                    <div class="action-link-content">
                        <i class="fa-regular fa-file-word action-icon"></i>
                        <a href="{{ route('generateDocuments') }}" class="action-link">Documentos generados</a>
                    </div>
                </div>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/home.js') }}"></script>
@endsection