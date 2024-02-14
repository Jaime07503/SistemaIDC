@extends('layout')

@section('title')
    {{ auth()->user()->name }}: Perfil público
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/perfil.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <!-- Título -->
        <header class="head-content">
            <h1 class="head-lbl">Perfil del usuario</h1>
            <div class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view" href="">Perfil</a>
            </div>
        </header>
        <section class="user-content">
            <div class="basic-information">
                <header class="perfil">
                    <img class="avatar-user" src="{{ $user->avatar }}" alt="Avatar">
                    <h2 class="lbl2">{{ $user->name }}</h2>
                    <button class="btn" id="btnChangeAvatar">Cambiar Avatar</button>
                </header>
                <div class="information">
                    <header>
                        <h2 class="lbl2">Información personal</h2>
                    </header>
                    <div class="data">
                        <h3 class="lbl3"><strong>Dirección Email</strong></h3>
                        <p class="paragraph">{{ $user->email }}</p>
                        @if(auth()->user()->role === 'Estudiante' || auth()->user()->role === 'Docente')
                            <h3 class="lbl3"><strong>Participaciones IDC</strong></h3>
                            <div class="badges">
                                @for ($i = 0; $i < $userInfo->idcQuantity; $i++)
                                    <i class="fa-solid fa-medal badge"></i>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
                <div class="income-information">
                    <header>
                        <h2 class="lbl2">Actividad del ingresos</h2>
                    </header>
                    <div class="data">
                        <h3 class="lbl3">Primer acceso al sitio</h3>
                        <p class="paragraph">{{ $formattedFL }}</p>
                        <h3 class="lbl3">Último acceso al sitio</h3>
                        <p class="paragraph">{{ $formattedLL }}</p>
                    </div>
                </div>
            </div>
            @if(auth()->user()->role === 'Estudiante' || auth()->user()->role === 'Docente')
                @if(isset($noIdcs))
                    <h3 class="empty">No tienes <strong>Investigaciones de Cátedra Activas</strong></h3>
                @else
                    <div class="actives-idc">
                        <h2 class="lbl2">Detalles de las investigaciones de catedra</h2>
                        @foreach ($idcs as $idc)
                            <div class="idc-link">
                                <img class="avatarTopic" src="{{ $idc->avatar }}" alt="Avatar">
                                <a class="link" href="{{ route('stagesProcess', ['researchTopicId' => $idc->researchTopicId, 
                                    'teamId' => $idc->teamId, 'idcId' => $idc->idcId]) }}">{{ $idc->themeName }} - Equipo #{{ $idc->teamId }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </section>
        <!-- Modal Change User Avatar -->
        <div id="myModalEditUser" class="modal">
            <div class="modal-content">
                <header class="head">
                    <h2 class="lbl2">Cambiar avatar</h2>
                    <button type="button" id="cerrarModalEditUser"><i class="fa-solid fa-xmark"></i></button>
                </header>
                <div class="basic-information">
                    <form id="formChangeAvatar" class="changeAvatar" action="{{ route('userAvatar.update', ['idUser' => $user->userId]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container file-container" id="container">
                            <input type="file" name="avatar" class="file-input" accept="image/png, image/jpeg" hidden>
                            <div class="img-area" data-img="">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <h4>Avatar</h4>
                                <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                <img id="uploadedImage" src="" alt="Imagen previa" style="display: none;">
                            </div>
                        </div>
                        <div id="notificationU" class="notificationM"></div>
                        <button type="submit" class="btn" id="submitButton">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/perfil.js') }}"></script>
@endsection