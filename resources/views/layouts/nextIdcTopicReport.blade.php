@extends('layout')

@section('title')
    Informe de Temas para siguiente IDC
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/nextIdcTopicReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1 class="head-lbl">{{ $nextIdcTopicReport->themeName }} - Equipo #{{ $nextIdcTopicReport->teamId}} - Informe de temas para siguiente IDC</h1>
            <nav class="history">
            <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis investigaciones</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $nextIdcTopicReport->researchTopicId, 'subjectId' => $nextIdcTopicReport->subjectId]) }}">{{ $nextIdcTopicReport->code}}</a>
                <a class="history-view" href="{{ route('stagesProcess', ['researchTopicId' => $nextIdcTopicReport->researchTopicId, 
                    'teamId' => $nextIdcTopicReport->teamId, 'idcId' => $nextIdcTopicReport->idcId]) }}">Etapas del proceso
                </a>
                <a class="history-view" href="{{ route('endProcess', ['idcId' => $idcId, 
                        'idNextIdcTopicReport' => $idNextIdcTopicReport]) }}">Estatus del informe
                </a>
                <a class="history-view" href="">Informe de temas para siguiente IDC</a>
            </nav>
        </header>
        @if($role === 'Docente')
            <section class="nextTopic">
                <form id="myForm" class="nextTopic-content" action=" {{ route('generate-nextIdcReport') }}" method="POST">
                    @csrf
                    <div class="first-section">
                        <strong><h2>Introducción</h2></strong>
                        <textarea class="textarea textareaTopic" name="introduction" placeholder="Resumen de actividades" min="300" maxlength="400"></textarea>
                        <textarea class="textarea textareaTopic" name="continueTopic" placeholder="Continuar con el tema o investigar sobre sus ramas" min="700" maxlength="850"></textarea>
                        <textarea class="textarea textareaTopic" name="proposeTopics" placeholder="Se propondrán temas nuevos o derivados" min="700" maxlength="850"></textarea>
                    </div>
                    <div class="second-section">
                        <strong><h2>Temas de investigación propuestos</h2></strong>
                        <table id="data-table-topic" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Tema</th>
                                    <th>Relevancia</th>
                                    <th>Estado</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topics as $topic)
                                    <tr>
                                        <td data-values="Tema"><p>{{ $topic->nameTopic }}</p></td>
                                        <td data-values="Tema"><p>{{ $topic->subjectRelevance }}</p></td>
                                        <td data-values="Estado">
                                            @if($topic->state !== 'Aprobado')
                                                <button type="button" class="btn btn-aproved-topic" data-values="{{ $topic->topicId }}">Aprobar</button>
                                                <h4 style="font-weight: 100; display: none" class="stateTopic" id="state-topic-{{ $topic->topicId }}">{{ $topic->state }}</h4>   
                                            @else 
                                                <h4 style="font-weight: 100;">{{ $topic->state}}</h4>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-edit" data-modal="verDetallesModalTopic" data-topicId="{{ $topic->topicId }}" 
                                                data-nameTopic="{{ $topic->nameTopic }}" data-subjectRelevance="{{ $topic->subjectRelevance }}" data-globalUpdateImg="{{ $topic->globalUpdateImg }}"
                                                data-localUpdateImg="{{ $topic->localUpdateImg }}" data-updatedInformation="{{ $topic->updatedInformation }}" data-localRelevance="{{ $topic->localRelevance }}" 
                                                data-globalRelevance="{{ $topic->globalRelevance }}">
                                                <i class="fa-regular fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="third-section">
                        <strong><h2>Conclusión</h2></strong>
                        <textarea class="textarea textareaTopic" name="conclusion" placeholder="Conclusión" maxlength="800"></textarea>
                    </div>
                    <input name="idcId" type="text" hidden value="{{ $idcId }}">
                    <input name="idNextIdcTopicReport" type="text" hidden value="{{ $idNextIdcTopicReport }}">
                    <button type="submit" id="submitButton" class="btn">Generar Documento</button>
                </form>
                <div id="notification" class="notification"></div>
            </section>
            <div id="verDetallesModalTopic" class="modal">
                <div class="modal-content">
                    <header class="head">
                        <h2>Datos del tema</h2>
                        <button type="button" class="cerrarModal close"><i class="fa-solid fa-xmark"></i></button>
                    </header>
                    <textarea style="height: 4rem;" id="theme" class="textarea textareaT" name="nameTopic" placeholder="Tema" readonly></textarea>
                    <textarea id="subjectRelevance" class="textarea textareaT" name="subjectRelevance" placeholder="Es pertinente para la materia" readonly></textarea>
                    <img class="uploaded-image-g" src="" alt="">
                    <img class="uploaded-image-l" src="" alt="">
                    <textarea id="updatedInformation" class="textarea textareaT" name="updatedInformation" placeholder="Existe información actualizada sobre el tema" readonly></textarea>
                    <textarea id="localRelevance" class="textarea textareaT" name="localRelevance" placeholder="Qué tan pertinente es el tema localmente" readonly></textarea>
                    <textarea id="globalRelevance" class="textarea textareaT" name="globalRelevance" placeholder="Qué tan pertinente es el tema geográficamente" readonly></textarea>
                </div>
            </div>
        @else
            <section class="nextTopic">
                <div class="topics">
                    <strong><h2>Temas de investigación</h2></strong>
                    <button type="button" id="btnAddTopic" class="btn"><i class="fa-solid fa-square-plus"></i> Agregar</button>
                </div>
                <div>
                    @if($topics->isEmpty())
                        <h3 class="empty">No haz propuesto <strong>Temas de Investigación</strong></h3>
                    @else
                        <table id="data-table-topics" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Tema</th>
                                    <th>Relevancia</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topics as $topic)
                                    <tr>
                                        <td data-values="Tema"><p>{{ $topic->nameTopic }}</p></td>
                                        <td data-values="Tema"><p>{{ $topic->subjectRelevance }}</p></td>
                                        <td data-values="Estado">
                                            <h4 style="font-weight: 100;">{{ $topic->state}}</h4>
                                        </td>
                                        <td data-values="Acciones">
                                            @if($topic->state !== 'Aprobado')
                                                <button type="button" class="btn btn-edit" data-modal="editarModalTopic" data-topicId="{{ $topic->topicId }}" 
                                                    data-nameTopic="{{ $topic->nameTopic }}" data-description="{{ $topic->description }}" data-subjectRelevance="{{ $topic->subjectRelevance }}" data-globalUpdateImg="{{ $topic->globalUpdateImg }}"
                                                    data-localUpdateImg="{{ $topic->localUpdateImg }}" data-updatedInformation="{{ $topic->updatedInformation }}" data-localRelevance="{{ $topic->localRelevance }}" 
                                                    data-globalRelevance="{{ $topic->globalRelevance }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-delete" data-modal="eliminarModalTopic" data-topicId="{{ $topic->topicId }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <!-- Modal -->
                <div id="myModalTopic" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo tema propuesto</h2>
                            <button type="button" id="cerrarModalTopic"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formTopic" action="{{ route('topic.create') }}" method="POST" class="basic-information" enctype="multipart/form-data">
                            @csrf
                            <textarea class="textarea textareaTopicA" name="nameTopic" placeholder="Tema" maxlength="200"></textarea>
                            <textarea class="textarea textareaTopicA" name="description" placeholder="Descripción" maxlength="500"></textarea>
                            <textarea class="textarea textareaTopicA" name="subjectRelevance" placeholder="Es pertinente para la materia" maxlength="500"></textarea>
                            <div class="container file-container" id="container">
                                <input type="file" name="Imagen-Importancia-Global" class="file-input" accept="image/png, image/jpeg" hidden>
                                <div class="img-area" data-img="">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h4>Importancia Global</h4>
                                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                    <img id="uploadedImage" src="" alt="Imagen previa" style="display: none;">
                                </div>
                            </div>
                            <div class="container file-container" id="container2">
                                <input type="file" name="Imagen-Importancia-Local" class="file-input" accept="image/png, image/jpeg" hidden>
                                <div class="img-area" data-img="">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h4>Importancia Local</h4>
                                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                    <img id="uploadedImage" src="" alt="Imagen previa" style="display: none;">
                                </div>
                            </div>
                            <textarea class="textarea textareaTopicA" name="updatedInformation" placeholder="Existe información actualizada sobre el tema" maxlength="400"></textarea>
                            <textarea class="textarea textareaTopicA" name="localRelevance" placeholder="Qué tan pertinente es el tema localmente" maxlength="400"></textarea>
                            <textarea class="textarea textareaTopicA" name="globalRelevance" placeholder="Qué tan pertinente es el tema geográficamente" maxlength="500"></textarea>
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idNextIdcTopicReport" type="text" hidden value="{{ $idNextIdcTopicReport }}">
                            <div id="notificationT" class="notificationM"></div>
                            <button type="submit" class="btn" id="submitAddTopic">Agregar</button>
                        </form>
                    </div>
                </div>
                <!-- Edit topic modal -->
                <div id="editarModalTopic" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos del tema</h2>
                            <button type="button" class="cerrarModal close"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formTopicEdit" action="{{ route('topic.edit') }}" method="POST" class="basic-information" enctype="multipart/form-data">
                            @csrf
                            <textarea id="theme" class="textarea textareaT" name="nameTopic" placeholder="Tema"></textarea>
                            <textarea id="description" class="textarea textareaT" name="description" placeholder="Descripción"></textarea>
                            <textarea id="subjectRelevance" class="textarea textareaT" name="subjectRelevance" placeholder="Es pertinente para la materia"></textarea>
                            <h2>Importancia Global</h2>
                            <div class="container file-container" id="container3">
                                <input type="file" name="Importancia-Global" class="file-input" accept="image/png, image/jpeg" hidden>
                                <div class="img-area" data-img="">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h4>Importancia Global</h4>
                                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                    <img id="uploadedImage" class="uploaded-image-g" src="" alt="Imagen previa" style="display: none;">
                                </div>
                            </div>
                            <h2>Importancia Local</h2>
                            <div class="container file-container" id="container4">
                                <input type="file" name="Importancia-Local" class="file-input" accept="image/png, image/jpeg" hidden>
                                <div class="img-area" data-img="">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h4>Importancia Local</h4>
                                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                    <img id="uploadedImage" class="uploaded-image-l" src="" alt="Imagen previa" style="display: none;">
                                </div>
                            </div>
                            <textarea id="updatedInformation" class="textarea textareaT" name="updatedInformation" placeholder="Existe información actualizada sobre el tema"></textarea>
                            <textarea id="localRelevance" class="textarea textareaT" name="localRelevance" placeholder="Qué tan pertinente es el tema localmente"></textarea>
                            <textarea id="globalRelevance" class="textarea textareaT" name="globalRelevance" placeholder="Qué tan pertinente es el tema geográficamente"></textarea>
                            <input id="topicId" name="topicId" type="text" hidden>
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idNextIdcTopicReport" type="text" hidden value="{{ $idNextIdcTopicReport }}">
                            <div id="notificationTE" class="notificationM"></div>
                            <button type="submit" class="btn" id="submitButtonTopicEdit">Agregar</button>
                        </form>
                    </div>
                </div>
                <!-- Delete topic modal -->
                <div class="modal" id="eliminarModalTopic">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar el tema?</h2>
                            <button type="button" class="close cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDelete">
                            <form id="formTopicDelete" action="{{ route('topic.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="topicId" id="topicTId" autocomplete="off">
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idNextIdcTopicReport" type="text" hidden value="{{ $idNextIdcTopicReport }}">
                                <button class="btn">Eliminar</button>
                            </form>
                            <button class="btn close">Cancelar</button>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection

@section('scripts')
    @if(session('role') === 'Docente')
        <script src=" {{ asset('js/nextIdcTopicReport.js') }}"></script>
    @elseif(session('role') === 'Estudiante')
        <script src=" {{ asset('js/nextIdcTopicReportStudent.js') }}"></script>
    @endif
@endsection