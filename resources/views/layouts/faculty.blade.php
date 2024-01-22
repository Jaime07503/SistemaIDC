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
            <h1>Administración de facultad</h1>
            <div class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Facultad</a>
            </div>
        </div>
        <div class="info-user">
            <div class="head">
                <h2>Facultades del sistema</h2>
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
                <button type="button" id="btnAddUser" class="btn">Nueva Facultad</button>
            </div>

            <!-- Users Table -->
            <div class="users-content">
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facultys as $faculty)
                            <tr>
                                <td><img class="avatar" src="{{ $facultyr->avatar }}" alt="Avatar">{{ $faculty->name }}</td>
                                <td>{{ $faculty->nameFaculty }}</td>
                                <td>
                                    <button class="button-edit btn" data-modal="editarModal"
                                        data-userId="{{ $faculty->facultyId }}"
                                        data-userName="{{ $faculty->nameFaculty }}"
                                    >
                                        Editar
                                    </button>
                                    <button class="button-delete btn" data-modal="eliminarModal"
                                        data-userId="{{ $faculty->facultyId }}"
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
                            <h2>Datos de la facultad</h2>
                            <span class="close">&times;</span>
                        </header>
                        <form action="{{ url('/editFaculty') }}" method="POST">
                            @csrf
                            <!-- Listbox -->
                            <div class="custom-listbox">
                                <div class="listbox-header">
                                    <button id="listbox"><span class="selected-option faculty"></span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options">
                                    @foreach ($facultys as $faculty)
                                    <li data-value="{{$faculty->facultyId}}">{{$faculty->nameFaculty}} </li>
                                    @endforeach
                                </ul>
                            <button type="button" id="btnEditUser" class="btn">Guardar</button>
                        </form>
                    </div>
                </div>

                <!-- Delete user modal -->
                <div class="modal" id="eliminarModal">
                    <div class="modal-content">
                        <header>
                            <h2>¿Realmente deseas eliminar la facultad?</h2>
                            <span class="close">&times;</span>
                        </header>
                        <div class="optionDeleteUser">
                            <form action="{{ route('deleteFaculty', ['facultyId' => $faculty->facultyId]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="facultyId" id="idInputs" class="error-input" autocomplete="off">
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
                        <h2>Nueva Facultad</h2>
                        <button type="button" id="cerrarModalUser"><i class="fa-solid fa-xmark"></i></button>
                    </header>
                    <form action="{{ url('/addFaculty') }}" method="POST" id="formUser" class="addUser">
                        @csrf
                        <div class="input-box">
                            <input type="text" name="name" id="nameInput" placeholder="Nombre completo" class="error-input" autocomplete="off">
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
    <script src=" {{ asset('js/faculty.js') }}"></script>
@endsection
