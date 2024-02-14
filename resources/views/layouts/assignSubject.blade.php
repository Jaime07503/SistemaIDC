@extends('layout')

@section('title')
    Asignación de Materias a Docentes
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/administration.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Asignación de Materias a Docentes</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/home') }}">Inicio del Sitio</a>
                <a class="history-view">Asignación de Materias</a>
            </div>
        </header>
        <section class="info-user">
            <div class="head">
                <h2>Materias sin Asignar</h2>
            </div>
            <div class="options-users">
                <div class="opt">
                    <!-- Listbox Career -->
                    <div class="custom-listbox lt-subject">
                        <div class="listbox-header" id="subjectListbox">
                            <button class="listbox"><span class="selected-option">Todos</span></button>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            <li data-value="Todos">Todos</li>
                            @foreach($careers as $career)
                                <li data-value="{{ $career->nameCareer }}" class="selected">{{ $career->nameCareer }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Input Search Subject -->
                    <input id="searchInput" class="custom-input" type="text" placeholder="Buscar...">
                </div>
            </div>
            <!-- UnassignedSubjects Table-->
            <div class="subject-content">
                @if(isset($noContent))
                    <h3 class="empty">No hay <strong>Materias sin asignar Docente</strong></h3>
                @else
                    @if(isset($noUnassignedSubjects))
                        <h3 class="empty">No hay <strong>Materias sin asignar Docente</strong></h3>
                    @else
                        <table id="data-table-subjects" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Sección</th>
                                    <th>Ciclo</th>
                                    <th>Carrera</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($unassignedSubjects as $unassignedSubject)
                                    <tr>
                                        <td data-values="Nombre">{{ $unassignedSubject->nameSubject }}</td>
                                        <td data-values="Sección">{{ $unassignedSubject->section }}</td>
                                        <td data-values="Ciclo">{{ $unassignedSubject->cycle }}</td>
                                        <td data-values="Carrera">{{ $unassignedSubject->nameCareer }}</td>
                                        <td data-values="Estado">{{ $unassignedSubject->state }}</td>
                                        <td data-values="Acciones">
                                            <button class="btn-edit btn" data-modal="asignarSubjectModal"
                                                data-subjectId="{{ $unassignedSubject->subjectId }}"
                                                data-nameCareer="{{ $unassignedSubject->nameCareer }}"
                                                data-approvedIdc="{{ $unassignedSubject->approvedIdc }}"
                                            >
                                                <i class="fa-solid fa-arrow-pointer"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endif

                <!-- AssignSubject Modal -->
                <div class="modal" id="asignarSubjectModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Selección de Docente</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="assignTeacher" action="{{ route('assignTeacher') }}" method="POST">
                            @csrf
                            <!-- Listbox Teacher -->
                            <div class="custom-listbox teacher">
                                <div class="listbox-header listbox-header-edit">
                                    <button class="listbox" type="button"><span class="selected-option" id="teacher" data-value="Docente">Docente</span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit" id="lt-teachers">
                                </ul>
                            </div>
                            <input hidden type="text" name="idTeacher" id="idTeacher">
                            <input hidden type="text" name="subjectId" id="subjectId"> 
                            <div id="notificationAS" class="notificationM"></div> 
                            
                            <button id="btnAssignSubject" class="btn">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="info-user">
            <div class="head">
                <h2>Materias Asignadas</h2>
            </div>
            <div class="options-users">
                <div class="opt">
                    <!-- Listbox -->
                    <div class="custom-listbox lt-subject2">
                        <div class="listbox-header" id="subjectListboxA">
                            <button class="listbox"><span class="selected-option">Todos</span></button>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            <li data-value="Todos">Todos</li>
                            @foreach($careers as $career)
                                <li data-value="{{ $career->nameCareer }}" class="selected">{{ $career->nameCareer }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Input Search Subject -->
                    <input id="searchInputA" class="custom-input" type="text" placeholder="Buscar...">
                </div>
            </div>

            <!-- AssignedSubjects Table -->
            <div class="users-content">
                @if(isset($noContent))
                    <h3 class="empty">No hay <strong>Materias asignadas a Docente</strong></h3>
                @else
                    @if(isset($noAssignedSubjects))
                        <h3 class="empty">No hay <strong>Materias asignadas a Docente</strong></h3>
                    @else
                        <table id="data-table-assignSubjects" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Sección</th>
                                    <th>Ciclo</th>
                                    <th>Carrera</th>
                                    <th>Docente</th>
                                    <th>Estado</th>
                                    <th>IDC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedSubjects as $assignedSubject)
                                    <tr>
                                        <td data-values="Nombre">{{ $assignedSubject->nameSubject }}</td>
                                        <td data-values="Sección">{{ $assignedSubject->section }}</td>
                                        <td data-values="Ciclo">{{ $assignedSubject->cycle }}</td>
                                        <td data-values="Carrera">{{ $assignedSubject->nameCareer }}</td>
                                        <td data-values="Docente">{{ $assignedSubject->name }}</td>
                                        <td data-values="Estado">{{ $assignedSubject->state }}</td>
                                        <td data-values="IDC">
                                            @if($assignedSubject->approvedIdc !== 'Aprobado')
                                                <button type="button" class="btn btn-aproved-subject" data-values="{{ $assignedSubject->subjectId }}">
                                                    Aprobar
                                                </button>
                                                <h4 style="font-weight: 100; display: none" 
                                                    id="state-subject-{{ $assignedSubject->subjectId }}">{{ $assignedSubject->approvedIdc }}
                                                </h4>   
                                            @else 
                                                <h4 style="font-weight: 100;">{{ $assignedSubject->approvedIdc}}</h4>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endif
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/assignSubject.js') }}"></script>
@endsection
