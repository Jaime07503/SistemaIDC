@extends('layout')

@section('title')
    Aprobación de Equipos de Investigación
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/approveTeam.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Aprobación de Equipos de Investigación</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/home') }}">Inicio del Sitio</a>
                <a class="history-view">Equipos de Investigación</a>
            </nav>
        </header>
        <section class="teams-content">
            <header class="head">
                <h2>Equipos de Investigación Postulados</h2>
            </header>
            <div class="secondary-content">
                <!-- Input Search RT -->
                <input id="searchInput" class="custom-input" type="text" placeholder="Buscar...">
                <!-- Equipos de investigación -->
                @if(isset($noTeams))
                    <h3 class="empty">No hay <strong>Equipos de Investigación Postulados</strong></h3>
                @else
                    <div class="teams">
                        @foreach($result as $teamResult)
                            @if(isset($teamResult['team']) && $teamResult['team'] !== null && isset($teamResult['students']) && $teamResult['students'] !== null)
                                <div class="team-content">
                                    <header class="top">
                                        <h3 class="subject">{{ $teamResult['team']->nameSubject }} </h3>
                                        <h3 class="themeName">{{ $teamResult['team']->themeName }}</h3>
                                    </header>
                                    <div class="students">
                                        @foreach($teamResult['user'] as $student)
                                            <div class="student">
                                                <img src="{{ $student->avatar }}" alt="{{ $student->name }} Avatar" class="ava">
                                                <div>
                                                    <h4>{{ $student->name.' '.$student->email.' ' }}</h4>
                                                    @if($student->participationsIdc > 0)
                                                        <h4>
                                                            Paticipaciones en IDC:
                                                            @for ($i = 0; $i < $student->participationsIdc; $i++)
                                                                <i class="fa-solid fa-award"></i>
                                                            @endfor
                                                        </h4>
                                                    @else
                                                        <h4>
                                                            Nunca a participado en IDC
                                                        </h4>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <form id="formApprovedTeam" action="{{ route('team.approve', ['teamId' => $teamResult['team']->teamId]) }}" method="POST">
                                        @csrf
                                        <button class="btn">Aprobar</button>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/approveTeam.js') }}"></script>
@endsection