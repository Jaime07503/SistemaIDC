@extends('layout')

@section('title')
    Búsqueda de Información
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/searchInformation.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1 class="head-lbl">{{ $searchReport->themeName }} - Equipo #{{ $searchReport->teamId}} - Búsqueda de Información</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis investigaciones</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $searchReport->researchTopicId, 'subjectId' => $searchReport->subjectId]) }}">{{ $searchReport->code }}</a>
                <a class="history-view" href="{{ route('stagesProcess', ['researchTopicId' => $searchReport->researchTopicId, 
                    'teamId' => $searchReport->teamId, 'idcId' => $searchReport->idcId]) }}">Etapas del proceso
                </a>
                <a class="history-view" href="">Estatus del Informe</a>
            </nav>
        </div>
        <div class="info-content">
            <header>
                <strong><h2>Estatus de la Entrega</h2></strong>
            </header>
            <table class="table content-table">
                <tbody>
                    <tr>
                        <td><strong>Estatus del informe</strong></td>
                        @if($searchReport->state === null)
                            <td>Sin Intento</td>
                        @else 
                            <td>{{ $searchReport->state }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Fecha de entrega</strong></td>
                        <td>{{ $formattedDeadline }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tiempo restante</strong></td>
                        @if($searchReport->state !== 'Creado')
                            <td>{{ $timeRemaining }}</td>
                        @else
                            <td>El documento fue creado: <strong>{{ $formattedupdated_at }}</strong></td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Archivo generado</strong></td>
                            @if($searchReport->storagePath === 'Por generar')
                                <td>{{ $searchReport->storagePath }}</td>
                            @else
                                <td>
                                    <strong><a href="{{ asset($searchReport->storagePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $searchReport->searchReportCode }}
                                    </a></strong>
                                </td>
                            @endif
                    </tr>
                    <tr>
                        <td><strong>Comentarios al envío</strong></td>
                        <td>No hay comentarios por el momento</td>
                    </tr>
                </tbody>
            </table>
            @if($searchReport->state !== 'Creado') 
                <div class="title">
                    <a href="{{ route('topicSearchReport', ['idcId' => $searchReport->idcId, 
                        'idTopicSearchReport' => $idTopicSearchReport]) }}" class="btn-login">
                        <h4>Crear Informe</h4>
                    </a>
                </div>
            @endif
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/searchInformation.js') }}"></script>
@endsection