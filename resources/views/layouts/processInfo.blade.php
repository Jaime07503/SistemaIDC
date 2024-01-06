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
            <h1>{{ $researchTopic->themeName }} - Información del Proceso</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">{{ $researchTopic->code }}</a>
                <a class="view" href="">{{ $researchTopic->themeName }}</a>
                <a class="view" href="">Etapas del proceso</a>
                <a class="view" href="">Documentación</a>
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
                        <!-- <iframe width="250" height="250" src="https://www.youtube.com/embed/RwjgfNX41TE" title="Animaciones con CSS y Scroll Animations sin JavaScript"  frameborder="0" allowfullscreen></iframe> -->
                    </div>
                    <div class="document">
                        <i class="fa-solid fa-circle-play"></i>   
                        <a href="https://www.youtube.com/embed/RwjgfNX41TE" target="_blank" rel="noreferrer"> Búsqueda de información </a>    
                        <!-- <iframe width="250" height="250" src="https://www.youtube.com/embed/RwjgfNX41TE" title="Animaciones con CSS y Scroll Animations sin JavaScript"  frameborder="0" allowfullscreen></iframe> -->
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/processInfo.js') }}"></script>
@endsection