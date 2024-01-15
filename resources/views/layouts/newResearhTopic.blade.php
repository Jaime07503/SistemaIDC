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
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
            </div>
        </header>
        <section class="newTopic">
            <form action="{{ route('researchTopic.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <header class="newData">
                    <i class="fa-regular fa-rectangle-list"></i>
                    <h3>Datos del Tema Nuevo</h3>
                </header>
                <div class="information">
                    <div class="top-content">
                        <div class="left-content">
                            <input type="text" name="themeName" placeholder="Nombre del Tema" autocomplete="off">
                            <textarea id="miTextarea" name="description" rows="4" cols="50" placeholder="Descripción" maxlength="500"></textarea>
                        </div>
                        <div class="right-content">
                            <div class="container file-container" id="container1">
                                <input type="file" name="avatar" class="file-input" accept="image/*" hidden>
                                <div class="img-area" data-img="">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h4>Avatar</h4>
                                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-content">
                        <div class="container file-container" id="container2">
                            <input type="file" name="importanceRegional" class="file-input" accept="image/*" hidden>
                            <div class="img-area" data-img="">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <h4>Importancia Regional</h4>
                                <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                            </div>
                        </div>
                        <div class="container file-container" id="container3">
                            <input type="file" name="importanceGlobal" class="file-input" accept="image/*" hidden>
                            <div class="img-area" data-img="">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <h4>Importancia Global</h4>
                                <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="idSubject" hidden value="{{ $subject->subjectId }}">
                </div>
                <button type="submit" class="btn"> <i class="fa-solid fa-plus"></i> Crear Tema </button>
            </form>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/newResearchTopic.js') }}"></script>
@endsection