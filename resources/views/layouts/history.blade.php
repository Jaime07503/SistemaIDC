@extends('layout')

@section('title')
    Historial de Investigaciones
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/history.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Título -->
        <header class="head-content">
            <h1 class="head-lbl">Historial de Investigaciones de Cátedra</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" href="">Investigaciones de Cátedra</a>
            </div>
        </header>
        <!-- Vista general de las investigaciones de cátedra -->
        <section class="idcs-content">
            <h2 class="head">Vista general del curso</h2>
            <!-- Opciones para filtrar las investigaciones de cátedra -->
            <header class="options-courses">
                <!-- Input búsqueda por nombre de curso -->
                <input id="input-idc" class="custom-input" type="text" placeholder="Buscar...">
            </header>
            <!-- Investigaciones de Cátedra -->
            @if(isset($noIdcs))
                <h3 class="empty">Aún no tienes IDC finalizadas</h3>
            @else
                <aside class="idcs">
                    @foreach ($idcs as $idc)
                        <div class="card card-idcs">
                            <h5 class="card-title">Equipo #{{ $idc->teamId}}</h5>
                            <img src="{{ $idc->avatar }}" alt="Imagen" class="card-image">
                            <a href="{{ route('stagesProcess', ['researchTopicId' => $idc->researchTopicId, 
                                'teamId' => $idc->teamId, 'idcId' => $idc->idcId]) }}" class="card-link">{{ $idc->themeName }}
                            </a>
                        </div>
                    @endforeach
                </aside>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/history.js') }}"></script>
@endsection