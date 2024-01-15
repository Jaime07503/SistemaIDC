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
                <h3>Estudiantes postulados</h3>
            </header>
            @if(isset($noTeams))
                <h3 class="empty">Por el momento no hay estudiantes postulados</h3>
            @else
                <form action="{{ route('team.create') }}" method="POST">
                    @csrf
                    <div class="team-content">
                        <table id="data-table" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Nombre del estudiante</th>
                                    <th>Correo</th>
                                    <th>CUM</th>
                                    <th>Materias inscritas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    <tr>
                                        <td data-values="Nombre del estudiante"><img class="avatar" src="{{ $student->avatar }}" alt="Avatar"> {{ $student->name }}</td>
                                        <td data-values="Correo">{{ $student->email }}</td>
                                        <td data-values="CUM">{{ $student->cum }}</td>  
                                        @php
                                            $enrolledSubjectsArray = explode(',', $student->enrolledSubject);
                                            $subjectQuantity = count($enrolledSubjectsArray);
                                        @endphp
                                        <td data-values="Materias inscritas">{{ $subjectQuantity }} materias</td>
                                        <td data-values="Seleccionar">
                                            <label class="checkbox" for="myCheckboxId{{ $index + 1 }}">
                                                <input class="checkbox-input" name="myCheckboxName{{ $index + 1 }}" id="myCheckboxId{{ $index + 1 }}" type="checkbox" value="{{ $student->studentId }}">
                                                <div class="checkbox-box"></div>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <input type="text" hidden name="idResearchTopic" value="{{ $researchTopics->researchTopicId }}">
                    <input type="text" hidden name="idTeacher" value="{{ $subject->idTeacher }}">
                    <input type="text" hidden name="subjectId" value="{{ $subject->subjectId }}">
                    <input type="hidden" name="selectedStudentIds" id="selectedStudentIds">
                    <button type="submit" class="btn" id="submitButton">Postular Equipo</button>
                </form>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/newTeam.js') }}"></script>
@endsection