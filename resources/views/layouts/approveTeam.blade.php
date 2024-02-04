@extends('layout')

@section('title')
    Aprobación de Equipos de Investigación
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/approveTeam.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Aprobación de Equipos de Investigación</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/home') }}">Inicio del Sitio</a>
                <a class="history-view">Equipos de Investigación</a>
            </div>
        </div>
        <div class="researchTopics-content">
            <header class="head">
                <h2>Equipos de Investigación Postulados</h2>
            </header>
            <section>
                <div class="custom-listbox">
                    <div class="listbox-header" id="topicsListbox">
                        <button class="listbox" type="button"><span class="selected-option">Todos</span></button>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li data-value="Todos">Todos</li>
                        @foreach ($researchTopics as $researchTopic)
                            <li data-value="{{ $researchTopic->themeName }}">{{ $researchTopic->themeName }}</li>
                        @endforeach
                    </ul>
                </div>
                <!-- Input Search RT -->
                <input id="searchInput" class="custom-input" type="text" placeholder="Buscar...">
            </section>
            <section class="researchTopics-content">
                <table id="data-table-researchTopics" class="table content-table">
                    <thead>
                        <tr>
                            <th>Equipo</th>
                            <th>Materia</th>
                            <th>Tema</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td data-values="Equipo"><img src="{{ $team->avatar }}" alt=""> {{ $team->teamId }}</td>
                                <td data-values="Materia">{{ $team->subject }}</td>
                                <td data-values="Tema">{{ $team->themeName }}</td>
                                <td data-values="Acciones">
                                    <button type="button" class="btn btn-edit" data-modal="verDetallesEquipo">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/approveTeam.js') }}"></script>
@endsection