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
            <table class="table content-table">
                <tbody>
                    <tr>
                        <td><strong>Estatus del informe</strong></td>
                        <td>
                            @if($searchReport->state === null)
                                Sin Intento
                            @else 
                                <strong>{{ $searchReport->state }}</strong>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de entrega</strong></td>
                        <td>{{ $formattedDeadline }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tiempo restante</strong></td>
                        <td>
                            @if($searchReport->state === 'Sin Intento')
                                {{ $timeRemaining }}
                            @else
                                El documento fue generado: <strong>{{ $formattedupdated_at }}</strong>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Archivo generado</strong></td>
                        <td>
                            @if($searchReport->storagePath === 'Por generar')
                                {{ $searchReport->storagePath }}
                            @else
                                <strong>
                                    <a href="{{ asset($searchReport->storagePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $searchReport->searchReportCode }}
                                    </a>
                                </strong>
                            @endif
                        </td>
                    </tr>

                    @if(($searchReport->state === 'Aprobado' || $searchReport->state === 'Rechazado') && $searchReport->previousState === 'Corregido')
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($searchReport->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $searchReport->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <strong>
                                    <a href="{{ asset($searchReport->correctedDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $searchReport->nameCorrectedDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                    @endif

                    @if($searchReport->state === 'Debe corregirse' && session('role') === 'Docente')
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($searchReport->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $searchReport->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <form id="formTSRCO" action="{{ route('topicSearchReport.corrected', ['idcId' => $searchReport->idcId, 
                                    'idTopicSearchReport' => $idTopicSearchReport]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" class="contenedor-btn-file">
                                        <i class="fas fa-file"></i>
                                        Adjuntar archivo corregido
                                        <label for="btn-file-TSRCO"></label>
                                        <input type="file" id="btn-file-TSRCO" name="archivoCorregido" accept=".doc, .docx">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @elseif($searchReport->state === 'Debe corregirse' && session('role') === 'Coordinador')
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <div class="stateDocument">
                                        <a href="{{ asset($searchReport->correctDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $searchReport->nameCorrectDocument }}
                                        </a>
                                        <form id="formTSRCC" action="{{ route('topicSearchReport.changeCorrect', ['idcId' => $searchReport->idcId, 
                                            'idTopicSearchReport' => $idTopicSearchReport]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fas fa-file"></i>
                                                Adjuntar otro documento
                                                <label for="btn-file-TSRCC"></label>
                                                <input type="file" id="btn-file-TSRCC" name="archivoCorrecciones" accept=".doc, .docx">
                                            </button>
                                        </form>
                                    </div>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>Por subirse</td>
                        </tr>
                    @endif

                    @if($searchReport->state === 'Corregido')
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($searchReport->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $searchReport->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <strong>
                                    <div class="stateDocument">
                                        <a href="{{ asset($searchReport->correctedDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $searchReport->nameCorrectedDocument }}
                                        </a>
                                        @if(session('role') === 'Docente')
                                            <form id="formTSRCCO" action="{{ route('topicSearchReport.changeCorrected', ['idcId' => $searchReport->idcId, 
                                                'idTopicSearchReport' => $idTopicSearchReport]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <button type="button" class="contenedor-btn-file">
                                                    <i class="fas fa-file"></i>
                                                    Adjuntar otro documento
                                                    <label for="btn-file-TSRCCO"></label>
                                                    <input type="file" id="btn-file-TSRCCO" name="archivoCorregido" accept=".doc, .docx">
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </strong>
                            </td>
                        </tr>

                        @if(session('role') === 'Coordinador')
                            <tr>
                                <td><strong>Comentarios al envío</strong></td>
                                <td>
                                    <div class="stateDocument">
                                        <form action="{{ route('topicSearchReport.approveCorrected', ['idcId' => $searchReport->idcId, 
                                            'idTopicSearchReport' => $idTopicSearchReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-check"></i>Aprobar Documento</button>
                                        </form>
                                        <form action="{{ route('topicSearchReport.decline', ['idcId' => $searchReport->idcId, 
                                            'idTopicSearchReport' => $idTopicSearchReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-xmark"></i>Rechazar Documento</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif 
                    @endif

                    @if($searchReport->state === 'En revisión')
                        <tr>
                            <td><strong>Comentarios al envío</strong></td>
                            <td>
                                @if(session('role') === 'Coordinador')
                                    <div class="stateDocument">
                                        <form action="{{ route('topicSearchReport.approve', ['idcId' => $searchReport->idcId, 
                                            'idTopicSearchReport' => $idTopicSearchReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-check"></i>Aprobar Documento</button>
                                        </form>
                                        <form id="formTSRC" action="{{ route('topicSearchReport.correct', ['idcId' => $searchReport->idcId, 
                                            'idTopicSearchReport' => $idTopicSearchReport]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fas fa-file"></i>
                                                Adjuntar archivo con correcciones
                                                <label for="btn-file-TSRC"></label>
                                                <input type="file" id="btn-file-TSRC" name="archivoCorrecciones" accept=".doc, .docx">
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    No hay comentarios por el momento
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if($searchReport->state === 'Sin Intento' && (session('role') === 'Docente' || session('role') === 'Estudiante')) 
                <div class="title">
                    <a href="{{ route('topicSearchReport', ['idcId' => $searchReport->idcId, 
                        'idTopicSearchReport' => $idTopicSearchReport]) }}" class="btn-login">
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