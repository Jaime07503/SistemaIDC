@extends('layout')

@section('title')
    Documentos generados
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/generateDocuments.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1 class="head-lbl">Documentos Generados</h1>
            <nav class="history">
                <a class="history-view" href="{{ route('home') }}">Inicio del Sitio</a>
                <a class="history-view">Documentos generados</a>
            </nav>
        </div>
        <div class="documents-content">
            <header class="head-title"><strong>Informes de Búsqueda de Selección de Información</strong></header>
            @if($topicSearchReports->isEmpty())
                <h3 class="empty">No hay <strong>Informes de Búsqueda de Selección de Infomación</strong></h3>
            @else
                <table class="table content-table">
                    <thead>
                        <tr>
                            <td>Equipo</td>
                            <td>Documento Generado</td>
                            <td>Documento con Correcciones</td>
                            <td>Documento Corregido</td>
                            <td>Estado</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topicSearchReports as $topicSearchReport)
                            <tr>
                                <td data-values="Equipo">{{ $topicSearchReport->teamId }}</td>
                                <td data-values="Documento Generado">
                                    @if($topicSearchReport->storagePath !== 'Por generar')
                                        <a href="{{ asset($topicSearchReport->storagePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $topicSearchReport->code }}
                                        </a>
                                    @else
                                        <h4>{{ $topicSearchReport->storagePath }}</h4>
                                    @endif
                                </td>
                                <td data-values="Documento con Correcciones">
                                    @if($topicSearchReport->correctDocumentStoragePath !== 'Sin Intento')
                                        <a href="{{ asset($topicSearchReport->correctDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $topicSearchReport->nameCorrectDocument }}
                                        </a>
                                        @if($topicSearchReport->state === 'Debe corregirse')
                                        <form id="formTSRCC" action="{{ route('topicSearchReport.changeCorrect', ['idcId' => $topicSearchReport->idIdc, 
                                            'idTopicSearchReport' => $topicSearchReport->topicSearchReportId]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fa-solid fa-paperclip"></i>
                                                <label for="btn-file-TSRCC"></label>
                                                <input type="file" id="btn-file-TSRCC" name="archivoCorrecciones" accept=".doc, .docx">
                                            </button>
                                        </form>
                                        @endif
                                    @else
                                        <h4>{{ $topicSearchReport->correctDocumentStoragePath }}</h4>
                                    @endif 
                                </td>
                                <td data-values="Documento Corregido">
                                    @if($topicSearchReport->correctedDocumentStoragePath !== 'Sin Intento')
                                        <a href="{{ asset($topicSearchReport->correctedDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $topicSearchReport->nameCorrectedDocument }}
                                        </a>
                                    @else
                                        <h4>{{ $topicSearchReport->correctedDocumentStoragePath }}</h4>
                                    @endif 
                                </td>
                                <td data-values="Estado" >
                                    <h4 class="@if($topicSearchReport->state === 'En revisión') stateEnRevision @elseif($topicSearchReport->state === 'Corregido') stateCorregido 
                                    @elseif($topicSearchReport->state === 'Debe corregirse') stateDebeCorregirse  @elseif($topicSearchReport->state === 'Rechazado') stateRechazado 
                                    @elseif($topicSearchReport->state === 'Aprobado') stateAprobado @endif">{{ $topicSearchReport->state }}</h4>
                                </td>
                                <td data-values="Acciones">
                                    @if($topicSearchReport->state === 'En revisión')
                                        <div class="stateDocument">
                                            <form action="{{ route('topicSearchReport.approve', ['idcId' => $topicSearchReport->idIdc, 
                                                'idTopicSearchReport' => $topicSearchReport->topicSearchReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-check"></i></button>
                                            </form>
                                            <form id="formTSRC" action="{{ route('topicSearchReport.correct', ['idcId' => $topicSearchReport->idIdc, 
                                                'idTopicSearchReport' => $topicSearchReport->topicSearchReportId]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <button type="button" class="contenedor-btn-file">
                                                    <i class="fa-solid fa-paperclip"></i>
                                                    <label for="btn-file-TSRC"></label>
                                                    <input type="file" id="btn-file-TSRC" name="archivoCorrecciones" accept=".doc, .docx">
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($topicSearchReport->state === 'Corregido')
                                    <div class="stateDocument">
                                            <form action="{{ route('topicSearchReport.approveCorrected', ['idcId' => $topicSearchReport->idIdc, 
                                                'idTopicSearchReport' => $topicSearchReport->topicSearchReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-check"></i></button>
                                            </form>
                                            <form action="{{ route('topicSearchReport.decline', ['idcId' => $topicSearchReport->idIdc, 
                                                'idTopicSearchReport' => $topicSearchReport->topicSearchReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-xmark"></i></button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <header class="head-title"><strong>Informes de Artículo Científico</strong></header>
            @if($scientificArticleReports->isEmpty())
                <h3 class="empty">No hay <strong>Informes de Búsqueda de Artículo Científico</strong></h3>
            @else
                <table class="table content-table">
                    <thead>
                        <tr>
                            <td>Equipo</td>
                            <td>Documento Generado</td>
                            <td>Documento con Imágenes</td>
                            <td>Documento con Correcciones</td>
                            <td>Documento Corregido</td>
                            <td>Estado</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scientificArticleReports as $scientificArticleReport)
                            <tr>
                                <td data-values="Equipo">{{ $scientificArticleReport->teamId }}</td>
                                <td data-values="Documento Generado">
                                    @if($scientificArticleReport->storagePath !== 'Por generar')
                                        <a href="{{ asset($scientificArticleReport->storagePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $scientificArticleReport->code }}
                                        </a>
                                    @else
                                        <h4>{{ $scientificArticleReport->storagePath }}</h4>
                                    @endif
                                </td>
                                <td data-values="Documento con Imágenes">
                                    @if($scientificArticleReport->documentImageStoragePath !== 'Sin Intento')
                                        <a href="{{ asset($scientificArticleReport->documentImageStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                        {{ $scientificArticleReport->nameDocumentImage }}
                                        </a>
                                    @else
                                        <h4>{{ $scientificArticleReport->documentImageStoragePath }}</h4>
                                    @endif 
                                </td>
                                <td data-values="Documento con Correcciones">
                                    @if($scientificArticleReport->correctDocumentStoragePath !== 'Sin Intento')
                                        <a href="{{ asset($scientificArticleReport->correctDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $scientificArticleReport->nameCorrectDocument }}
                                        </a>
                                        @if($scientificArticleReport->state === 'Debe corregirse')
                                            <form id="formSARDC" action="{{ route('scientificArticleReport.changeCorrect', ['idcId' => $scientificArticleReport->idIdc, 
                                                'idScientificArticleReport' => $scientificArticleReport->scientificArticleReportId]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <button type="button" class="contenedor-btn-file">
                                                    <i class="fa-solid fa-paperclip"></i>
                                                    <label for="btn-file-SARDC"></label>
                                                    <input type="file" id="btn-file-SARDC" name="archivoCorrecciones" accept=".doc, .docx">
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <h4>{{ $scientificArticleReport->correctDocumentStoragePath }}</h4>
                                    @endif 
                                </td>
                                <td data-values="Documento Corregido">
                                    @if($scientificArticleReport->correctedDocumentStoragePath !== 'Sin Intento')
                                        <a href="{{ asset($scientificArticleReport->correctedDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $scientificArticleReport->nameCorrectedDocument }}
                                        </a>
                                    @else
                                        <h4>{{ $scientificArticleReport->correctedDocumentStoragePath }}</h4>
                                    @endif 
                                </td>
                                <td data-values="Estado"><h4 class="@if($scientificArticleReport->state === 'En revisión') stateEnRevision @elseif($scientificArticleReport->state === 'Corregido') stateCorregido 
                                    @elseif($scientificArticleReport->state === 'Aprobado') stateAprobado @endif">{{ $scientificArticleReport->state }}</h4>
                                </td>
                                <td data-values="Acciones">
                                    @if($scientificArticleReport->state === 'En revisión')
                                        <div class="stateDocument">
                                            <form action="{{ route('scientificArticleReport.approve', ['idcId' => $scientificArticleReport->idIdc, 
                                                'idScientificArticleReport' => $scientificArticleReport->scientificArticleReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-check"></i></button>
                                            </form>
                                            <form id="formSARC" action="{{ route('scientificArticleReport.correct', ['idcId' => $scientificArticleReport->idIdc, 
                                                'idScientificArticleReport' => $scientificArticleReport->scientificArticleReportId]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <button type="button" class="contenedor-btn-file">
                                                    <i class="fa-solid fa-paperclip"></i>
                                                    <label for="btn-file-SARC"></label>
                                                    <input type="file" id="btn-file-SARC" name="archivoCorrecciones" accept=".doc, .docx">
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($scientificArticleReport->state === 'Corregido')
                                        <div class="stateDocument">
                                            <form action="{{ route('scientificArticleReport.approveCorrected', ['idcId' => $scientificArticleReport->idIdc, 
                                                'idScientificArticleReport' => $scientificArticleReport->scientificArticleReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-check"></i></button>
                                            </form>
                                            <form action="{{ route('scientificArticleReport.decline', ['idcId' => $scientificArticleReport->idIdc, 
                                                'idScientificArticleReport' => $scientificArticleReport->scientificArticleReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-xmark"></i></button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <header class="head-title"><strong>Informes de Temas para próxima IDC</strong></header>
            @if($nextIdcTopicReports->isEmpty())
                <h3 class="empty">No hay <strong>Informes de Temas para próxima IDC</strong></h3>
            @else
                <table class="table content-table">
                    <thead>
                        <tr>
                            <td>Equipo</td>
                            <td>Documento Generado</td>
                            <td>Documento con Correcciones</td>
                            <td>Documento Corregido</td>
                            <td>Estado</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nextIdcTopicReports as $nextIdcTopicReport)
                            <tr>
                                <td data-values="Equipo">{{ $nextIdcTopicReport->teamId }}</td>
                                <td data-values="Documento Generado">
                                    @if($nextIdcTopicReport->storagePath !== 'Por generar')
                                        <a href="{{ asset($nextIdcTopicReport->storagePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $nextIdcTopicReport->code }}
                                        </a>
                                    @else
                                        <h4>{{ $nextIdcTopicReport->storagePath }}</h4>
                                    @endif
                                </td>
                                <td data-values="Documento con Correcciones">
                                    @if($nextIdcTopicReport->correctDocumentStoragePath !== 'Sin Intento')
                                        <a href="{{ asset($nextIdcTopicReport->correctDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $nextIdcTopicReport->nameCorrectDocument }}
                                        </a>
                                        @if($nextIdcTopicReport->state === 'Debe corregirse')
                                        <form id="formNTRCO" action="{{ route('nextIdcTopicReport.changeCorrect', ['idcId' => $nextIdcTopicReport->idIdc, 
                                            'idNextIdcTopicReport' => $nextIdcTopicReport->nextIdcTopicReportId]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fa-solid fa-paperclip"></i>
                                                <label for="btn-file-NTRCO"></label>
                                                <input type="file" id="btn-file-NTRCO" name="archivoCorrecciones" accept=".doc, .docx">
                                            </button>
                                        </form>
                                        @endif
                                    @else
                                        <h4>{{ $nextIdcTopicReport->correctDocumentStoragePath }}</h4>
                                    @endif 
                                </td>
                                <td data-values="Documento Corregido">
                                    @if($nextIdcTopicReport->correctedDocumentStoragePath !== 'Sin Intento')
                                        <a href="{{ asset($nextIdcTopicReport->correctedDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i>
                                            {{ $nextIdcTopicReport->nameCorrectedDocument }}
                                        </a>
                                    @else
                                        <h4>{{ $nextIdcTopicReport->correctedDocumentStoragePath }}</h4>
                                    @endif 
                                </td>
                                <td data-values="Estado"><h4 class="@if($nextIdcTopicReport->state === 'En revisión') stateEnRevision @elseif($nextIdcTopicReport->state === 'Corregido') stateCorregido  
                                    @elseif($nextIdcTopicReport->state === 'Debe corregirse') stateDebeCorregirse  @elseif($nextIdcTopicReport->state === 'Rechazado') stateRechazado 
                                    @elseif($nextIdcTopicReport->state === 'Aprobado') stateAprobado @endif">{{ $nextIdcTopicReport->state }}</h4>
                                </td>
                                <td data-values="Acciones">
                                    @if($nextIdcTopicReport->state === 'En revisión')
                                        <div class="stateDocument">
                                            <form action="{{ route('nextIdcTopicReport.approve', ['idcId' => $nextIdcTopicReport->idIdc, 
                                                'idNextIdcTopicReport' => $nextIdcTopicReport->nextIdcTopicReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-check"></i></button>
                                            </form>
                                            <form id="formNTRC" action="{{ route('nextIdcTopicReport.correct', ['idcId' => $nextIdcTopicReport->idIdc, 
                                                'idNextIdcTopicReport' => $nextIdcTopicReport->nextIdcTopicReportId]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <button type="button" class="contenedor-btn-file">
                                                    <i class="fa-solid fa-paperclip"></i>
                                                    <label for="btn-file-NTRC"></label>
                                                    <input type="file" id="btn-file-NTRC" name="archivoCorrecciones" accept=".doc, .docx">
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($nextIdcTopicReport->state === 'Corregido')
                                        <div class="stateDocument">
                                            <form action="{{ route('nextIdcTopicReport.approveCorrected', ['idcId' => $nextIdcTopicReport->idIdc, 
                                                'idNextIdcTopicReport' => $nextIdcTopicReport->nextIdcTopicReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-check"></i></button>
                                            </form>
                                            <form action="{{ route('nextIdcTopicReport.decline', ['idcId' => $nextIdcTopicReport->idIdc, 
                                                'idNextIdcTopicReport' => $nextIdcTopicReport->nextIdcTopicReportId]) }}" method="POST">
                                                @csrf
                                                <button class="btn"><i class="fa-solid fa-xmark"></i></button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/generateDocuments.js') }}"></script>
@endsection