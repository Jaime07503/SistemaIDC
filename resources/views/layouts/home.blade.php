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
            <h2 class="head-lbl">Acciones Principales</h2>
            @if(auth()->user()->role === 'Administrador del Sistema')
                <div class="stages">
                    <div class="stage-card">
                        <img src="{{ asset('images/robot.webp') }}" alt="Imagen de informacion del proceso" class="stage-image">
                        <a href="{{ route('cycle') }}" 
                            class="stage-link"><i class="fa-solid fa-arrows-spin"></i>
                            Ciclos
                        </a>
                    </div>
                    <div class="stage-card">
                        <img src="{{ asset('images/search.webp') }}" alt="Imagen relacionada con la busqueda de informacion" class="stage-image">
                        <a href="{{ route('faculty') }}" 
                            class="stage-link"><i class="fa-solid fa-building-columns"></i>
                            Facultades
                        </a>
                    </div>
                    <div class="stage-card">
                        <img src="{{ asset('images/article.webp') }}" alt="Imagen relacionada con el articulo cientifico" class="stage-image">
                        <a href="{{ route('career') }}" 
                            class="stage-link"><i class="fa-solid fa-flag-checkered"></i>
                            Carreras
                        </a>
                    </div>
                    <div class="stage-card">
                        <img src="{{ asset('images/end.webp') }}" alt="Imagen relacionada con la finalizacion del proceso" class="stage-image">
                        <a href="{{ route('subject') }}" 
                            class="stage-link"><i class="fa-solid fa-brain"></i>
                            Materias
                        </a>
                    </div>
                    <div class="stage-card">
                        <img src="{{ asset('images/end.webp') }}" alt="Imagen relacionada con la finalizacion del proceso" class="stage-image">
                        <a href="{{ route('user') }}" 
                            class="stage-link"><i class="fa-regular fa-user"></i>
                            Usuarios
                        </a>
                    </div>
                </div>
            @else
                <div class="stages">
                    <div class="stage-card">
                        <img src="{{ asset('images/robot.webp') }}" alt="Imagen de informacion del proceso" class="stage-image">
                        <a href="{{ route('idcDates') }}" 
                            class="stage-link"><i class="fa-regular fa-calendar"></i>
                            Asignación de Fechas IDC
                        </a>
                    </div>
                    <div class="stage-card">
                        <img src="{{ asset('images/search.webp') }}" alt="Imagen relacionada con la busqueda de informacion" class="stage-image">
                        <a href="{{ route('assignSubject') }}" 
                            class="stage-link"><i class="fa-solid fa-chalkboard-user"></i>
                            Asignación de Materias a Docentes
                        </a>
                    </div>
                    <div class="stage-card">
                        <img src="{{ asset('images/article.webp') }}" alt="Imagen relacionada con el articulo cientifico" class="stage-image">
                        <a href="{{ route('approveResearchTopics') }}" 
                            class="stage-link"><i class="fa-solid fa-flask"></i>
                            Aprobación de Temas de Investigación
                        </a>
                    </div>
                    <div class="stage-card">
                        <img src="{{ asset('images/end.webp') }}" alt="Imagen relacionada con la finalizacion del proceso" class="stage-image">
                        <a href="{{ route('approveTeam') }}" 
                            class="stage-link"><i class="fa-solid fa-people-group"></i>
                            Aprobación de Equipos de Investigación
                        </a>
                    </div>
                    <div class="stage-card">
                        <img src="{{ asset('images/search.webp') }}" alt="Imagen relacionada con la busqueda de informacion" class="stage-image">
                        <a href="{{ route('generateDocuments') }}" 
                            class="stage-link"><i class="fa-regular fa-file-word"></i>
                            Documentos generados
                        </a>
                    </div>
                </div>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/home.js') }}"></script>
@endsection