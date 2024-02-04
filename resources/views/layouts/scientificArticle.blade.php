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
            <table class="table content-table">
                <tbody>
                    <tr>
                        <td><strong>Estatus del informe</strong></td>
                        @if($scientificArticle->state === null)
                            <td>Sin Intento</td>
                        @else 
                            <td><strong>{{ $scientificArticle->state }}</strong></td>
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
                                <strong>
                                    <a href="{{ asset($scientificArticle->storagePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->scientificArticleCode }}
                                    </a>
                                </strong>
                            </td>
                        @endif
                    </tr>
                    @if(($scientificArticle->state === 'Aprobado' || $scientificArticle->state === 'Rechazado') && $scientificArticle->previousState === 'Corregido')
                        @if($scientificArticle->documentImageStoragePath !== 'Sin Intento')
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>
                                    <strong>
                                        <a href="{{ asset($scientificArticle->documentImageStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameDocumentImage }}
                                        </a>
                                    </strong>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>{{ $scientificArticle->documentImageStoragePath }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($scientificArticle->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <strong>
                                    <a href="{{ asset($scientificArticle->correctedDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameCorrectedDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                    @elseif($scientificArticle->state === 'Aprobado')
                        @if($scientificArticle->documentImageStoragePath !== 'Sin Intento')
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>
                                    <strong>
                                        <a href="{{ asset($scientificArticle->documentImageStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameDocumentImage }}
                                        </a>
                                    </strong>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>{{ $scientificArticle->documentImageStoragePath }}</td>
                            </tr>
                        @endif
                    @endif

                    @if($scientificArticle->state === 'Debe corregirse' && session('role') === 'Docente')
                        @if($scientificArticle->documentImageStoragePath !== 'Sin Intento')
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>
                                    <strong>
                                        <a href="{{ asset($scientificArticle->documentImageStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameDocumentImage }}
                                        </a>
                                    </strong>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>{{ $scientificArticle->documentImageStoragePath }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($scientificArticle->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <form id="formSARCO" action="{{ route('scientificArticleReport.corrected', ['idcId' => $scientificArticle->idcId, 
                                    'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" class="contenedor-btn-file">
                                        <i class="fas fa-file"></i>
                                        Adjuntar archivo corregido
                                        <label for="btn-file-SARCO"></label>
                                        <input type="file" id="btn-file-SARCO" name="archivoCorregido" accept=".doc, .docx">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @elseif($scientificArticle->state === 'Debe corregirse' && session('role') === 'Coordinador')
                        @if($scientificArticle->documentImageStoragePath !== 'Sin Intento')
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>
                                    <strong>
                                        <a href="{{ asset($scientificArticle->documentImageStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameDocumentImage }}
                                        </a>
                                    </strong>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>{{ $scientificArticle->documentImageStoragePath }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <div class="stateDocument">
                                        <a href="{{ asset($scientificArticle->correctDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameCorrectDocument }}
                                        </a>
                                        <form id="formSARDC" action="{{ route('scientificArticleReport.changeCorrect', ['idcId' => $scientificArticle->idcId, 
                                            'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fas fa-file"></i>
                                                Adjuntar otro documento
                                                <label for="btn-file-SARDC"></label>
                                                <input type="file" id="btn-file-SARDC" name="archivoCorrecciones" accept=".doc, .docx">
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
                    @elseif($scientificArticle->state === 'Debe corregirse' && session('role') === 'Estudiante')
                        @if($scientificArticle->documentImageStoragePath !== 'Sin Intento')
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>
                                    <strong>
                                        <a href="{{ asset($scientificArticle->documentImageStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameDocumentImage }}
                                        </a>
                                    </strong>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>{{ $scientificArticle->documentImageStoragePath }}</td>
                            </tr>
                        @endif
                    @endif

                    @if($scientificArticle->state === 'Corregido')
                        @if($scientificArticle->documentImageStoragePath !== 'Sin Intento')
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>
                                    <strong>
                                        <a href="{{ asset($scientificArticle->documentImageStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameDocumentImage }}
                                        </a>
                                    </strong>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>Archivo con imágenes</strong></td>
                                <td>{{ $scientificArticle->documentImageStoragePath }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($scientificArticle->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <strong>
                                    <div class="stateDocument">
                                        <a href="{{ asset($scientificArticle->correctedDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameCorrectedDocument }}
                                        </a>
                                        @if(session('role') === 'Docente')
                                            <form id="formSARDCO" action="{{ route('scientificArticleReport.changeCorrected', ['idcId' => $scientificArticle->idcId, 
                                                'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <button type="button" class="contenedor-btn-file">
                                                    <i class="fas fa-file"></i>
                                                    Adjuntar otro documento
                                                    <label for="btn-file-SARDCO"></label>
                                                    <input type="file" id="btn-file-SARDCO" name="archivoCorregido" accept=".doc, .docx">
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
                                        <form action="{{ route('scientificArticleReport.approveCorrected', ['idcId' => $scientificArticle->idcId, 
                                            'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-check"></i>Aprobar Documento</button>
                                        </form>
                                        <form action="{{ route('scientificArticleReport.decline', ['idcId' => $scientificArticle->idcId, 
                                            'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-xmark"></i>Rechazar Documento</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif 
                    @endif

                    @if($scientificArticle->state === 'En revisión')
                        <tr>
                            <td><strong>Archivo con imágenes</strong></td>
                            @if(auth()->user()->role === 'Docente' && $scientificArticle->documentImageStoragePath === 'Sin Intento')
                                <td>
                                    <form id="formSARDI" action="{{ route('scientificArticleReport.docImage', ['idcId' => $scientificArticle->idcId, 
                                        'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button type="button" class="contenedor-btn-file">
                                            <i class="fas fa-file"></i>
                                            Adjuntar archivo con Imágenes
                                            <label for="btn-file-SARDI"></label>
                                            <input type="file" id="btn-file-SARDI" name="archivoImagenes" accept=".doc, .docx">
                                        </button>
                                    </form>
                                </td>
                            @elseif(auth()->user()->role === 'Docente' && $scientificArticle->documentImageStoragePath !== 'Sin Intento')
                                <td>
                                   <div class="stateDocument">
                                    <strong>
                                            <a href="{{ asset($scientificArticle->documentImageStoragePath) }}" class="link-document">
                                                <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameDocumentImage }}
                                            </a>
                                        </strong>
                                        <form id="formSARDI" action="{{ route('scientificArticleReport.changeDocImage', ['idcId' => $scientificArticle->idcId, 
                                            'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fas fa-file"></i>
                                                Adjuntar otro archivo
                                                <label for="btn-file-SARDI"></label>
                                                <input type="file" id="btn-file-SARDI" name="archivoImagenes" accept=".doc, .docx">
                                            </button>
                                        </form>
                                   </div>
                                </td>
                            @else
                                @if($scientificArticle->documentImageStoragePath === 'Sin Intento')
                                    <td>{{ $scientificArticle->documentImageStoragePath }}</td>
                                @else
                                    <td>
                                        <strong>
                                            <a href="{{ asset($scientificArticle->documentImageStoragePath) }}" class="link-document">
                                                <i class="fa-regular fa-file-word"></i> {{ $scientificArticle->nameDocumentImage }}
                                            </a>
                                        </strong>
                                    </td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            <td><strong>Comentarios al envío</strong></td>
                            <td>
                                @if(session('role') === 'Coordinador')
                                    <div class="stateDocument">
                                        <form action="{{ route('scientificArticleReport.approve', ['idcId' => $scientificArticle->idcId, 
                                            'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-check"></i>Aprobar Documento</button>
                                        </form>
                                        <form id="formSARC" action="{{ route('scientificArticleReport.correct', ['idcId' => $scientificArticle->idcId, 
                                            'idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fas fa-file"></i>
                                                Adjuntar archivo con correcciones
                                                <label for="btn-file-SARC"></label>
                                                <input type="file" id="btn-file-SARC" name="archivoCorrecciones" accept=".doc, .docx">
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
            @if($scientificArticle->state === 'Sin Intento' && (session('role') === 'Docente' || session('role') === 'Estudiante')) 
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
    <script src=" {{ asset('js/scientificArticle.js') }}"></script>
@endsection