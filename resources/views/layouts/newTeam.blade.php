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
            <h1>{{ $researchTopics->themeName }}</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="{{ route('researchTopics', ['subjectId' => $subject->subjectId]) }}">IYA-ADS104-A-I24</a>
                <a class="view" href="">{{ $researchTopics->themeName }}</a>
            </div>
        </header>
        <section class="newTeam">
            <header class="newData">
                <i class="fa-solid fa-users"></i>
                <h3> Estudiantes Postulados </h3>
            </header>
            <form action="{{ route('team.create') }}" method="POST">
                @csrf
                <div class="team-content">
                    @foreach($students as $index => $student)
                        <label class="checkbox" for="myCheckboxId{{ $index + 1 }}">
                            <input class="checkbox-input" name="myCheckboxName{{ $index + 1 }}" id="myCheckboxId{{ $index + 1 }}" type="checkbox" value="{{ $student->studentId }}">
                            <div class="checkbox-box"></div>
                            <img class="avatar" src="{{ $student->avatar }}" alt="Avatar">
                            <h2>{{ $student->name }}</h2>
                        </label>
                    @endforeach
                </div>
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