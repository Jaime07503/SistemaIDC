@extends('layout')

@section('title')
    Artículo Científico
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/searchInformation.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1 class="head-lbl">{{ $scientificArticle->themeName }} - Equipo #{{ $scientificArticle->teamId}} - Artículo Científico</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis investigaciones</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $scientificArticle ->researchTopicId, 
                    'subjectId' => $scientificArticle->subjectId]) }}">{{ $scientificArticle->code }}
                </a>
                <a class="history-view" href="{{ route('stagesProcess', ['researchTopicId' => $scientificArticle->researchTopicId, 
                    'teamId' => $scientificArticle->teamId, 'idcId' => $scientificArticle->idcId]) }}">Etapas del proceso
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
                        @if($scientificArticle->state === null)
                            <td>Sin Intento</td>
                        @else 
                            <td>{{ $scientificArticle->state }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Fecha de entrega</strong></td>
                        <td>{{ $formattedDeadline }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tiempo restante</strong></td>
                        @if($scientificArticle->state === 'Sin Intento')
                            <td>{{ $timeRemaining }}</td>
                        @else
                            <td>El documento fue creado: <strong>{{ $formattedupdated_at }}</strong></td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Archivo generado</strong></td>
                        @if($scientificArticle->storagePath === 'Por generar')
                            <td>{{ $scientificArticle->storagePath }}</td>
                        @else
                            <td>
                                <strong><a href="{{ asset($scientificArticle->storagePath) }}" 
                                    class="link-document"><i class="fa-regular fa-file-word"></i> {{ $scientificArticle->scientificArticleCode }}
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
            @if($scientificArticle->state !== 'Creado')
                <div class="title">
                    <a href="{{ url('/scientificArticleReport', ['idcId' => $scientificArticle->idcId, 
                        'idScientificArticleReport' => $idScientificArticleReport]) }}" class="btn-login">
                        @if(session('role') === 'Docente')
                            <h4>Crear Informe</h4>
                        @elseif(session('role') === 'Estudiante')
                            <h4>Aportar al Informe</h4>
                        @endif
                    </a>
                </div>
            @endif
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/searchInformation.js') }}"></script>
@endsection