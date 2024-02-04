@extends('layout')

@section('title')
    Inicio del Sitio
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/home.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1 class="head-lbl">Investigaciones de Cátedra</h1>
        </header>
        <section class="facultys-content">
            @foreach($facultys as $faculty)
                <ul class="lt-faculty">
                    <li class="lt-item-faculty lt-item-faculty--click">
                        <div class="lt-button-faculty lt-button--click-faculty">
                            <i class="fa-solid fa-chevron-down lt-arrow"></i>
                            <h2 class="faculty"><strong>{{$faculty->nameFaculty}}</strong></h2>
                        </div>
                        <ul class="lt-show-careers">
                            @foreach($faculty->career as $careerF)
                                <li class="lt-inside-career lt-item-career--click">
                                    <div class="lt-button-career lt-button--click-career">
                                        <i class="fa-solid fa-chevron-down lt-arrow"></i>
                                        <h2 class="faculty">{{$careerF->nameCareer}}</h2>
                                    </div>
                                    <ul class="lt-show-subjects">
                                        @foreach($careerF->subject as $subjectC)
                                            <li class="lt-inside-subject lt-item-subject--click">
                                                <div class="lt-button-subject lt-button--click-subject">
                                                    <i class="fa-solid fa-chevron-down lt-arrow"></i>
                                                    <h2 class="faculty">{{$subjectC->nameSubject}}</h2>
                                                </div>
                                                <ul class="lt-show-researchTopics">
                                                    @foreach($subjectC->researchTopic as $researchTopicS)
                                                        <li class="lt-inside-researchTopic lt-item-researchTopic--click">
                                                            <div class="lt-button-subject lt-button--click-subject">
                                                                <i class="fa-solid fa-chevron-down lt-arrow"></i>
                                                                <h2 class="faculty">{{ $researchTopicS->themeName }}</h2>
                                                            </div>
                                                            <ul class="lt-show-teams">
                                                                @foreach($researchTopicS->team as $teamRT)
                                                                    <a class="lt-link" href="{{ route('stagesProcess', ['researchTopicId' => $researchTopicS->researchTopicId, 
                                                                        'teamId' => $teamRT->teamId, 'idcId' => $teamRT->idc->idcId]) }}"> <img src="{{ $researchTopicS->avatar }}" alt="Avatar tema" 
                                                                        class="img-topic">
                                                                        Equipo #{{ $teamRT->teamId }}
                                                                    </a>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            @endforeach
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/home.js') }}"></script>
@endsection