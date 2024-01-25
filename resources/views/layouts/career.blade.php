@extends('layout')

@section('title')
    Administración de Carreras
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/administration.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Administración de Carreras</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" >Carreras</a>
            </div>
        </div>
        <div class="info-user">
            <div class="head">
                <h2>Carreras</h2>
            </div>
            <div class="options-users">
                <div class="opt">
                    <!-- Listbox -->
                    <div class="custom-listbox">
                        <div class="listbox-header">
                            <button class="listbox" type="button"><span class="selected-option">Todos</span></button>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            @foreach ($facultys as $faculty)
                                <li data-value="{{ $faculty->nameFaculty }}">{{ $faculty->nameFaculty }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Input Search RT -->
                    <input class="custom-input" type="text" placeholder="Buscar">
                </div>
                <!-- Add user button -->
                <button type="button" id="btnAddUser" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
            </div>

            <!-- Users Table -->
            <div class="users-content">
                <table id="data-table-careers" class="table content-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Facultad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($careers as $career)
                            <tr>
                                <td>{{ $career->nameCareer }}</td>
                                <td>{{ $career->nameFaculty }}</td>
                                <td>
                                    <button class="btn-edit btn" data-modal="editarModal"
                                        data-nameFaculty="{{ $career->nameFaculty }}"
                                        data-careerId="{{ $career->careerId }}"
                                        data-nameCareer="{{ $career->nameCareer }}"
                                        data-idFaculty="{{ $career->idFaculty }}"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-delete btn" data-modal="eliminarModal"
                                        data-careerId="{{ $career->careerId }}"
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
                            <h2>Datos de la carrera</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form action="{{ url('/editCareer') }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <input class="error-input" type="text" name="nameCareerInput" id="nameCareerInput" autocomplete="off">
                                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                            </div>
                            <!-- Listbox -->
                            <div class="custom-listbox">
                                <div class="listbox-header listbox-header-edit faculty-edit">
                                    <button class="listbox" type="button"><span class="selected-option faculty"></span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    @foreach ($facultys as $faculty)
                                        <li data-value="{{$faculty->facultyId}}">{{$faculty->nameFaculty}} </li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="text" hidden name="idFaculty" class="nameFaculty">
                            <input type="text" hidden name="careerId" class="careerId">
                            <button id="btnEditUser" class="btn">Guardar</button>
                        </form>
                    </div>
                </div>

                <!-- Delete user modal -->
                <div class="modal" id="eliminarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar la carrera?</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDeleteUser">
                            <form action="{{ route('deleteCareer') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="careerId" id="idInputs" class="error-input" autocomplete="off">
                                <button class="btn">Eliminar</button>
                            </form>
                            <button class="btn cancel">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add faculty modal -->
            <div id="myModalUser" class="modal">
                <div class="modal-content">
                    <header class="head">
                        <h2>Nueva Carrera</h2>
                        <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                    </header>
                    <form action="{{ url('/addCareer') }}" method="POST" id="formCareer" class="addCareer">
                        @csrf
                        <div class="input-box">
                            <input type="text" name="nameCareer" id="nameCareerInput" placeholder="Nombre de la Carrera" class="error-input" autocomplete="off">
                            <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
                        </div>

                        <div class="custom-listbox faculty-lst">
                            <div class="listbox-header listbox-header-edit">
                                <button class="listbox" type="button"><span class="selected-option">Facultad</span></button>
                                <i class="fa-solid fa-chevron-down arrow-down"></i>
                            </div>
                            <ul class="options optionsEdit">
                                @foreach ($facultys as $faculty)
                                    <li data-value="{{ $faculty->facultyId }}">{{ $faculty->nameFaculty }} </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="text" hidden name="idFaculty" class="idFaculty">
                        <button type="submit" class="btn" id="submitButton">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/career.js') }}"></script>
@endsection
