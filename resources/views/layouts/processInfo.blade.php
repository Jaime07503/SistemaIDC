@extends('layout')

@section('title')
    Información del proceso
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/processInfo.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>{{ $researchTopic->themeName }} - Equipo #{{ $researchTopic->teamId }} - Documentación</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis investigaciones</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $researchTopic->researchTopicId, 'subjectId' => $researchTopic->subjectId]) }}">{{ $researchTopic->code }}</a>
                <a class="history-view" href="{{ route('stagesProcess', ['researchTopicId' => $researchTopic->researchTopicId, 
                    'teamId' => $researchTopic->teamId, 'idcId' => $researchTopic->idcId]) }}">Etapas del proceso
                </a>
                <a class="history-view" href="">Documentación</a>
            </nav>
        </div>
        <div class="information-content">
            <section class="documents-content">
                <header class="title">
                    Documentación
                </header>
                <div class="documents">
                    <div class="document">
                        <i class="fa-regular fa-file-word"></i>
                        <a href="http://localhost/SistemaIDC/public/documents/Resumen_Pelicula_Jobs.docx"> Resumen Pelicula Jobs </a>
                    </div>
                    <div class="document">
                        <i class="fa-regular fa-file-pdf"></i>
                        <a href="http://localhost/SistemaIDC/public/documents/Integrated_Activity.pdf" target="_blank" rel="noreferrer"> Integrate Activity </a>
                    </div>
                </div>
            </section>
            <section class="presentations-content">
                <header class="title">
                    Presentaciones
                </header>
                <div class="documents">
                    <div class="document">
                        <i class="fa-regular fa-file-powerpoint"></i>
                        <a href="http://localhost/SistemaIDC/public/documents/IDS.pptx"> IDS Snort </a>
                    </div>
                    <div class="document">
                        <i class="fa-regular fa-file-powerpoint"></i>
                        <a href="http://localhost/SistemaIDC/public/documents/IDS.pptx"> Formato de los documentos </a>
                    </div>
                </div>
            </section>
            <section class="videos-content">
                <header class="title">
                    Videos
                </header>
                <div class="documents">
                    <div class="document">
                        <i class="fa-solid fa-circle-play"></i> 
                        <a href="https://www.youtube.com/embed/RwjgfNX41TE" target="_blank" rel="noreferrer"> Redacción de artículo científico </a>
                    </div>
                    <div class="document">
                        <i class="fa-solid fa-circle-play"></i>   
                        <a href="https://www.youtube.com/embed/RwjgfNX41TE" target="_blank" rel="noreferrer"> Búsqueda de información </a>
                    </div>
                </div>
            </section>
            <section class="aditional-content">
                <header class="title title-ac">
                    Documentación adicional
                    @if(auth()->user()->role === 'Docente')
                        <form id="formAditionalDocument" action="{{ route('document.add', ['idcId' => $researchTopic->idcId]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <button type="button" class="contenedor-btn-file">
                                <i class="fas fa-file"></i>
                                Adjuntar archivo
                                <label for="btn-file-ad"></label>
                                <input type="text" name="researchTopicId" hidden value="{{ $researchTopic->researchTopicId }}">
                                <input type="file" id="btn-file-ad" name="documento" accept=".doc, .docx, .pdf, .pptx, .ppt">
                            </button>
                        </form>
                    @endif
                </header>
                <div class="documents-specifics">
                    <div class="documents">
                        @foreach($documents as $document)
                            <div class="document">
                                @if($document->documentType === 'Word')
                                    <i class="fa-regular fa-file-word"></i>
                                @elseif($document->documentType === 'PowerPoint')
                                    <i class="fa-regular fa-file-powerpoint"></i>
                                @elseif($document->documentType === 'PDF')
                                    <i class="fa-regular fa-file-pdf"></i>
                                @endif
                                <a href="{{ asset($document->storagePath) }}">{{ $document->nameDocument }}</a>
                                @if(auth()->user()->role === 'Docente')
                                    <form action="{{ route('document.delete', ['trainingDocumentId' => $document->trainingDocumentId]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="text" name="researchTopicId" hidden value="{{ $researchTopic->researchTopicId }}">
                                        <button class="btn btn-delete">
                                            <i class="fa-solid fa-trash" id="icon-delete"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/processInfo.js') }}"></script>
@endsection