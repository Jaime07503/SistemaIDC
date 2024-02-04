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
            <table class="table content-table">
                <tbody>
                    <tr>
                        <td><strong>Estatus del informe</strong></td>
                        @if($nextIdcTopicReport->state === null)
                            <td>Sin Intento</td>
                        @else 
                            <td><strong>{{ $nextIdcTopicReport->state }}</strong></td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Fecha de entrega</strong></td>
                        <td>{{ $formattedDeadline }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tiempo restante</strong></td>
                        @if($nextIdcTopicReport->state === 'Sin Intento')
                            <td>{{ $timeRemaining }}</td>
                        @else
                            <td>El documento fue creado: <strong>{{ $formattedupdated_at }}</strong></td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>Archivo generado</strong></td>
                        @if($nextIdcTopicReport->storagePath === 'Por generar')
                            <td>{{ $nextIdcTopicReport->storagePath }}</td>
                        @else
                            <td>
                                <strong>
                                    <a href="{{ asset($nextIdcTopicReport->storagePath) }}" 
                                        class="link-document"><i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nextIdcTopicReportCode }}
                                    </a>
                                </strong>
                            </td>
                        @endif
                    </tr>

                    @if(($nextIdcTopicReport->state === 'Aprobado' || $nextIdcTopicReport->state === 'Rechazado') && $nextIdcTopicReport->previousState === 'Corregido')
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($nextIdcTopicReport->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <strong>
                                    <a href="{{ asset($nextIdcTopicReport->correctedDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nameCorrectedDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                    @endif

                    @if($nextIdcTopicReport->state === 'Debe corregirse' && session('role') === 'Docente')
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($nextIdcTopicReport->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <form id="formNTRCO" action="{{ route('nextIdcTopicReport.corrected', ['idcId' => $nextIdcTopicReport->idcId, 
                                    'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" class="contenedor-btn-file">
                                        <i class="fas fa-file"></i>
                                        Adjuntar archivo corregido
                                        <label for="btn-file-NTRCO"></label>
                                        <input type="file" id="btn-file-NTRCO" name="archivoCorregido" accept=".doc, .docx">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @elseif($nextIdcTopicReport->state === 'Debe corregirse' && session('role') === 'Coordinador')
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <div class="stateDocument">
                                        <a href="{{ asset($nextIdcTopicReport->correctDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nameCorrectDocument }}
                                        </a>
                                        <form id="formNTRCO" action="{{ route('nextIdcTopicReport.changeCorrect', ['idcId' => $nextIdcTopicReport->idcId, 
                                            'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fas fa-file"></i>
                                                Adjuntar otro documento
                                                <label for="btn-file-NTRCO"></label>
                                                <input type="file" id="btn-file-NTRCO" name="archivoCorrecciones" accept=".doc, .docx">
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

                    @if($nextIdcTopicReport->state === 'Corregido')
                        <tr>
                            <td>
                                <strong>Archivo con correcciones</strong>
                            </td>
                            <td>
                                <strong>
                                    <a href="{{ asset($nextIdcTopicReport->correctDocumentStoragePath) }}" class="link-document">
                                        <i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nameCorrectDocument }}
                                    </a>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <strong>
                                    <div class="stateDocument">
                                        <a href="{{ asset($nextIdcTopicReport->correctedDocumentStoragePath) }}" class="link-document">
                                            <i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nameCorrectedDocument }}
                                        </a>
                                        @if(session('role') === 'Docente')
                                            <form id="formNTRCOC" action="{{ route('nextIdcTopicReport.changeCorrected', ['idcId' => $nextIdcTopicReport->idcId, 
                                                'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <button type="button" class="contenedor-btn-file">
                                                    <i class="fas fa-file"></i>
                                                    Adjuntar otro documento
                                                    <label for="btn-file-NTRCOC"></label>
                                                    <input type="file" id="btn-file-NTRCOC" name="archivoCorregido" accept=".doc, .docx">
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
                                        <form action="{{ route('nextIdcTopicReport.approveCorrected', ['idcId' => $nextIdcTopicReport->idcId, 
                                            'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-check"></i>Aprobar Documento</button>
                                        </form>
                                        <form action="{{ route('nextIdcTopicReport.decline', ['idcId' => $nextIdcTopicReport->idcId, 
                                            'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-xmark"></i>Rechazar Documento</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif 
                    @endif

                    @if($nextIdcTopicReport->state === 'En revisión')
                        <tr>
                            <td><strong>Comentarios al envío</strong></td>
                            <td>
                                @if(session('role') === 'Coordinador')
                                    <div class="stateDocument">
                                        <form action="{{ route('nextIdcTopicReport.approve', ['idcId' => $nextIdcTopicReport->idcId, 
                                            'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST">
                                            @csrf
                                            <button class="btn"><i class="fa-solid fa-check"></i>Aprobar Documento</button>
                                        </form>
                                        <form id="formNTRC" action="{{ route('nextIdcTopicReport.correct', ['idcId' => $nextIdcTopicReport->idcId, 
                                            'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="contenedor-btn-file">
                                                <i class="fas fa-file"></i>
                                                Adjuntar archivo con correcciones
                                                <label for="btn-file-NTRC"></label>
                                                <input type="file" id="btn-file-NTRC" name="archivoCorrecciones" accept=".doc, .docx">
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
            @if($nextIdcTopicReport->state === 'Sin Intento' && (session('role') === 'Docente' || session('role') === 'Estudiante')) 
                <div class="title">
                    <a href="{{ route('nextIdcTopicReport', ['idcId' => $nextIdcTopicReport->idcId,
                        'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" class="btn-login">
                        @if(session('role') === 'Docente')
                            <h4>Crear Informe</h4>
                        @elseif(session('role') === 'Estudiante')
                            <h4>Aportar al Informe</h4>
                        @endif
                    </a>
                </div>
            @endif
        </div>
        @if($nextIdcTopicReport->state === 'Aprobado' && $commentA === 'No ha comentado')
            <div class="finalComments">
                <header>
                    <strong><h2>Comentarios finales sobre IDC</h2></strong>
                </header>
                @if(auth()->user()->role === 'Docente')
                    <form id="formCommentTeacher" action="{{ route('comment.create', ['idcId' => $nextIdcTopicReport->idcId, 'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST">
                        @csrf
                        <textarea class="textarea textareaC" name="commentsIdc" placeholder="Comentarios sobre el proceso IDC" maxlength="500"></textarea>
                        <textarea class="textarea textareaC" name="opportunityForImprovements" placeholder="Oportunidades de mejora" maxlength="500"></textarea>
                        <div id="notificationCT" class="notificationM"></div>
                        <button type="submit" class="btn btn-save-comments">Guardar Información</button>
                    </form>
                @elseif(auth()->user()->role === 'Estudiante')
                    <form id="formCommentStudent" action="{{ route('comment.create', ['idcId' => $nextIdcTopicReport->idcId, 'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}" method="POST">
                        @csrf
                        <textarea class="textarea textareaC" name="commentsIdc" placeholder="Comentarios sobre el proceso IDC" maxlength="500"></textarea>
                        <div id="notificationCS" class="notificationM"></div>
                        <button type="submit" class="btn btn-save-comments">Guardar Información</button>
                    </form>
                @elseif(auth()->user()->role === 'Coordinador' || auth()->user()->role === 'Administrador del Proceso' || auth()->user()->role === 'Administrador del Sistema')
                    @foreach($comments as $comment)
                        <h2>{{ $comment->whoContributes }}</h2>
                        @if($comment->opportunityForImprovements !== null)
                            <textarea class="textarea textareaCOR" name="opportunityForImprovements" id="opportunityForImprovements" readonly>{{ $comment->opportunityForImprovements }}</textarea>
                        @endif
                        <textarea class="textarea textareaCOR" name="comment" id="comments" readonly>{{ $comment->commentsIdc }}</textarea>
                    @endforeach
                @endif
            </div>
        @endif
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/endProcess.js') }}"></script>
@endsection