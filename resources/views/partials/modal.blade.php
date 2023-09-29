<!-- Ventana Modal Perfil -->
<div id="avatarModal" class="modal">
    <div class="modal-contenido">
        <div class="name-user us-op">
            <a class="enlace-div" href="{{ url('/perfil') }}"><i class="fa-regular fa-user"></i>{{ session('name') }}</a>
        </div>
        <div class="line"></div>
        <div class="user-options">
            <div class="tablero us-op">
                <a class="enlace-div" href="{{ url('/tablero') }}"><i class="fa-solid fa-gauge-high"></i>Tablero</a>
            </div>
            <div class="investigaciones us-op">
                <a class="enlace-div" href="{{ url('/investigaciones') }}"><i class="fa-regular fa-folder"></i>Mis investigaciones</a>
            </div>
            <div class="perfil-user us-op">
                <a class="enlace-div" href="{{ url('/perfil') }}"><i class="fa-regular fa-user"></i>Perfil</a>
            </div>
        </div>
        <div class="line"></div>
        <div class="salir us-op">
            <a class="enlace-div" href="{{ url('/google-logout') }}"><i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180"></i>Salir</a>
        </div>
    </div>
</div>