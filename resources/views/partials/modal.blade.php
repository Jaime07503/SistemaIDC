<div id="userModal" class="modalUser">
    <div class="modal-content-user">
        <div class="user-options">
            <div class="option perfil-user">
                <a class="enlace-div" href="{{ url('/perfil', ['idUser' => session('userId')]) }}">
                    <i class="fa-regular fa-user icon"></i>Perfil
                </a>
            </div>
            <div class="option tablero">
                <a class="enlace-div" href="{{ url('/tablero') }}">
                    <i class="fa-solid fa-gauge-high icon"></i>Tablero
                </a>
            </div>
            <div class="option historial">
                <a class="enlace-div" href="{{ url('/history', ['idUser' => session('userId')]) }}">
                    <i class="fa-regular fa-folder icon"></i>Historial
                </a>
            </div>
            <div class="option salir">
                <a class="enlace-div" href="{{ url('/google-logout') }}">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180 icon"></i>Salir
                </a>
            </div>
        </div>
    </div>
</div>

<div id="notificationModal" class="notificationUser">
    <div class="notification-content-user">
        <header class="head-notification">
            <h2 class="notification-title">Notificaciones</h2>
        </header>
        <section class="notifications">
            @foreach(auth()->user()->notification as $notification)
                <div class="notification">
                    <h3 class="notification-subtitle">{{ $notification->notification }}</h3>
                    <a href="{{ $notification->state }}" class="link">Ver detalles</a>
                </div>
            @endforeach
        </section>
    </div>
</div>