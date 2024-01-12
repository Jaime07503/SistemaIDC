@extends('layout')

@section('title')
    Administración del Sitio
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/administration.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Administración de Materias</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Materias</a>
            </div>
        </div>
        <div class="info-user">
            <div class="head">
                <h2>Materias del sistema</h2>
            </div>
            <div class="options-users">
                <div class="opt">
                    <!-- Listbox -->
                    <div class="custom-listbox">
                        <div class="listbox-header">
                            <button id="listbox"><span class="selected-option">Todos</span></button>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            <li data-value="Todos" class="selected"><i class="fa-solid fa-check"></i> Todos</li>
                            <li data-value="Estudiantes"> Estudiantes</li>
                            <li data-value="Docentes"> Docentes</li>
                            <li data-value="Coordinadores"> Coordinadores</li>
                            <li data-value="Administradores"> Administradores</li>
                        </ul>
                    </div>
                    <!-- Input Search RT -->
                    <div class="custom-input">
                        <input type="text" placeholder="Buscar">
                    </div>
                </div>
                <!-- Add user button -->
                <button type="button" id="btnAddUser" class="btn">Nueva Materia</button>
            </div>

            <!-- Users Table -->
            <div class="users-content">
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Seccion</th>
                            <th>Aprobacion</th>
                            <th>Ciclo</th>
                            <th>Año</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                            <tr>
                                <td><img class="avatar" src="{{ $subject->avatar }}" alt="Avatar">{{ $subject->name }}</td>
                                <td>{{ $subject->code }}</td>
                                <td>{{ $subject->nameSubject }}</td>
                                <td>{{ $subject->section }}</td>
                                <td>{{ $subject->approvedIdc }}</td>
                                <td>{{ $subject->subjectCycle }}</td>
                                <td>{{ $subject->subjectYear }}</td>
                                <td>
                                    <button class="button-edit btn" data-modal="editarModal"
                                        data-subjectId="{{ $subject->subjectId }}"
                                        data-code="{{ $subject->code }}"
                                        data-nameSubject="{{ $subject->nameSubject }}"
                                        data-section="{{ $subject->section }}"
                                        data-approvedIdc="{{ $subject->approvedIdc }}"
                                        data-subjectCycle="{{ $subject->subjectCycle }}"
                                        data-subjectYear="{{ $subject->subjectYear }}"
                                    >
                                        Editar
                                    </button>
                                    <button class="button-delete btn" data-modal="eliminarModal"
                                        data-subjectId="{{ $subject->subjectId }}"
                                    >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Edit user modal -->
                <div class="modal" id="editarModal">
                    <div class="modal-content">
                        <header>
                            <h2>Datos de la materia</h2>
                            <span class="close">&times;</span>
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
                        <header>
                            <h2>¿Realmente deseas eliminar la materia?</h2>
                            <span class="close">&times;</span>
                        </header>
                        <div class="optionDeleteUser">
                            <form action="{{ route('deleteSubject', ['subjectId' => $subject->subjectId]) }}" method="POST">
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

            <!-- Add user modal -->
            <div id="myModalUser" class="modal">
                <div class="modal-content">
                    <header class="head">
                        <h2>Nueva Materia</h2>
                        <button type="button" id="cerrarModalUser"><i class="fa-solid fa-xmark"></i></button>
                    </header>
                    <form action="{{ url('/addSubject') }}" method="POST" id="formUser" class="addUser">
                        @csrf

                        <div class="input-box">
                            <input type="text" name="code" id="codeInput" placeholder="Codigo" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" name="name" id="nameInput" placeholder="Nombre completo" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" name="section" id="sectionInput" placeholder="Seccion" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" name="approvedIdc" id="approvedIdcInput" placeholder="Aprobacion" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" name="cycle" id="subjectCycleInput" placeholder="Ciclo" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" name="year" id="yearInput" placeholder="Año" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>


                        <button type="submit" class="btn" id="submitButton">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/administration.js') }}"></script>
@endsection
