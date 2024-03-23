@extends('layout')

@section('title')
    Administración de Facultades
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/administration.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Administración de Facultades</h1>
            <div class="history">
                <a class="history-view" href="{{ route('home') }}">Inicio del Sitio</a>
                <a class="history-view">Facultades</a>
            </div>
        </header>
        <section class="info-user">
            <div class="head">
                <h2><i class="fa-solid fa-building-columns"></i> Facultades</h2>
            </div>
            <div class="options-users">
                <input id="searchInput" class="custom-input" type="text" placeholder="Buscar...">
                <!-- Add Faculty Button -->
                <button type="button" id="btnAddFaculty" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
            </div>

            <!-- Facultys Table -->
            <div class="users-content">
                @if(isset($noFacultys))
                    <h3 class="empty">No hay <strong>Facultades creadas</strong> aún</h3>
                @else
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
                @endif

                <!-- Add Faculty Modal -->
                <div id="myModalFaculty" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nueva Facultad</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formAddFaculty" action="{{ route('faculty.create') }}" method="POST" id="formFaculty" class="addFaculty">
                            @csrf
                            <div class="input-box">
                                <input class="input-faculty" type="text" name="nameFaculty" id="nameFacultyInput" placeholder="Facultad" autocomplete="off" maxlength="100">
                            </div>
                            <div id="notificationF" class="notificationM"></div>

                            <button type="submit" class="btn" id="submitButton">Crear <i class="fa-brands fa-pushed"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Edit Faculty Modal -->
                <div class="modal" id="editarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos de la Facultad</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formEditFaculty" action="{{ route('faculty.edit') }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <input class="input-faculty" type="text" name="nameFaculty" id="nameFaculty" placeholder="Facultad" autocomplete="off" maxlength="200">
                            </div>
                            <input hidden type="text" name="facultyId" id="facultyEditId">
                            <div id="notificationFE" class="notificationM"></div>
                
                            <button id="btnEditUser" class="btn">Guardar <i class="fa-regular fa-floppy-disk"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Delete Faculty Modal -->
                <div class="modal" id="eliminarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar la Facultad?</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDeleteUser">
                            <form action="{{ route('faculty.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="facultyId" id="facultyId" class="error-input" autocomplete="off">
                                <button class="btn">Eliminar <i class="fa-solid fa-trash"></i></button>
                            </form>
                            <button class="btn cancel">Cancelar <i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/faculty.js') }}"></script>
@endsection