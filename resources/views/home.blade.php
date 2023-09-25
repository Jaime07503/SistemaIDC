<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Home</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="shortcut icon" href="https://plataforma.catolica.edu.sv/pluginfile.php/1/theme_moove/favicon/1672891795/favicon.ico">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
    </head>
    <body>
    <!-- Navbar -->
    <header class="header">
        <nav id="navbar">
            <div class="logo">
                <img src="{{ asset('images/logo_unicaes.png') }}" alt="Logo UNICAES">
            </div>
            <div class="navbar-content">
                <div class="ic_mensajeria ico">
                    <span class="ic">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                </div>
                <div class="ic_notificaciones ico">
                    <span class="ic">
                        <i class="fa-regular fa-bell"></i>
                    </span>
                </div>
                <div class="avatar-container">
                    @if (session('avatarUrl'))
                        <img class="avatar" src="{{ session('avatarUrl') }}" alt="Avatar">
                        <span class="ic_flecha ico"><i class="fa-solid fa-chevron-down"></i></span>
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenido Principal -->
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
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ciclo I 2024</h5>
                            <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                            <a href="#" class="card-link">Principios de Electrónica</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ciclo I 2024</h5>
                            <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                            <a href="#" class="card-link">Redes</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ciclo I 2024</h5>
                            <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                            <a href="#" class="card-link">Programación Orientada a Objetos</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ciclo I 2024</h5>
                            <img src="{{ asset('images/curso_logo.png') }}" alt="Imagen">
                            <a href="#" class="card-link">Administración de Servidores</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Ventana Modal Perfil -->
    <div id="avatarModal" class="modal">
        <div class="modal-contenido">
            <!-- Opciones -->
            <div class="name-user">
                <i class="fa-regular fa-user"></i>
                {{ session('name') }}
            </div>
            <div class="line"></div>
            <div class="tablero">
                <i class="fa-solid fa-gauge-high"></i>
                <a href="{{ url('/tablero') }}">Tablero</a>
            </div>
            <div class="investigaciones">
                <i class="fa-regular fa-folder"></i>
                <a href="{{ url('/investigaciones') }}">Mis investigaciones</a>
            </div>
            <div class="perfil">
                <i class="fa-regular fa-user"></i>
                <a href="{{ url('/perfil') }}">Perfil</a>
            </div>
            <div class="line">
            </div>
            <div class="salir">
                <i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180"></i>
                <a href="">Salir</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src=" {{ asset('js/home.js') }}"></script>
    </body>
</html>