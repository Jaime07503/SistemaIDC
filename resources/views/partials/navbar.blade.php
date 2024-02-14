<!-- Navbar -->
<header class="header">
    <nav id="navbar">
        <div class="logo">
            <img src="{{ asset('images/logo_unicaes.webp') }}" alt="Logo UNICAES">
        </div>
        <div class="navbar-content">
            @if(auth()->user()->role !== 'Administrador del Sistema')
                <div class="ic_notificaciones ico">
                    <span class="ic">
                        <i class="fa-regular fa-bell"></i>
                        @if(count(auth()->user()->unreadNotifications) > 0)
                            <span class="badge">{{ count(auth()->user()->unreadNotifications) }}</span>
                        @endif
                    </span>
                </div>
            @endif
            <div class="avatar-container">
                @if (auth()->user()->avatar)
                    <img class="avatar" src="{{ auth()->user()->avatar }}" alt="Avatar">
                    <span class="ic_flecha ico"><i class="fa-solid fa-chevron-down"></i></span>
                @endif
            </div>
        </div>
    </nav>
</header>