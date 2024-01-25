@extends('layout')

@section('title')
    Administración de Usuarios
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/administration.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Administración de Usuarios</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" >Usuarios</a>
            </div>
        </div>
        <div class="info-user">
            <div class="head">
                <h2>Usuarios del sistema</h2>
            </div>
            <div class="options-users">
                <div class="opt">
                    <!-- Listbox -->
                    <div class="custom-listbox">
                        <div class="listbox-header">
                            <button class="listbox"><span class="selected-option">Todos</span></button>
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
                    <input class="custom-input" type="text" placeholder="Buscar...">
                </div>
                <!-- Add user button -->
                <button type="button" id="btnAddUser" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
            </div>

            <!-- Users Table -->
            <div class="users-content">
                <table id="data-table" class="table content-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><img class="avatar" src="{{ $user->avatar }}" alt="Avatar">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->state }}</td>
                                <td>
                                    <button class="btn-edit btn" 
                                        data-modal="editarModal"
                                        data-userId="{{ $user->userId }}"
                                        data-userName="{{ $user->name }}"
                                        data-userEmail="{{ $user->email }}"
                                        data-userRole="{{ $user->role }}"
                                        data-userCareer="{{ $user->career }}"
                                        @if($user->role == 'Docente')
                                            data-teacherId="{{ $user->teacherId }}"
                                            data-contractType="{{ $user->contractType }}"
                                            data-specialty="{{ $user->specialty }}"
                                        @endif
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-delete btn" 
                                        data-modal="eliminarModal"
                                        data-userId="{{ $user->userId }}"
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
                            <h2>Datos del Usuario</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form action="{{ route('editUser') }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <input class="error-input" type="text" name="name" id="nameInput" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <div class="input-box">
                                <input class="error-input" type="text" name="email" id="emailInput" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <div class="options-courses">
                                <div class="custom-listbox role-edit">
                                    <div class="listbox-header listbox-header-edit">
                                        <button class="listbox" type="button"><span class="selected-option" id="roleSpanEdit"></span></button>
                                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                                    </div>
                                    <ul class="options optionsEdit">
                                        <li data-value="Estudiante">Estudiante</li>
                                        <li data-value="Docente">Docente</li>
                                        <li data-value="Coordinador">Coordinador</li>
                                    </ul>
                                </div>
                            </div>
                            <input hidden type="text" name="role" id="roleInputEdit">

                            <div class="options-courses lst-contract-edit" hidden>
                                <div class="custom-listbox contract-edit">
                                    <div class="listbox-header listbox-header-edit">
                                        <button class="listbox" type="button"><span class="selected-option" id="contractTypeSpanEdit"></span></button>
                                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                                    </div>
                                    <ul class="options optionsEdit">
                                        <li data-value="Tiempo completo">Tiempo completo</li>
                                            <li data-value="Hora clase">Hora clase</li>
                                    </ul>
                                </div>
                            </div>
                            <input hidden type="text" name="contractType" id="contractTypeInputEdit">

                            <div class="options-courses lst-specialty-edit" hidden>
                                <div class="custom-listbox specialty-edit">
                                    <div class="listbox-header listbox-header-edit">
                                        <button class="listbox" type="button"><span class="selected-option" id="specialtySpanEdit"></span></button>
                                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                                    </div>
                                    <ul class="options optionsEdit">
                                        @foreach($careers as $career)
                                            <li data-value="{{$career->nameCareer}}">{{$career->nameCareer}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <input hidden type="text" name="specialty" id="specialtyInputEdit">
                            <input hidden type="text" name="userId" id="userIdEdit">
                            <input hidden type="text" name="teacherId" id="teacherIdEdit">

                            <button id="btnEditUser" class="btn">Guardar</button>
                        </form>
                    </div>
                </div>

                <!-- Delete user modal -->
                <div class="modal" id="eliminarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar al usuario?</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDeleteUser">
                            <form action="{{ route('deleteUser') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="userId" id="idInputs" class="error-input" autocomplete="off">
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
                        <h2>Nuevo Usuario</h2>
                        <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                    </header>
                    <form action="{{ url('/addUser') }}" method="POST" id="formUser" class="addUser">
                        @csrf
                        <div class="input-box">
                            <input type="text" name="name" id="nameInput" placeholder="Nombre completo" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" name="email" id="emailInput" placeholder="Correo" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="options-courses">
                            <div class="custom-listbox role">
                                <div class="listbox-header listbox-header-edit">
                                    <button class="listbox" type="button"><span class="selected-option">Rol</span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    <li data-value="Estudiante">Estudiante</li>
                                    <li data-value="Docente">Docente</li>
                                    <li data-value="Coordinador">Coordinador</li>
                                    <li data-value="Administrador del Proceso">Administrador del Proceso</li>
                                    <li data-value="Administrador del Sistema">Administrador del Sistema</li>
                                </ul>
                            </div>
                        </div>
                        <input hidden type="text" name="role" id="roleInput">

                        <div class="options-courses lst-contract" hidden>
                            <div class="custom-listbox contract">
                                <div class="listbox-header listbox-header-edit">
                                    <button class="listbox" type="button"><span class="selected-option">Tipo de contrato</span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    <li data-value="Tiempo completo">Tiempo completo</li>
                                    <li data-value="Hora clase">Hora clase</li>
                                </ul>
                            </div>
                        </div>
                        <input hidden type="text" name="contractType" id="contractTypeInput">

                        <div class="options-courses lst-specialty" hidden>
                            <div class="custom-listbox specialty">
                                <div class="listbox-header listbox-header-edit">
                                    <button class="listbox" type="button"><span class="selected-option">Especialidad</span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    @foreach($careers as $career)
                                        <li data-value="{{$career->nameCareer}}">{{$career->nameCareer}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <input hidden type="text" name="specialty" id="specialtyInput">

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
