@extends('layout')

@section('title')
    Administración de Facultades
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/administration.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Administración de Facultades</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Facultades</a>
            </div>
        </div>
        <div class="info-user">
            <div class="head">
                <h2>Facultades</h2>
            </div>
            <div class="options-users">
                <input id="searchInput" class="custom-input" type="text" placeholder="Buscar...">
                <!-- Add Faculty Button -->
                <button type="button" id="btnAddFaculty" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
            </div>

            <!-- Facultys Table -->
            <div class="users-content">
                <table id="data-table-faculty" class="table content-table">
                    <thead>
                        <tr>
                            <th>Facultad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facultys as $faculty)
                            <tr>
                                <td data-values="Facultad">{{ $faculty->nameFaculty }}</td>
                                <td data-values="Acciones">
                                    <button class="btn-edit btn" data-modal="editarModal"
                                        data-facultyId="{{ $faculty->facultyId }}"
                                        data-nameFaculty="{{ $faculty->nameFaculty }}"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-delete btn" data-modal="eliminarModal"
                                        data-facultyId="{{ $faculty->facultyId }}"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Add Faculty Modal -->
                <div id="myModalFaculty" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nueva Facultad</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formAddFaculty" action="{{ url('/addFaculty') }}" method="POST" id="formFaculty" class="addFaculty">
                            @csrf
                            <div class="input-box">
                                <input class="input-faculty" type="text" name="nameFaculty" id="nameFacultyInput" placeholder="Nombre de la facultad" autocomplete="off" maxlength="200">
                            </div>
                            <div id="notificationF" class="notificationM"></div>

                            <button type="submit" class="btn" id="submitButton">Crear</button>
                        </form>
                    </div>
                </div>

                <!-- Edit Faculty Modal -->
                <div class="modal" id="editarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos de la facultad</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formEditFaculty" action="{{ route('editFaculty') }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <input class="input-faculty" type="text" name="nameFaculty" id="nameFaculty" placeholder="Nombre de la facultad" autocomplete="off" maxlength="200">
                            </div>
                            <input hidden type="text" name="facultyId" id="facultyEditId">
                            <div id="notificationFE" class="notificationM"></div>
                
                            <button id="btnEditUser" class="btn">Guardar</button>
                        </form>
                    </div>
                </div>

                <!-- Delete Faculty Modal -->
                <div class="modal" id="eliminarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar la facultad?</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDeleteUser">
                            <form action="{{ route('deleteFaculty') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="facultyId" id="facultyId" class="error-input" autocomplete="off">
                                <button class="btn">Eliminar</button>
                            </form>
                            <button class="btn cancel">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/faculty.js') }}"></script>
@endsection