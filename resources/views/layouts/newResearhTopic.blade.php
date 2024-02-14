@extends('layout')

@section('title')
    Temas nuevo - {{ $subject->nameSubject }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/newResearchTopic.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>{{ $subject->nameSubject.' - '.$subject->section.' - '.$subject->teacher->user->name}}</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis cursos</a>
                <a class="history-view" href="{{ route('researchTopics', ['subjectId' => $subjectId]) }}">{{ $subject->code }}</a>
                <a class="history-view" href="">Postular Tema</a>
            </div>
        </header>
        <section class="newTopic">
            <form id="formAddResearchTopic" action="{{ route('researchTopic.create', ['subjectId' => $subjectId]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <header class="newData">
                    <h3>Información del Tema de Investigación</h3>
                </header>
                <div class="information">
                    <textarea class="textarea textareaTopicA" name="themeName" placeholder="Tema" maxlength="300"></textarea>
                    <textarea class="textarea textareaTopicA" name="description" placeholder="Descripción" maxlength="500"></textarea>

                    <div class="container file-container" id="container2">
                        <input type="file" name="Imagen-Importancia-Local" class="file-input" accept="image/png, image/jpeg" hidden>
                        <div class="img-area" data-img="">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <h4>Importancia Local (Opcional)</h4>
                            <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                            <img id="uploadedImage" src="" alt="Imagen previa" style="display: none;">
                        </div>
                    </div>

                    <div class="container file-container" id="container3">
                        <input type="file" name="Imagen-Importancia-Global" class="file-input" accept="image/png, image/jpeg" hidden>
                        <div class="img-area" data-img="">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <h4>Importancia Global (Opcional)</h4>
                            <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                            <img id="uploadedImage" src="" alt="Imagen previa" style="display: none;">
                        </div>
                    </div>
                </div>
                <div id="notificationT" class="notificationM"></div>
                <button type="submit" class="btn">Postular Tema</button>
            </form>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/newResearchTopic.js') }}"></script>
@endsection