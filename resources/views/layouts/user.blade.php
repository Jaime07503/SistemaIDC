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
                <a class="history-view" href="{{ url('/home') }}">Inicio del Sitio</a>
                <a class="history-view">Usuarios</a>
            </div>
        </div>
        <div class="info-user">
            <div class="head">
                <h2><i class="fa-regular fa-user"></i> Usuarios del sistema</h2>
            </div>
            <div class="options-users">
                <div class="opt">
                    <!-- Listbox Roles -->
                    <div class="custom-listbox">
                        <div class="listbox-header" id="userListbox">
                            <button class="listbox" type="button"><span class="selected-option">Todos</span></button>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            <li data-value="Todos" class="selected"><i class="fa-solid fa-check"></i> Todos</li>
                            <li data-value="Estudiantes"> Estudiante</li>
                            <li data-value="Docentes"> Docente</li>
                            <li data-value="Administrador del proceso"> Administrador del proceso</li>
                            <li data-value="Administrador del sistema"> Administrador del sistema</li>
                        </ul>
                    </div>
                    <!-- Input Search RT -->
                    <input id="searchInput" class="custom-input" type="text" placeholder="Buscar...">
                </div>
                <!-- Add User Button -->
                <button type="button" id="btnAddUser" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
            </div>

            <!-- Users Table -->
            <div class="users-content">
                @if(isset($noUsers))
                    <h3 class="empty">No hay <strong>Usuarios Creados</strong> aún</h3>
                @else
                    <table id="data-table-users" class="table content-table">
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
                                    <td data-values="Nombre"><img class="avatar" src="{{ $user->avatar }}" alt="Avatar">{{ $user->name }}</td>
                                    <td data-values="Correo">{{ $user->email }}</td>
                                    <td data-values="Rol">{{ $user->role }}</td>
                                    <td data-values="Estado">{{ $user->state }}</td>
                                    <td data-values="Acciones">
                                        <button class="btn-edit btn" 
                                            data-modal="editarModal"
                                            data-userId="{{ $user->userId }}"
                                            data-userName="{{ $user->name }}"
                                            data-userEmail="{{ $user->email }}"
                                            data-userRole="{{ $user->role }}"
                                            @if($user->role == 'Docente')
                                                data-teacherId="{{ $user->teacherId }}"
                                                data-contractType="{{ $user->contractType }}"
                                                data-specialty="{{ $user->specialty }}"
                                                data-title=" {{ $user->title }}"
                                                data-idcQuantity=" {{ $user->idcQuantity }}"
                                            @endif
                                        >
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        @if($user->role !== 'Administrador del Sistema')
                                            <button class="btn-delete btn" 
                                                data-modal="eliminarModal"
                                                data-userId="{{ $user->userId }}"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <!-- Add User Modal -->
                <div id="myModalUser" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo Usuario</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formAddUser" action="{{ url('/addUser') }}" method="POST" id="formUser" class="addUser">
                            @csrf
                            <div class="input-box">
                                <input class="input-user" type="text" name="name" id="nameInput" placeholder="Nombre completo" autocomplete="off" maxlength="100">
                            </div>

                            <div class="input-box">
                                <input class="input-user" type="text" name="email" id="emailInput" placeholder="Correo" autocomplete="off" maxlength="320">
                            </div>

                            <div class="options-courses">
                                <div class="custom-listbox role">
                                    <div class="listbox-header listbox-header-edit">
                                        <button class="listbox" type="button"><span class="selected-option" data-value="Rol" id="role">Rol</span></button>
                                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                                    </div>
                                    <ul class="options optionsEdit">
                                        <li data-value="Estudiante">Estudiante</li>
                                        <li data-value="Docente">Docente</li>
                                        <li data-value="Administrador del Proceso">Administrador del Proceso</li>
                                        <li data-value="Administrador del Sistema">Administrador del Sistema</li>
                                    </ul>
                                </div>
                            </div>
                            <input hidden type="text" name="role" id="roleInput">

                            <div class="options-courses lst-contract" hidden>
                                <div class="custom-listbox contract">
                                    <div class="listbox-header listbox-header-edit">
                                        <button class="listbox" type="button"><span class="selected-option" data-value="Tipo de contrato" id="contractType">Tipo de contrato</span></button>
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
                                        <button class="listbox" type="button"><span class="selected-option" data-value="Especialidad" id="specialty">Especialidad</span></button>
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

                            <div class="options-courses lst-title" hidden>
                                <div class="custom-listbox title">
                                    <div class="listbox-header listbox-header-edit">
                                        <button class="listbox" type="button"><span class="selected-option" data-value="Título" id="title">Título</span></button>
                                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                                    </div>
                                    <ul class="options optionsEdit">
                                        <li data-value="Licenciado">Lic.</li>
                                        <li data-value="Ingeniero">Ing.</li>
                                        <li data-value="Master">Ma.</li>
                                    </ul>
                                </div>
                            </div>
                            <input hidden type="text" name="title" id="titleInput">
                            
                            <input hidden id="idcQuantity" type="text" name="idcQuantity" placeholder="Participaciones en IDC" maxlength="2" autocomplete="off">

                            <div id="notificationU" class="notificationM"></div>

                            <button type="submit" class="btn" id="submitButton">Crear <i class="fa-brands fa-pushed"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Edit User Modal -->
                <div class="modal" id="editarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos del Usuario</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formEditUser" action="{{ route('user.edit') }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <input class="input-user" type="text" name="name" id="nameEditInput" autocomplete="off" placeholder="Nombre completo" maxlength="100">
                            </div>
                            <div class="input-box">
                                <input class="input-user" type="text" name="email" id="emailEditInput" autocomplete="off" placeholder="Correo" maxlength="320">
                            </div>

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

                            <div class="options-courses lst-title-edit" hidden>
                                <div class="custom-listbox title-edit">
                                    <div class="listbox-header listbox-header-edit">
                                        <button class="listbox" type="button"><span class="selected-option" data-value="Título" id="titleSpanEdit">Título</span></button>
                                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                                    </div>
                                    <ul class="options optionsEdit">
                                        <li data-value="Licenciado">Lic.</li>
                                        <li data-value="Ingeniero">Ing.</li>
                                        <li data-value="Master">Ma.</li>
                                        <li data-value="Arquitecto">Arq.</li>
                                    </ul>
                                </div>
                            </div>
                            <input hidden type="text" name="title" id="titleInputEdit">

                            <input hidden id="idcQuantityEdit" type="text" name="idcQuantity" placeholder="Participaciones en IDC" maxlength="2" autocomplete="off">

                            <input hidden type="text" name="role" id="roleInputEdit">
                            <input hidden type="text" name="userId" id="userIdEdit">
                            <input hidden type="text" name="teacherId" id="teacherIdEdit">
                            <div id="notificationUE" class="notificationM"></div>

                            <button id="btnEditUser" class="btn">Guardar <i class="fa-regular fa-floppy-disk"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Delete User Modal -->
                <div class="modal" id="eliminarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar al usuario?</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDeleteUser">
                            <form action="{{ route('user.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="userId" id="idInputs" class="error-input" autocomplete="off">
                                <button class="btn">Eliminar <i class="fa-solid fa-trash"></i></button>
                            </form>
                            <button class="btn cancel">Cancelar <i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/administration.js') }}"></script>
@endsection
