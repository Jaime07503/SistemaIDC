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
        <!-- Contenido Información acerca de las IDC -->
        <div class="info-content">
            <div class="idc-info">
                <h2>¿Qué es una IDC?</h2>
                <p>Las investigaciones de cátedra representan un componente esencial en la búsqueda de la excelencia académica y la mejora continua en el ámbito educativo. Estas investigaciones permiten la colaboración activa entre docentes y estudiantes, fomentando el desarrollo de habilidades investigativas, el pensamiento crítico y la generación de conocimiento en un contexto académico.</p>
            </div>
            <div class="mis-vis-content">
                <div class="mision">
                    <h3>Misión</h3>
                    <p>Promover y facilitar un entorno académico en el cual docentes y estudiantes participen activamente en la investigación de cátedra. Buscamos inspirar la pasión por la investigación, fomentar el pensamiento crítico y la creatividad, y proporcionar las herramientas y recursos necesarios para llevar a cabo investigaciones rigurosas. </p>
                </div>
                <div class="vision">
                    <h3>Visión</h3>
                    <p>Convertir las investigaciones de cátedra en un pilar fundamental de la excelencia académica en nuestra institución. Visualizamos un entorno en el cual docentes y estudiantes trabajen de manera colaborativa en proyectos de investigación interdisciplinarios.</p>
                </div>
            </div>
        </div>
        <!-- Contenido Vista general de los cursos -->
        <div class="courses-content">
            <div class="head-lbl">
                <h3>Vista general del curso</h3>
                <!-- <div class="line"></div> -->
            </div>
            <div class="options">
                <div class="options-search">
                        <div class="options-listbox">
                        <select>
                            <option value="todos">Todos</option>
                            <option value="en-progreso">En progreso</option>
                            <option value="pasados">Pasados</option>
                        </select>
                    </div>
                    <div class="search-box">
                        <input type="text" class="search-input" placeholder="Buscar">
                    </div>
                    <div class="name-listbox">
                        <select>
                            <option value="nombre-curso">Nombre del Curso</option>
                            <option value="ultimo-accedido">Último Accedido</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Cursos -->
            <div class="courses">
                @foreach ($courses as $course)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->subjectCycle }}</h5>
                        <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                        <a href="#" class="card-link">{{ $course->nameSubject }}</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection