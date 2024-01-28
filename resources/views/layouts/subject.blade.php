@extends('layout')

@section('title')
    Administración de materias
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/administration.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Administración de materias</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" >Materias</a>
            </div>
        </div>
        <div class="info-user">
            <div class="head">
                <h2>Materias sin asignar Docente</h2>
            </div>
            <div class="options-users">
                <div class="opt">
                    <!-- Listbox -->
                    <div class="custom-listbox">
                        <div class="listbox-header">
                            <button class="listbox"><span class="selected-option">Todas</span></button>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            @foreach($careers as $career)
                                <li data-value="{{ $career->nameCareer }}" class="selected">{{ $career->nameCareer }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Input Search RT -->
                    <input class="custom-input" type="text" placeholder="Buscar">
                </div>
                <!-- Add user button -->
                <button type="button" id="btnAddCareer" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
            </div>

            <!-- Subjects Table -->
            <div class="users-content">
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Sección</th>
                            <th>Ciclo</th>
                            <th>Carrera</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unassignedSubjects as $unassignedSubject)
                            <tr>
                                <td>{{ $unassignedSubject->nameSubject }}</td>
                                <td>{{ $unassignedSubject->section }}</td>
                                <td>{{ $unassignedSubject->cycle }}</td>
                                <td>{{ $unassignedSubject->nameCareer }}</td>
                                <td>{{ $unassignedSubject->state }}</td>
                                <td>
                                    <button class="btn-edit btn" data-modal="editarModal"
                                        data-subjectId="{{ $unassignedSubject->subjectId }}"
                                        data-nameSubject="{{ $unassignedSubject->nameSubject }}"
                                        data-code="{{ $unassignedSubject->code }}"
                                        data-section="{{ $unassignedSubject->section }}"
                                        data-avatar="{{ $unassignedSubject->avatar }}"
                                        data-cycleId="{{ $unassignedSubject->cycleId }}"
                                        data-cycle="{{ $unassignedSubject->cycle }}"
                                        data-careerId="{{ $unassignedSubject->careerId }}"
                                        data-nameCareer="{{ $unassignedSubject->nameCareer }}"
                                        data-state="{{ $unassignedSubject->state }}"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-delete btn" data-modal="eliminarModal"
                                        data-subjectId="{{ $unassignedSubject->subjectId }}"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Edit user modal -->
                <div class="modal" id="editarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos de la materia</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form action="{{ url('/editSubject') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-box">
                                <input type="text" name="code" id="codigoInput" placeholder="Código" autocomplete="off">
                            </div>

                            <div class="input-box">
                                <input type="text" name="nameSubject" id="materiaInput" placeholder="Nombre de la materia" autocomplete="off">
                            </div>

                            <div class="input-box">
                                <input type="text" name="section" id="seccionInput" placeholder="Sección" autocomplete="off">
                            </div>

                            <img id="previousImage" src="" alt="Imagen previa">

                            <div class="container file-container" id="container">
                                <input type="file" name="Avatar" class="file-input file-edit" accept="image/*" hidden>
                                <div class="img-area" data-img="">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h4>Cambiar Avatar</h4>
                                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                    <img id="uploadedImage1" src="" alt="Imagen previa" style="display: none;">
                                </div>
                            </div>

                            <!-- Listbox State -->
                            <div class="custom-listbox stateEdit">
                                <div class="listbox-header listbox-header-edit">
                                    <button class="listbox" type="button"><span class="selected-option" id="stateSpanEdit"></span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    <li data-value="Activo" class="selected">Activo</li>
                                    <li data-value="Inactivo" class="selected">Inactivo</li>
                                </ul>
                            </div>
                            <input hidden type="text" name="state" id="estadoInput">

                            <!-- Listbox Cycle -->
                            <div class="custom-listbox cycleEdit">
                                <div class="listbox-header listbox-header-edit">
                                    <button class="listbox" type="button"><span class="selected-option" id="cycleSpanEdit"></span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    @foreach($cycles as $cycle)
                                        <li data-value="{{ $cycle->cycleId }}" class="selected">{{ $cycle->cycle }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <input hidden type="text" name="idCycle" id="cicloIdInput">

                            <!-- Listbox Career -->
                            <div class="custom-listbox careerEdit">
                                <div class="listbox-header listbox-header-edit">
                                    <button class="listbox" type="button"><span class="selected-option" id="careerSpanEdit"></span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    @foreach($careers as $career)
                                        <li data-value="{{ $career->careerId }}" class="selected">{{ $career->nameCareer }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <input hidden type="text" name="idCareer" id="carreraIdInput">

                            <input hidden type="text" name="subjectId" id="materiaId">

                            <button id="btnEditSubject" class="btn">Guardar</button>
                        </form>
                    </div>
                </div>

                <!-- Delete user modal -->
                <div class="modal" id="eliminarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar la materia?</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDeleteUser">
                            <form action="{{ route('deleteSubject') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="subjectId" id="subjectId" class="error-input" autocomplete="off">
                                <button class="btn">Eliminar</button>
                            </form>
                            <button class="btn cancel">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add career modal -->
            <div id="myModalCareer" class="modal">
                <div class="modal-content">
                    <header class="head">
                        <h2>Nueva Materia</h2>
                        <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                    </header>
                    <form action="{{ url('/addSubject') }}" method="POST" id="formUser" class="addUser" enctype="multipart/form-data">
                        @csrf

                        <div class="input-box">
                            <input type="text" name="code" id="codeInput" placeholder="Código" class="error-input" autocomplete="off">
                        </div>

                        <div class="input-box">
                            <input type="text" name="nameSubject" id="nameInput" placeholder="Nombre de la materia" class="error-input" autocomplete="off">
                        </div>

                        <div class="input-box">
                            <input type="text" name="section" id="sectionInput" placeholder="Sección" class="error-input" autocomplete="off">
                        </div>

                        <div class="container file-container" id="container2">
                            <input type="file" name="Avatar" class="file-input" accept="image/*" hidden>
                            <div class="img-area" data-img="">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <h4>Avatar Materia</h4>
                                <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                <img id="uploadedImage2" src="" alt="Imagen previa" style="display: none;">
                            </div>
                        </div>

                        <!-- Listbox State -->
                        <div class="custom-listbox state">
                            <div class="listbox-header listbox-header-edit">
                                <button class="listbox" type="button"><span class="selected-option">Estado</span></button>
                                <i class="fa-solid fa-chevron-down arrow-down"></i>
                            </div>
                            <ul class="options optionsEdit">
                                <li data-value="Activo" class="selected">Activo</li>
                                <li data-value="Inactivo" class="selected">Inactivo</li>
                            </ul>
                        </div>
                        <input hidden type="text" name="state" id="stateInput">

                        <!-- Listbox -->
                        <div class="custom-listbox cycle">
                            <div class="listbox-header listbox-header-edit">
                                <button class="listbox" type="button"><span class="selected-option">Ciclo</span></button>
                                <i class="fa-solid fa-chevron-down arrow-down"></i>
                            </div>
                            <ul class="options optionsEdit">
                                @foreach($cycles as $cycle)
                                    <li data-value="{{ $cycle->cycleId }}" class="selected">{{ $cycle->cycle }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <input hidden type="text" name="idCycle" id="cycleIdInput">

                        <!-- Listbox -->
                        <div class="custom-listbox career">
                            <div class="listbox-header listbox-header-edit">
                                <button class="listbox" type="button"><span class="selected-option">Carrera</span></button>
                                <i class="fa-solid fa-chevron-down arrow-down"></i>
                            </div>
                            <ul class="options optionsEdit">
                                @foreach($careers as $career)
                                    <li data-value="{{ $career->careerId }}" class="selected">{{ $career->nameCareer }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <input hidden type="text" name="idCareer" id="careerIdInput">

                        <button type="submit" class="btn" id="submitButton">Crear</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="info-user">
            <div class="head">
                <h2>Materias asignadas a Docentes</h2>
            </div>
            <div class="options-users">
                <div class="opt">
                    <!-- Listbox -->
                    <div class="custom-listbox">
                        <div class="listbox-header">
                            <button class="listbox"><span class="selected-option">Todas</span></button>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            @foreach($careers as $career)
                                <li data-value="{{ $career->nameCareer }}" class="selected">{{ $career->nameCareer }}</li>

                            @endforeach
                        </ul>
                    </div>
                    <!-- Input Search RT -->
                    <input class="custom-input" type="text" placeholder="Buscar">
                </div>
            </div>

            <!-- Subjects Table -->
            <div class="users-content">
                <table id="data-table-subjects" class="table content-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Sección</th>
                            <th>Aprobado IDC</th>
                            <th>Ciclo</th>
                            <th>Carrera</th>
                            <th>Docente</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedSubjects as $assignedSubject)
                            <tr>
                                <td>{{ $assignedSubject->nameSubject }}</td>
                                <td>{{ $assignedSubject->section }}</td>
                                <td>{{ $assignedSubject->approvedIdc }}</td>
                                <td>{{ $assignedSubject->cycle }}</td>
                                <td>{{ $assignedSubject->nameCareer }}</td>
                                <td>{{ $assignedSubject->name }}</td>
                                <td>{{ $assignedSubject->state }}</td>
                                <!-- <td>
                                    <button class="btn-edit btn" data-modal="editarModal"
                                        data-subjectId="{{ $assignedSubject->subjectId }}"
                                        data-code="{{ $assignedSubject->code }}"
                                        data-nameSubject="{{ $assignedSubject->nameSubject }}"
                                        data-section="{{ $assignedSubject->section }}"
                                        data-approvedIdc="{{ $assignedSubject->approvedIdc }}"
                                        data-cycle="{{ $assignedSubject->cycle }}"
                                        data-teacher="{{ $assignedSubject->name }}"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button> -->
                                <td>
                                    <button class="btn-delete btn" data-modal="eliminarModal"
                                        data-subjectId="{{ $assignedSubject->subjectId }}"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/subject.js') }}"></script>
@endsection
