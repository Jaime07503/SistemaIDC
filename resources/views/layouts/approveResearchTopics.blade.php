@extends('layout')

@section('title')
    Aprobación de Temas de Investigación
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/approveResearchTopics.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Aprobación de Temas de Investigación</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Temas de Investigación</a>
            </div>
        </div>
        <div class="researchTopics-content">
            <header class="head">
                <h2>Temas de Investigación Postulados</h2>
            </header>
            <section>
                <div class="custom-listbox">
                    <div class="listbox-header" id="topicsListbox">
                        <button class="listbox" type="button"><span class="selected-option">Todos</span></button>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li data-value="Todos">Todos</li>
                        @foreach ($subjects as $subject)
                            <li data-value="{{ $subject->nameSubject }}">{{ $subject->nameSubject }}</li>
                        @endforeach
                    </ul>
                </div>
                <!-- Input Search RT -->
                <input id="searchInput" class="custom-input" type="text" placeholder="Buscar...">
            </section>
            <section class="topics-content">
                <table id="data-table-topics" class="table content-table">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Tema</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topics as $topic)
                            <tr>
                                <td data-values="Materia">{{ $topic->nameSubject }}</td>
                                <td data-values="Tema">{{ $topic->themeName }}</td>
                                <td data-values="Acciones">
                                    <form action="{{ route('researchTopic.approved', ['researchTopicId' => $topic->researchTopicId]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-approve">
                                            <i class="fa-solid fa-check"></i> Aprobar
                                        </button>
                                    </form>
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
    <script src=" {{ asset('js/approveResearchTopics.js') }}"></script>
@endsection