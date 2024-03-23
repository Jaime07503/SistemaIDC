@extends('layout')

@section('title')
    Aprobación de Temas de Investigación
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/approveResearchTopics.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Aprobación de Temas de Investigación</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/home') }}">Inicio del Sitio</a>
                <a class="history-view">Temas de Investigación</a>
            </nav>
        </header>
        <section class="researchTopics-content">
            <header class="head">
                <h2>Temas de Investigación Postulados</h2>
            </header>
            <div>
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
            </div>
            <div class="topics-content">
                @if(isset($noTopics))
                    <h3 class="empty">No hay <strong>Temas de Investigación Postulados</strong></h3>
                @else
                    <table id="data-table-topics" class="table content-table">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Tema</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($researchTopics as $topic)
                                <tr>
                                    <td data-values="Materia">{{ $topic->nameSubject }}</td>
                                    <td data-values="Tema">{{ $topic->themeName }}</td>
                                    <td data-values="Descripción">{{ $topic->description }}</td>
                                    <td data-values="Acciones">
                                        <form action="{{ route('researchTopic.approved', ['researchTopicId' => $topic->researchTopicId]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-approve">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>
        <section class="researchTopics-content">
            <header class="head">
                <h2>Temas de Investigación Seleccionados para siguiente IDC</h2>
            </header>
            <div>
                <div class="custom-listbox">
                    <div class="listbox-header" id="topicsIDCListbox">
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
                <!-- Input Search RT IDC -->
                <input id="searchTopicsInput" class="custom-input" type="text" placeholder="Buscar...">
            </div>
            <div class="topics-content">
                @if($topics->isEmpty())
                    <h3 class="empty">No hay <strong>Temas de Investigación Seleccionados para siguiente IDC</strong></h3>
                @else
                    <table id="data-table-topics" class="table content-table">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Tema</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topics as $topic)
                                <tr>
                                    <td data-values="Materia">{{ $topic->subject }}</td>
                                    <td data-values="Tema">{{ $topic->nameTopic }}</td>
                                    <td data-values="Descripción">{{ $topic->description }}</td>
                                    <td data-values="Acciones">
                                        <form action="{{ route('topicIdc.approved', ['topicId' => $topic->topicId]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-approve">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/approveResearchTopics.js') }}"></script>
@endsection