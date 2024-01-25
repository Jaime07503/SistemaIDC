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
                                <strong><a href="{{ asset($nextIdcTopicReport->storagePath) }}" 
                                    class="link-document"><i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nextIdcTopicReportCode }}
                                </a></strong>
                            </td>
                        @endif
                    </tr>
                    @if($nextIdcTopicReport->state === 'Aprobado' && $nextIdcTopicReport->previousState === 'Corregido')
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <strong><a href="{{ asset($nextIdcTopicReport->correctedDocStoragePath) }}" class="link-document">
                                    <i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nameCorrectedDoc }}
                                </a></strong>
                            </td>
                        </tr>
                    @endif

                    @if($nextIdcTopicReport->state === 'Debe corregirse' && session('role') === 'Docente')
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <input type="file" id="archivo" accept=".doc, .docx">
                                <button>Subir Documento</button>
                            </td>
                        </tr>
                    @elseif($nextIdcTopicReport->state === 'Debe corregirse' && session('role') === 'Coordinador')
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>Por subirse</td>
                        </tr>
                    @endif

                    @if($nextIdcTopicReport->state === 'Corregido')
                        <tr>
                            <td><strong>Archivo corregido</strong></td>
                            <td>
                                <strong><a href="{{ asset($nextIdcTopicReport->storagePath) }}" class="link-document">
                                    <i class="fa-regular fa-file-word"></i> {{ $nextIdcTopicReport->nextIdcTopicReportCode }}
                                </a></strong>
                            </td>
                        </tr>

                        @if(session('role') === 'Coordinador')
                            <tr>
                                <td><strong>Comentarios al envío</strong></td>
                                <td>
                                    <button class="btn">Aprobar Documento</button>
                                    <button class="btn">Corregir Documento</button>
                                </td>
                            </tr>
                        @endif 
                    @endif

                    @if($nextIdcTopicReport->state === 'En revisión')
                        <tr>
                            <td><strong>Comentarios al envío</strong></td>
                            <td>
                                @if(session('role') === 'Coordinador')
                                    <button class="btn">Aprobar Documento</button>
                                    <button class="btn">Corregir Documento</button>
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
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/searchInformation.js') }}"></script>
@endsection