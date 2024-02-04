@extends('layout')

@section('title')
    Asignación de fechas para IDC
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/idcDates.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Asignación de Fechas para IDC</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Asignación de Fechas</a>
            </div>
        </header>
        <section class="date-content">
            <form id="formDatesIdc" action="{{ route('datesIdc.assign') }}" method="POST">
                @csrf
                <div class="topicSearchReport">
                    <header class="title-lbl">Informe de Búsqueda de Información</header>
                    <div class="dates">
                        <div class="date-start">
                            <h3 class="date-lbl"><i class="fa-solid fa-hourglass-start"></i> Inicia</h3>
                            <input class="datepicker" type="datetime-local" placeholder="Fecha Inicio Informe de Búsqueda de Información" name="startDateSearchReport" value="{{ $datesIDC->startDateSearchReport ?? ''  }}">
                        </div>
                        <div class="date-end">
                            <h3 class="date-lbl"><i class="fa-solid fa-flag-checkered"></i> Finaliza</h3>
                            <input class="datepicker" type="datetime-local" placeholder="Fecha Finalización Informe de Búsqueda de Información" name="endDateSearchReport" value="{{ $datesIDC->endDateSearchReport ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="scientificArticleReport">
                    <header class="title-lbl">Informe del Artículo Científico</header>
                    <div class="dates">
                        <div class="date-start">
                            <h3 class="date-lbl"><i class="fa-solid fa-hourglass-start"></i> Inicia</h3>
                            <input class="datepicker" type="datetime-local" placeholder="Fecha Inicio Informe del Artículo Científico" name="startDateScientificArticleReport" value="{{ $datesIDC->startDateScientificArticleReport ?? '' }}">
                        </div>
                        <div class="date-end">
                            <h3 class="date-lbl"><i class="fa-solid fa-flag-checkered"></i> Finaliza</h3>
                            <input class="datepicker" type="datetime-local" placeholder="Fecha Finalización Informe del Artículo Científico " name="endDateScientificArticleReport" value="{{ $datesIDC->endDateScientificArticleReport ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="nextIdcTopicReport">
                    <header class="title-lbl">Informe de Temas próxima IDC</header>
                    <div class="dates">
                        <div class="date-start">
                            <h3 class="date-lbl"><i class="fa-solid fa-hourglass-start"></i> Inicia</h3>
                            <input class="datepicker" type="datetime-local" placeholder="Fecha Inicio Informe de Temas próxima IDC" name="startDateNextIdcTopic" value="{{ $datesIDC->startDateNextIdcTopic ?? '' }}">
                        </div>
                        <div class="date-end">
                            <h3 class="date-lbl"><i class="fa-solid fa-flag-checkered"></i> Finaliza</h3>
                            <input class="datepicker" type="datetime-local" placeholder="Fecha Finalización Informe de Temas próxima IDC" name="endDateNextIdcTopic" value="{{ $datesIDC->endDateNextIdcTopic ?? '' }}">
                        </div>
                    </div>
                </div>
                <div id="notificationD" class="notificationM"></div>
                <button type="submit" class="btn">Asignar Fechas</button>
            </form>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/idcDates.js') }}"></script>
@endsection