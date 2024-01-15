@extends('layout')

@section('title')
    Finalización del Proceso
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/searchInformation.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1 class="head-lbl">{{ $nextIdcTopicReport->themeName }} - Equipo #{{ $nextIdcTopicReport->teamId}} - Finalización del Proceso</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis investigaciones</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $nextIdcTopicReport->researchTopicId, 'subjectId' => $nextIdcTopicReport->subjectId]) }}">{{$nextIdcTopicReport->code}}</a>
                <a class="history-view" href="{{ route('stagesProcess', ['researchTopicId' => $nextIdcTopicReport->researchTopicId, 
                    'teamId' => $nextIdcTopicReport->teamId, 'idcId' => $nextIdcTopicReport->idcId]) }}">Etapas del proceso
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
                        @if($nextIdcTopicReport->state === null)
                            <td>Sin Intento</td>
                        @else 
                            <td>{{ $nextIdcTopicReport->state }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Fecha de entrega</strong></td>
                        <td>{{ $formattedDeadline }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tiempo restante</strong></td>
                        @if($nextIdcTopicReport->state !== 'Creado')
                            <td>{{ $timeRemaining }}</td>
                        @else
                            <td>El documento fue creado: <strong>{{ $formattedupdated_at }}</strong></td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Archivo generado</strong></td>
                        @if($nextIdcTopicReport->storagePath === null)
                            <td>Aún no se ha generado un documento</td>
                        @else
                            @if($nextIdcTopicReport->state !== 'Creado')
                                <td>{{ $nextIdcTopicReport->storagePath }}</td>
                            @else
                                <td>
                                    <strong><a href="{{ asset($nextIdcTopicReport->storagePath) }}" 
                                        class="link-document"><i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->scientificArticleCode }}
                                    </a></strong>
                                </td>
                            @endif
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Comentarios al envío</strong></td>
                        <td>No hay comentarios por el momento</td>
                    </tr>
                </tbody>
            </table>
            <div class="title">
                <a href="{{ route('nextIdcTopicReport', ['idcId' => $nextIdcTopicReport->idcId,
                    'idNextIdcTopicReport' => '$idNextIdcTopicReport']) }}" class="btn-login">
                    <h4>Crear Informe</h4>
                </a>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/searchInformation.js') }}"></script>
@endsection