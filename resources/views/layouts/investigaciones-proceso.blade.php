@extends('layout')

@section('title')
    Proceso IDC - <?=$materiaIDC?>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/investigaciones.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1><?=$materiaIDC?></h1>
            <div class="track-carrousel">
                <div class="track-card">
                    <a href="{{ url('/tablero') }}">Tablero</a>
                </div>
                <div class="track-card">
                    <a>Investigaciones</a>
                </div>
                <div class="track-card">
                    <a>MM503</a>
                </div>
            </div>
        </div>
        <div class="courses-content">
            <h2 class="title"><strong>Etapas del proceso</strong></h2>
            <div class="courses">
                <div class="card">
                    <div class="card-body">
                        <a href="#" class="card-link">
                        <h5 class="card-title">Información del Proceso</h5>
                        <img src="{{ asset('images/proceso_01.png') }}" alt="Proceso"/>
                        </a>
                        <h4><?= ($progresoIDC*5 > 100)  ? '100% completado' : ($progresoIDC*5).'% completado' ?>  </h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a href="#" class="card-link">
                        <h5 class="card-title">Búsqueda de Información</h5>
                        <img src="{{ asset('images/proceso_02.png') }}" alt="Proceso"/>
                        </a>
                        <h4><?= (($progresoIDC-20)*3.33 > 100)  ? '100% completado' : (($progresoIDC-20)*3.33).'% completado' ?>  </h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a href="#" class="card-link">
                        <h5 class="card-title">Artículo Bibliográfico</h5>
                        <img src="{{ asset('images/proceso_03.png') }}" alt="Proceso"/>
                        </a>
                        <h4><?= (($progresoIDC-50)*3.33 > 100)  ? '100% completado' : ( (($progresoIDC-50)*3.33 > 0) ? ($progresoIDC-50)*3.33.'% completado' : 'No disponible' ) ?>  </h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a href="#" class="card-link">
                        <h5 class="card-title">Finalización del Proceso</h5>
                        <img src="{{ asset('images/proceso_04.png') }}" alt="Proceso"/>
                        </a>
                        <h4><?= (($progresoIDC-80)*5 > 100)  ? '100% completado' : ( (($progresoIDC-80)*5 > 0) ? (($progresoIDC-80)*5).'% completado': 'No disponible') ?>  </h4>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection