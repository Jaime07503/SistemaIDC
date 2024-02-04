@extends('layout')

@section('title')
    {{ $researchTopic->themeName }} - Etapas del Proceso
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/stagesProcess.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Encabezado e Historial de vistas -->
        <header class="head-content">
            <h1 class="head-lbl">{{ $researchTopic->themeName }} - Equipo #{{ $researchTopic->teamId }} - Etapas del proceso</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" >Mis investigaciones</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $researchTopic->researchTopicId, 'subjectId' => $researchTopic->subjectId]) }}">{{ $researchTopic->code }}</a>
                <a class="history-view" href="">Etapas del proceso</a>
            </nav>
        </header>
        <!-- Vista general de las etapas del proceso -->
        <section class="stages-content">
            <!-- Etapas del proceso -->
            <aside class="stages">
                <div class="stage-card">
                    <img src="{{ asset('images/robot.webp') }}" alt="Imagen de informacion del proceso" class="stage-image">
                    <a href="{{ route('processInfo', ['researchTopicId' => $researchTopic->researchTopicId]) }}" 
                        class="stage-link"><i class="fa-solid fa-circle-info stage-icon"></i> 
                        Información del Proceso
                    </a>
                </div>
                <div class="stage-card">
                    <img src="{{ asset('images/search.webp') }}" alt="Imagen relacionada con la busqueda de informacion" class="stage-image">
                    <a href="{{ route('searchInformation', ['idcId' => $researchTopic->idcId, 
                        'idTopicSearchReport' => $researchTopic->topicSearchReportId]) }}" 
                        class="stage-link"><i class="fa-solid fa-magnifying-glass stage-icon"></i> 
                        Búsqueda de Información
                    </a>
                </div>
                <div class="stage-card">
                    <img src="{{ asset('images/article.webp') }}" alt="Imagen relacionada con el articulo cientifico" class="stage-image">
                    <a href="{{ route('scientificArticle', ['idcId' => $researchTopic->idcId, 
                        'idScientificArticleReport' => $researchTopic->scientificArticleReportId]) }}" 
                        class="stage-link"><i class="fa-solid fa-atom stage-icon"></i> 
                        Artículo Científico
                    </a>
                </div>
                <div class="stage-card">
                    <img src="{{ asset('images/end.webp') }}" alt="Imagen relacionada con la finalizacion del proceso" class="stage-image">
                    <a href="{{ route('endProcess', ['idcId' => $researchTopic->idcId, 
                        'idNextIdcTopicReport' => $researchTopic->nextIdcTopicReportId]) }}" 
                        class="stage-link"><i class="fa-solid fa-hourglass-end stage-icon"></i> 
                        Finalización del Proceso
                    </a>
                </div>
            </aside>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/stagesProcess.js') }}"></script>
@endsection