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
                <h2>Materias</h2>
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

            <!-- Users Table -->
            <div class="users-content">
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Sección</th>
                            <th>Aprobado IDC</th>
                            <th>Ciclo</th>
                            <th>Carrera</th>
                            <th>Docente</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $subject->nameSubject }}</td>
                                <td>{{ $subject->section }}</td>
                                <td>{{ $subject->approvedIdc }}</td>
                                <td>{{ $subject->cycle }}</td>
                                <td>{{ $subject->nameCareer }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->state }}</td>
                                <td>
                                    <button class="btn-edit btn" data-modal="editarModal"
                                        data-subjectId="{{ $subject->subjectId }}"
                                        data-code="{{ $subject->code }}"
                                        data-nameSubject="{{ $subject->nameSubject }}"
                                        data-section="{{ $subject->section }}"
                                        data-approvedIdc="{{ $subject->approvedIdc }}"
                                        data-subjectCycle="{{ $subject->subjectCycle }}"
                                        data-subjectYear="{{ $subject->subjectYear }}"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-delete btn" data-modal="eliminarModal"
                                        data-subjectId="{{ $subject->subjectId }}"
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
                        <form action="" method="POST">
                            @csrf
                            <div class="input-box">
                                <input class="error-input" type="number" name="code" id="nameInput" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <div class="input-box">
                                <input class="error-input" type="text" name="name" id="emailInput" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <div class="input-box">
                                <input class="error-input" type="text" name="section" id="emailInput" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <div class="input-box">
                                <input class="error-input" type="text" name="approveIdc" id="roleInputEdit" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <div class="input-box">
                                <input class="error-input" type="text" name="cycle" id="roleInputEdit" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <div class="input-box">
                                <input class="error-input" type="text" name="year" id="roleInputEdit" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <button type="button" id="btnEditUser" class="btn">Guardar</button>
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
                                <input hidden type="text" name="subjectId" id="idInputs" class="error-input" autocomplete="off">
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
                    <form action="{{ url('/addSubject') }}" method="POST" id="formUser" class="addUser">
                        @csrf

                        <div class="input-box">
                            <input type="text" name="code" id="codeInput" placeholder="Código" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" name="nameSubject" id="nameInput" placeholder="Nombre de la materia" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" name="section" id="sectionInput" placeholder="Sección" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="container file-container" id="container">
                            <input type="file" name="Avatar" class="file-input" accept="image/*" hidden>
                            <div class="img-area" data-img="">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <h4>Avatar Materia</h4>
                                <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                <img id="uploadedImage" src="" alt="Imagen previa" style="display: none;">
                            </div>
                        </div>

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
                        <input hidden type="text" name="idCycle" id="cycleInput">

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
                        <input hidden type="text" name="idCareer" id="careerInput">

                        <button type="submit" class="btn" id="submitButton">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/subject.js') }}"></script>
@endsection
