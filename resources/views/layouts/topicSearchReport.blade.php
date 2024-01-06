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
            <form id="myForm" action="{{ route('generate-word') }}" method="POST">
                @csrf
                <div class="first-section">
                    <header>
                        <strong><h2>Orientación del equipo</h2></strong>
                    </header>
                    <div class="info-team">
                        <textarea class="textarea" name="orientation" placeholder="Organización del equipo"></textarea>
                        <input type="text" id="fuente" name="induction" placeholder="Inducción del tema" autocomplete="off">
                        <textarea class="textarea" name="teamBehavior" placeholder="Comportamiento del equipo"></textarea>
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
                    <table id="data-table-2" class="table content-table export-table">
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
                                    <!-- <td><a href="{{ $source->link }}" target="_blank" rel="noreferrer" class="link">{{ $source->link }}</a></td> -->
                                    <td>{{ $source->link }}</td>
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
                        <input type="text" id="comment" name="finalComment" placeholder="Comentario final" autocomplete="off">
                    </div>
                </div>
                <button type="submit">Agregar</button>
            </form>
        @else
            <div class="source-content">
                <div class="fuentes">
                    <strong><h2>Fuentes bibliográficas</h2></strong>
                    <button type="button" id="btnAddInfo" class="btn">Nueva Fuente</button>
                </div>
                <!-- Modal -->
                <div id="myModalInfo" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nueva fuente bibliográfica</h2>
                            <button type="button" id="cerrarModalInfo"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form action="" class="basic-information">
                            <input type="text" id="año" placeholder="Año" autocomplete="off">
                            <input type="text" id="autor" placeholder="Autor" autocomplete="off">
                            <input type="text" id="fuente" placeholder="Fuente" autocomplete="off">
                            <input type="text" id="tipoMedio" placeholder="Tipo de medio" autocomplete="off">
                            <input type="text" id="enlace" placeholder="Enlace" autocomplete="off">
                            <button type="submit" class="btn" id="submitButton">Agregar</button>
                        </form>
                    </div>
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
                <div class="fuentes">
                    <strong><h2>Objetivo General</h2></strong>
                    <button id="btnAddObjetivoGeneral" class="btn">Nuevo Objetivo</button>
                </div>
                <div id="myModalObjetivoGeneral" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo objetivo general</h2>
                            <button type="button" id="cerrarModalObjetivoGeneral"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="basic-information">
                            <textarea id="objetivoGeneral" class="textarea" name="generalObjetive" placeholder="Objetivo general"></textarea>
                            <button type="submit" class="btn" id="submitButton">Agregar</button>
                        </div>
                    </div>
                </div>
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estudiante que aporta</th>
                            <th>Objetivo general</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="fuentes">
                    <strong><h2>Objetivos Especifícos</h2></strong>
                    <button id="btnAddObjetivoEspecifico" class="btn">Nuevo Objetivo</button>
                </div>
                <div id="myModalObjetivoEspecifico" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo objetivo especifíco</h2>
                            <button type="button" id="cerrarModalObjetivoEspecifico"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="basic-information">
                            <textarea id="objetivoGeneral" class="textarea" name="generalObjetive" placeholder="Objetivo especifíco"></textarea>
                            <button type="submit" class="btn" id="submitButton">Agregar</button>
                        </div>
                    </div>
                </div>
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estudiante que aporta</th>
                            <th>Objetivo especifíco</th>
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