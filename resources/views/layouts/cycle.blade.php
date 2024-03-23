@extends('layout')

@section('title')
    Administración de Ciclos
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/cycle.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Administración de Ciclos</h1>
            <nav class="history">
                <a class="history-view" href="{{ route('home') }}">Inicio del Sitio</a>
                <a class="history-view">Ciclos</a>
            </nav>
        </header>
        <section class="cycle-content">
            <h2><i class="fa-solid fa-arrows-spin"></i> Ciclos</h2>
            <div class="options-users">
                <input id="searchInput" class="custom-input" type="text" placeholder="Buscar...">
                <!-- Add Cycle Button -->
                <button type="button" id="btnAddCycle" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
            </div>

            <!-- Cycles Table -->
            <div class="cycles-content">
                @if(isset($noCycles))
                    <h3 class="empty">No hay <strong>Ciclos creados</strong></h3>
                @else
                    <table id="data-table-cycle" class="table content-table">
                        <thead>
                            <tr>
                                <th>Ciclo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cycles as $cycle)
                                <tr>
                                    <td data-values="Ciclo">{{ $cycle->cycle }}</td>
                                    <td data-values="Estado">{{ $cycle->state }}</td>
                                    <td data-values="Acciones">
                                        @if($cycle->state !== 'Activo')
                                            <button class="btn-edit btn" data-modal="editarModal"
                                                data-cycleId="{{ $cycle->cycleId }}"
                                                data-nameCycle="{{ $cycle->cycle }}"
                                                data-state="{{ $cycle->state }}"
                                            >
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn-delete btn" data-modal="eliminarModal"
                                                data-cycleId="{{ $cycle->cycleId }}"
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

                <!-- Add Cycle Modal -->
                <div id="myModalCycle" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo Ciclo</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formAddCycle" class="forms" action="{{ route('cycle.create') }}" method="POST" id="formCycle" class="addCycle">
                            @csrf
                            <div class="input-box">
                                <input class="input-cycle" type="text" name="nameCycle" id="nameCycleInput" placeholder="Ciclo" autocomplete="off" maxlength="13">
                            </div>
                            <!-- State Listbox -->
                            <div class="custom-listbox state">
                                <div class="listbox-header listbox-header-edit">
                                    <button type="button" class="listbox"><span class="selected-option" id="state" data-value="Estado">Estado</span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    <li data-value="Activo">Activo</li>
                                    <li data-value="Inactivo">Inactivo</li>
                                </ul>
                            </div>
                            <input hidden type="text" name="state" id="stateInput">
                            <div id="notificationC" class="notificationM"></div>

                            <button type="submit" class="btn">Crear <i class="fa-brands fa-pushed"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Edit Cycle Modal -->
                <div class="modal" id="editarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos del Ciclo</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formEditCycle" class="forms" action="{{ route('cycle.edit') }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <input class="input-cycle" type="text" name="nameCycle" id="nameCycle" placeholder="Ciclo" autocomplete="off" maxlength="40">
                            </div>
                            <!-- State Listbox -->
                            <div class="custom-listbox state-edit">
                                <div class="listbox-header listbox-header-edit">
                                    <button type="button" class="listbox"><span class="selected-option" id="spanStateEdit"></span></button>
                                    <i class="fa-solid fa-chevron-down arrow-down"></i>
                                </div>
                                <ul class="options optionsEdit">
                                    <li data-value="Activo">Activo</li>
                                    <li data-value="Inactivo">Inactivo</li>
                                </ul>
                            </div>
                            <input hidden type="text" name="state" id="stateInputEdit">
                            <input hidden type="text" name="cycleId" id="cycleEditId">
                            <div id="notificationCE" class="notificationM"></div>
                
                            <button type="submit" class="btn">Guardar <i class="fa-regular fa-floppy-disk"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Delete Cycle Modal -->
                <div class="modal" id="eliminarModal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar el Ciclo?</h2>
                            <button type="button" class="cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDeleteCycle">
                            <form action="{{ route('cycle.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="cycleId" id="cycleId" class="error-input" autocomplete="off">
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
    <script src=" {{ asset('js/cycle.js') }}"></script>
@endsection