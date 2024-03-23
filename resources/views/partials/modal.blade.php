<div id="userModal" class="modalUser">
    <div class="modal-content-user">
        <div class="user-options">
            <div class="option perfil-user">
                <a class="enlace-div" href="{{ url('/perfil', ['idUser' => session('userId')]) }}">
                    <i class="fa-regular fa-user icon"></i>Perfil
                </a>
            </div>
            @if(auth()->user()->role === 'Estudiante' || auth()->user()->role === 'Docente' || auth()->user()->role === 'Coordinador')
                <div class="option tablero">
                    <a class="enlace-div" href="{{ url('/tablero') }}">
                        <i class="fa-solid fa-gauge-high icon"></i>Tablero
                    </a>
                </div>
            @else
                <div class="option home">
                    <a class="enlace-div" href="{{ url('/home') }}">
                        <i class="fa-solid fa-house icon"></i>Inicio del Sitio
                    </a>
                </div>
            @endif
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
            @if(auth()->user()->unreadNotifications->isEmpty())
                <h2 class="empty-notification">No tienes notificaciones</h2>
            @else
                @foreach(auth()->user()->unreadNotifications as $notification)
                    <div class="notificationContent">
                        @if($notification->data['type'] === 'AT') 
                            <a href="{{ route('researchTopicInformation', ['researchTopicId' => $notification->data['researchTopicId'], 
                                'subjectId' => $notification->data['subjectId']]) }}" class="link">
                                {{ $notification->data['title'] }} - {{ $notification->created_at->locale('es')->diffForHumans() }}
                            </a>
                        @elseif($notification->data['type'] === 'PRT')
                            <a href="{{ route('approveResearchTopics') }}" class="link">
                                {{ $notification->data['title'] }} - {{ $notification->created_at->locale('es')->diffForHumans() }}
                            </a>
                            <!-- Falta ART -->
                        @elseif($notification->data['type'] === 'PT')
                            <a href="{{ route('approveTeam') }}" class="link">
                                {{ $notification->data['title'] }} - {{ $notification->created_at->locale('es')->diffForHumans() }}
                            </a>
                        @elseif($notification->data['type'] === 'TSR' || $notification->data['type'] === 'TSRAPP' || $notification->data['type'] === 'CHTSRCRT'
                        || $notification->data['type'] === 'TSRCRD' || $notification->data['type'] === 'TSRCRT' || $notification->data['type'] === 'TSRDEC'
                        || $notification->data['type'] === 'CHTSRCRD')
                            <a href="{{ route('searchInformation', ['idcId' => $notification->data['idcId'], 
                                'idTopicSearchReport' => $notification->data['idTopicSearchReport']]) }}" class="link">
                                {{ $notification->data['title'] }} - {{ $notification->created_at->locale('es')->diffForHumans() }}
                            </a>
                        @elseif($notification->data['type'] === 'SAR' || $notification->data['type'] === 'SARAPP'  || $notification->data['type'] === 'CHSARCRT'
                        || $notification->data['type'] === 'SARCRD' || $notification->data['type'] === 'SARCRT' || $notification->data['type'] === 'SARDEC'
                        || $notification->data['type'] === 'SARDI' || $notification->data['type'] === 'CHSARDI' || $notification->data['type'] === 'CHSARCRD')
                            <a href="{{ route('scientificArticle', ['idcId' => $notification->data['idcId'], 
                                'idScientificArticleReport' => $notification->data['idScientificArticleReport']]) }}" class="link">
                                {{ $notification->data['title'] }} - {{ $notification->created_at->locale('es')->diffForHumans() }}
                            </a>
                        @elseif($notification->data['type'] === 'NTR' || $notification->data['type'] === 'NTRAPP' || $notification->data['type'] === 'CHNTRCRT'
                        || $notification->data['type'] === 'NTRCRD' || $notification->data['type'] === 'NTRCRT' || $notification->data['type'] === 'NTRDEC'
                        || $notification->data['type'] === 'CHNTRCRD')
                            <a href="{{ route('endProcess', ['idcId' => $notification->data['idcId'], 
                                'idNextIdcTopicReport' => $notification->data['idNextIdcTopicReport']]) }}" class="link">
                                {{ $notification->data['title'] }} - {{ $notification->created_at->locale('es')->diffForHumans() }}
                            </a>
                        @endif
                    </div>
                @endforeach
            @endif
        </section>
        <footer class="footer">
            <a href="{{ route('markAsRead') }}" class="notification-mark-all">Marcar como leídas <i class="fa-solid fa-check"></i></a>
        </footer>
    </div>
</div>