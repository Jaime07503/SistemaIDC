@extends('layout')

@section('title')
    Home
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
        <main class="main-content">
        <div class="container">
            <div class="contenido-main">
                <h1>Investigaciones de Cátedra</h1>
                <img src="{{ asset('images/idc_logo.png') }}" alt="Logo IDC">
            </div>
            <div class="contenido-info">
                <div class="tit">
                    <h1>IDC</h1>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sed debitis dicta illo placeat impedit harum neque! Quam amet repellat ad repudiandae, placeat impedit laboriosam harum nobis, quae aut provident officiis!</p>
                </div>
                <div class="cont">
                    <div class="mision">
                        <h3>Misión</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt officiis, quos cum placeat quibusdam assumenda! Voluptates molestiae commodi quae enim distinctio. Vitae incidunt voluptas mollitia cum et enim nihil doloribus.</p>
                    </div>
                    <div class="vision">
                        <h3>Visión</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi cupiditate delectus fugiat vel amet repudiandae, sapiente, minima esse magnam neque ex, laborum eum perferendis non possimus a rerum veritatis vero!</p>
                    </div>
                </div>
            </div>
            <!-- Contenido Secundario -->
            <div class="contenido-second">
                <div class="head">
                    <h3>Vista general del curso</h3>
                    <!-- <div class="line"></div> -->
                </div>
                <div class="options">
                    <div class="options-search">
                         <div class="options-listbox">
                            <select>
                                <option value="todos">Todos</option>
                                <option value="en-progreso">En progreso</option>
                                <option value="pasados">Pasados</option>
                            </select>
                        </div>
                        <div class="search-box">
                            <input type="text" class="search-input" placeholder="Buscar">
                        </div>
                        <div class="name-listbox">
                            <select>
                                <option value="nombre-curso">Nombre del Curso</option>
                                <option value="ultimo-accedido">Último Accedido</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Cursos -->
                <div class="cursos">
                    @foreach ($courses as $course)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->subjectCycle }}</h5>
                            <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                            <a href="#" class="card-link">{{ $course->nameSubject }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <!-- Ventana Modal Perfil -->
    
@endsection

@section('scripts')
    <script src=" {{ asset('js/home.js') }}"></script>
@endsection