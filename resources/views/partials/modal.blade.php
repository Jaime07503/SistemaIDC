<div id="avatarModal" class="modal">
    <div class="modal-content">
        <div class="user-info option">
            <a class="enlace-div perfil" href="{{ url('/perfil') }}">
                <i class="fa-regular fa-user"></i>{{ session('name') }}
            </a>
        </div>
        <div class="line"></div>
        <div class="user-options">
            <div class="option tablero">
                <a class="enlace-div" href="{{ url('/tablero') }}">
                    <i class="fa-solid fa-gauge-high"></i>Tablero
                </a>
            </div>
            <div class="option investigaciones">
                <a class="enlace-div" href="#">
                    <i class="fa-regular fa-folder"></i>Mis investigaciones
                </a>
            </div>
            <div class="option perfil-user">
                <a class="enlace-div" href="{{ url('/perfil') }}">
                    <i class="fa-regular fa-user"></i>Perfil
                </a>
            </div>
            <div class="option salir">
                <a class="enlace-div" href="{{ url('/google-logout') }}">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180"></i>Salir
                </a>
            </div>
        </div>
    </div>
</div>