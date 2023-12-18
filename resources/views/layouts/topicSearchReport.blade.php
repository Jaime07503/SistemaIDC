@extends('layout')

@section('title')
    Informe de Búsqueda de Información
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/topicSearchReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Datos del informe y ordenamiento de búsqueda del tema</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
                <a class="view" href="">Tema</a>
                <a class="view" href=""> Etapas </a>
            </nav>
        </div>
        @if($role === 'Docente')
            <div class="first-section">
                <header>
                    <strong><h2>Orientación del equipo</h2></strong>
                </header>
                <div class="info-team">
                    <textarea class="textarea" name="orientation" placeholder="Organización del equipo"></textarea>
                    <input type="text" id="fuente" placeholder="Inducción del tema" autocomplete="off">
                    <textarea class="textarea" name="orientation" placeholder="Comportamiento del equipo"></textarea>
                    <input type="text" id="fuente" placeholder="Metodología" autocomplete="off">
                </div>
            </div>
            <div class="second-section">
                <header>
                    <strong><h2>Plan de búsqueda de información</h2></strong>
                </header>
                <textarea class="textarea" name="searchPlan" placeholder="Plan de búsqueda"></textarea>
            </div>
            <div class="third-section">
                <header>
                    <strong><h2>Tabla de volcado de información</h2></strong>
                </header>
                <table id="data-table-2" class="table content-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Año</th>
                            <th>Autor</th>
                            <th>Titulo</th>
                            <th>Tipo de medio</th>
                            <th>Enlace</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sources as $source)
                            <tr>
                                <td>{{ $source->bibliographicSourceId }}</td>
                                <td>{{ $source->year }}</td>
                                <td>{{ $source->author }}</td>
                                <td>{{ $source->bibliographicSourceType }}</td>
                                <td>{{ $source->averageType }}</td>
                                <td><a href="{{ $source->link }}" target="_blank" rel="noreferrer" class="link">{{ $source->link }}</a></td>
                                <td>Aprobado</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="fourth-section">
                <header>
                    <strong><h2>Objetivos</h2></strong>
                </header>
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estudiante que aporta</th>
                            <th>Objetivo específico</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="fifth-content">
                <header>
                    <strong><h2>Valoración del equipo</h2></strong>
                </header>
                <div>

                </div>
            </div>
            <div class="sixth-content">
                <header>
                    <strong><h2>Comentario final</h2></strong>
                </header>
                <div>
                    <input type="text" id="comment" placeholder="Comentario final" autocomplete="off">
                </div>
            </div>
        @else
            <div class="source-content">
                <header class="fuentes">
                    <strong><h2>Fuentes bibliográficas</h2></strong>
                </header>
                <div class="basic">
                    <input type="text" id="fuente" placeholder="Fuente" autocomplete="off">
                    <input type="text" id="autor" placeholder="Autor" autocomplete="off">
                    <input type="text" id="año" placeholder="Año" autocomplete="off">
                    <input type="text" id="tipoMedio" placeholder="Tipo de medio" autocomplete="off">
                    <input type="text" id="enlace" placeholder="Enlace" autocomplete="off">
                    <button type="button" id="btnAddInfo" class="btn">Agregar</button>
                </div>
                <div>
                    <table id="data-table-2" class="table content-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Año</th>
                                <th>Autor</th>
                                <th>Titulo</th>
                                <th>Tipo de medio</th>
                                <th>Enlace</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <td>{{ $source->bibliographicSourceId }}</td>
                                    <td>{{ $source->year }}</td>
                                    <td>{{ $source->author }}</td>
                                    <td>{{ $source->bibliographicSourceType }}</td>
                                    <td>{{ $source->averageType }}</td>
                                    <td><a href="{{ $source->link }}" target="_blank" rel="noreferrer" class="link">{{ $source->link }}</a></td>
                                    <td>Aprobado</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="sixth-content">
                <header class="fuentes">
                    <strong><h2>Objetivos</h2></strong>
                </header>
                <div class="basic">
                    <textarea id="objetivoGeneral" class="textarea" name="generalObjetive" placeholder="Objetivo general"></textarea>
                    <textarea id="objetivoEspecifico" class="textarea" name="specificObjetive" placeholder="Objetivo específico"></textarea>
                    <button id="btnAdd" class="btn">Agregar</button>
                </div>
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estudiante que aporta</th>
                            <th>Objetivo especifico</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        @endif
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/topicSearchReport.js') }}"></script>
@endsection