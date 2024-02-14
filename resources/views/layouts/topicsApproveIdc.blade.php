@extends('layout')

@section('title')
    Temas de Investigación Anteriorees IDC - {{ $subject->nameSubject }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/topicsApproveIdc.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Encabezado e Historial de vistas -->
        <header class="head-content">
            <h1 class="head-lbl">{{ $subject->nameSubject.' - '.$subject->section.' - '.$subject->teacher->user->name}}</h1>
            <nav class="history">
                <a class="history-view" href="{{ route('tablero') }}">Tablero</a>
                <a class="history-view">Mis cursos</a>
                <a class="history-view" href="">{{ $subject->code }}</a>
            </nav>
        </header>
         <!-- Vista general de los temas de investigación -->
         <section class="topics-content">
            <header class="head">
                <h2>Temas de Investigación Anteriores IDC</h2>
            </header>
            <div class="topics">
                @foreach ($researchTopics as $topic)
                    <div class="card cards-researchTopics">
                        <h3 class="card-title">{{ $topic->nameTopic }}</h3>
                        <p class="card-paragraph">{{ $topic->description }}</p>
                        <form action="{{ route('topicIdc.create', ['subjectId' => $subject->subjectId, 'topicId' => $topic->topicId]) }}" method="POST">
                            @csrf
                            <button class="btn">Seleccionar <i class="fa-solid fa-hand-pointer"></i></button>
                        </form>
                    </div>
                @endforeach
            </div>
         </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/topicsApproveIdc.js') }}"></script>
@endsection