@extends('layout')

@section('title')
    Equipo nuevo - {{ $subject->nameSubject }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/newTeam.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1> {{ $subject->nameSubject }} - {{ $subject->section }} - {{ $researchTopics->themeName }} - Postular Equipo</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" >Mis cursos</a>
                <a class="history-view" href="{{ route('researchTopics', ['subjectId' => $subject->subjectId]) }}">{{ $subject->code }}</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $researchTopics->researchTopicId, 'subjectId' => $subject->subjectId]) }}">{{ $researchTopics->code }}</a>
                <a class="history-view" href="">Postular Equipo</a>
            </div>
        </header>
        <section class="newTeam">
            <header class="newData">
                <h3> Estudiantes postulados </h3>
            </header>
            <form action="{{ route('team.create') }}" method="POST">
                @csrf
                <aside class="students">
                    @foreach($students as $index => $student)
                        <div class="card">
                            <img class="card-image" src="{{ $student->avatar }}" alt="Avatar">
                            <h3>{{ $student->name }}</h3>
                            <h3>{{ $student->cum }}</h3>
                            <h3>{{ $student->email }}</h3>
                            @php
                                $enrolledSubjectsArray = explode(',', $student->enrolledSubject);
                                $subjectQuantity = count($enrolledSubjectsArray);
                            @endphp
                            <h3>{{ $subjectQuantity }} Materias inscritas</h3>
                            <label class="checkbox" for="myCheckboxId{{ $index + 1 }}">
                                <input class="checkbox-input" name="myCheckboxName{{ $index + 1 }}" id="myCheckboxId{{ $index + 1 }}" type="checkbox" value="{{ $student->studentId }}">
                                <div class="checkbox-box"></div>
                            </label>
                        </div>
                    @endforeach
                </aside>
                <input type="text" hidden name="idResearchTopic" value="{{ $researchTopics->researchTopicId }}">
                <input type="text" hidden name="idTeacher" value="{{ $subject->idTeacher }}">
                <input type="text" hidden name="subjectId" value="{{ $subject->subjectId }}">
                <input type="hidden" name="selectedStudentIds" id="selectedStudentIds">
                <button type="submit" class="btn" id="submitButton">Postular Equipo</button>
            </form>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/newTeam.js') }}"></script>
@endsection