<!-- Navbar -->
<header class="header">
    <nav id="navbar">
        <div class="logo">
            @if(auth()->user()->role === 'Administrador del sistema' || auth()->user()->role === 'Administrador del proceso' || auth()->user()->role === 'Coordinador')
                <div id="menu-btn" class="ico">
                    <span id="menu-icon" class="ic">
                        <i class="fa-solid fa-bars"></i>
                    </span>
                </div>
            @endif
            <img src="{{ asset('images/logo_unicaes.webp') }}" alt="Logo UNICAES">
        </div>
        <div class="navbar-content">
            <div class="ic_notificaciones ico">
                <span class="ic">
                    <i class="fa-regular fa-bell"></i>
                    @if(count(auth()->user()->unreadNotifications) > 0)
                        <span class="badge">{{ count(auth()->user()->unreadNotifications) }}</span>
                    @endif
                </span>
            </div>
            <div class="avatar-container">
                @if (auth()->user()->avatar)
                    <img class="avatar" src="{{ auth()->user()->avatar }}" alt="Avatar">
                    <span class="ic_flecha ico"><i class="fa-solid fa-chevron-down"></i></span>
                @endif
            </div>
        </div>
    </nav>

    <!-- Menu Despegable -->
    <div class="dropdown-menu" id="dropdown-menu">
        <nav class="content-menu">
            <ul class="list">
                @if(auth()->user()->role === 'Administrador del sistema')
                    <li class="list-item list-item--click">
                        <div class="list-button list-button--click">
                            <h2 class="nav-link">Administración</h2>
                            <i class="fa-solid fa-chevron-down list-arrow"></i>
                        </div>
                        <ul class="list-show">
                            <li class="list-inside">
                                <a href="{{ route('cycle') }}" class="nav-link nav-link--inside">Ciclos</a>
                            </li>
                            <li class="list-inside">
                                <a href="{{ route('faculty') }}" class="nav-link nav-link--inside">Facultades</a>
                            </li>
                            <li class="list-inside">
                                <a href="{{ route('career') }}" class="nav-link nav-link--inside">Carreras</a>
                            </li>
                            <li class="list-inside">
                                <a href="{{ route('subject') }}" class="nav-link nav-link--inside">Materias</a>
                            </li>
                            <li class="list-inside">
                                <a href="{{ route('user') }}" class="nav-link nav-link--inside">Usuarios</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="list-item list-item--click">
                    <div class="list-button list-button--click">
                        <h2 class="nav-link">Asignación</h2>
                        <i class="fa-solid fa-chevron-down list-arrow"></i>
                    </div>
                    <ul class="list-show">
                        <li class="list-inside">
                            <a href="{{ route('assignSubject') }}" class="nav-link nav-link--inside">Materias</a>
                        </li>
                        <li class="list-inside">
                            <a href="{{ route('idcDates') }}" class="nav-link nav-link--inside">Fechas IDC</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>