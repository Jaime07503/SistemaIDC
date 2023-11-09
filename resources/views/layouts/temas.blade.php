@extends('layout')

@section('title')
    Temas de Investigación
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/temas.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>{{ $subject->nameSubject }}</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" href="">Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
            </div>
        </div>
        <div class="topics-content">
            <div>
                <h3>Temas de investigación disponibles</h3>
            </div>
            <div class="topics">
                @foreach ($researchTopics as $topic)
                <div class="researchTopics">
                    <div>
                        <h5 class="card-title">{{ $topic->state }}</h5>
                        <img src="{{ asset('images/curso_logo.png') }}" class="avatarTopic" alt="Imagen">
                    </div>
                    <div class="topicContent">
                        <div class="title">
                            <div class="topic">
                                <a href="{{ route('temasInformation', ['researchTopicId' => $topic->researchTopicId]) }}" class="">{{ $topic->themeName }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/temas.js') }}"></script>
@endsection