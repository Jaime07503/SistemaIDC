<!-- Navbar -->
<header class="header">
    <nav id="navbar">
        <div class="logo">
            <div id="menu-btn" class="ico">
                <span id="menu-icon" class="ic">
                    <i class="fa-solid fa-bars"></i>
                </span>
            </div>
            <img src="{{ asset('images/logo_unicaes.webp') }}" alt="Logo UNICAES">
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
    
    <!-- Menu Despegable -->
    <div class="dropdown-menu" id="dropdown-menu">
        <nav class="content-menu">
            <ul class="list">
                <li class="list-item list-item--click">
                    <div class="list-button list-button--click">
                        <a href="#" class="nav-link">Administración</a>
                        <i class="fa-solid fa-chevron-down list-arrow"></i>
                    </div>
                    <ul class="list-show">
                        <li class="list-inside">
                            <a href="#" class="nav-link nav-link--inside">Facultad</a>
                        </li> 
                        <li class="list-inside">
                            <a href="#" class="nav-link nav-link--inside">Carreras</a>
                        </li>
                        <li class="list-inside">
                            <a href="#" class="nav-link nav-link--inside">Materias</a>
                        </li>
                        <li class="list-inside">
                            <a href="{{ url('/administration') }}" class="nav-link nav-link--inside">Usuarios</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>