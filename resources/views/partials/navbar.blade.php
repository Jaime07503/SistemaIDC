<!-- Navbar -->
<header class="header">
    <nav id="navbar">
        <div class="logo">
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
</header>