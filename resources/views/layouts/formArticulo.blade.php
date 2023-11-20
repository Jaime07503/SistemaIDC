@extends('layout')

@section('title')
{{ session('name')}}: Informacion del proceso
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/own/perfil.css') }}">
@endsection

@section('content')
<main class="main-content">
    <div class="head-content">
        <h1>Machine Learning</h1>
        <div class="history">
            <a class="view" href="{{ url('/tablero') }}">Tablero</a>
            <a class="view" href="{{ url('/perfil') }}">Mis Cursos</a>
            <a class="view" href="{{ url('/perfil') }}">TE-A-I2024</a>
            <a class="view" href="{{ url('/perfil') }}">MLI2024</a>
            <a class="view" href="{{ url('/perfil') }}">Articulo Bibliografico</a>
        </div>
        <form action="{{ route('generate-word') }}" method="post">
        <div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Resumen en Español</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Resumen en Ingles</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Introduccion</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Metodologia</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Desarrollo</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Conclusiones</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Referencias Bibliograficas</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Generar Word</button>
        </form>
