@extends('layout')

@section('title')
    Informe y ordenamiento de búsqueda del tema
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/topicSearchReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1 class="head-lbl">{{ $topicSearchReport->themeName }} - Equipo #{{ $topicSearchReport->teamId}} - Informe y ordenamiento de búsqueda del tema</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis investigaciones</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $topicSearchReport->researchTopicId, 'subjectId' => $topicSearchReport->subjectId]) }}">{{ $topicSearchReport->code}}</a>
                <a class="history-view" href="{{ route('stagesProcess', ['researchTopicId' => $topicSearchReport->researchTopicId, 
                    'teamId' => $topicSearchReport->teamId, 'idcId' => $topicSearchReport->idcId]) }}">Etapas del proceso
                </a>
                <a class="history-view" href="{{ route('searchInformation', ['idcId' => $idcId, 
                        'idTopicSearchReport' => $idTopicSearchReport]) }}">Estatus del informe
                </a>
                <a class="history-view" href="">Informe y ordenamiento de búsqueda del tema</a>
            </nav>
        </div>
        @if($role === 'Docente')
            <form id="myForm" class="source-content" action="{{ route('generate-word') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="first-section">
                    <strong><h2>Orientación del equipo</h2></strong>
                    <textarea class="textarea" id="editor" name="orientation" placeholder="Organización del equipo" min="600" maxlength="800"></textarea>
                    <textarea class="textarea" name="induction" placeholder="Inducción del tema" min="950" maxlength="1150"></textarea>
                </div>
                <div class="second-section">
                    <strong><h2>Plan de búsqueda de información</h2></strong>
                    <textarea class="textarea" name="searchPlan" placeholder="Plan de búsqueda" min="600" maxlength="700"></textarea>
                    <div class="container file-container" id="container3">
                        <input type="file" name="Imagen-Diagrama" class="file-input" accept="image/png, image/jpeg" hidden>
                        <div class="img-area" data-img="">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <h4>Diagrama Temas Explorados</h4>
                            <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                            <img id="uploadedImage" src="" alt="Imagen previa" style="display: none;">
                        </div>
                    </div>
                </div>
                <div class="third-section">
                    <strong><h2>Reuniones y objetivos</h2></strong>
                    <textarea class="textarea" name="meetings" placeholder="Resumen de reuniones" min="400" maxlength="500"></textarea>
                    <table id="data-table-objetivesG" class="table content-table">
                        <thead>
                            <tr>
                                <th>Contribuyente</th>
                                <th>Objetivo general</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($objetivesG as $objetive)
                                <tr>
                                    <td data-values="Contribuyente">{{ $objetive->studentContribute }}</td>
                                    <td data-values="Objetivo general">{{ $objetive->objetive }}</td>
                                    <td data-values="Estado">
                                        @if($objetive->state !== 'Aprobado')
                                            <button type="button" id="aprobarObjetiveG" class="btn btn-aproved-objetiveG" 
                                                data-values="{{ $objetive->objetiveId }}">Aprobar
                                            </button>
                                            <h4 style="font-weight: 100; display: none" 
                                                id="state-general-{{ $objetive->objetiveId }}">{{ $objetive->state }}
                                            </h4>   
                                        @else
                                            <h4 style="font-weight: 100;">{{ $objetive->state }}</h4>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table id="data-table-objetivesE" class="table content-table">
                        <thead>
                            <tr>
                                <th>Contribuyente</th>
                                <th>Objetivo especifico</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($objetivesE as $objetive)
                                <tr>
                                    <td data-values="Contribuyente">{{ $objetive->studentContribute }}</td>
                                    <td data-values="Objetivo especifico">{{ $objetive->objetive }}</td>
                                    <td data-values="Estado">
                                        @if($objetive->state !== 'Aprobado')
                                            <button type="button" class="btn btn-aproved-objetiveE" 
                                                data-values="{{ $objetive->objetiveId }}">Aprobar
                                            </button>
                                            <h4 style="font-weight: 100; display: none" 
                                                id="state-specific-{{ $objetive->objetiveId }}">{{ $objetive->state }}
                                            </h4>   
                                        @else
                                            <h4 style="font-weight: 100;">{{ $objetive->state }}</h4>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="fourth-section">
                    <strong><h2>Tabla de volcado de información</h2></strong>
                    <textarea class="textarea" name="criteria" placeholder="Criterios de selección de la información" min="250" maxlength="350"></textarea>
                    <table id="data-table-sources" class="table content-table export-table">
                        <thead>
                            <tr>
                                <th>Contribuyente</th>
                                <th>Tema</th>
                                <th>Año</th>
                                <th>Tipo de medio</th>
                                <th>Enlace</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <td data-values="Contribuyente">{{ $source->studentContribute }}</td>
                                    <td data-values="Tema">{{ $source->theme }}</td>
                                    <td data-values="Año">{{ $source->year }}</td>
                                    <td data-values="Tipo de medio">{{ $source->averageType }}</td>
                                    <td data-values="Link"><a href="{{ $source->link }}" target="_blank" rel="noreferrer" class="link">{{ $source->link }}</a></td>
                                    <td data-values="Estado">
                                        @if($source->state !== 'Aprobado')
                                            <button type="button" class="btn btn-aproved-source" data-values="{{ $source->bibliographicSourceId }}">
                                                Aprobar
                                            </button>
                                            <h4 style="font-weight: 100; display: none" 
                                                id="state-source-{{ $source->bibliographicSourceId }}">{{ $source->state }}
                                            </h4>   
                                        @else 
                                            <h4 style="font-weight: 100;">{{ $source->state}}</h4>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="fifth-content">
                    <strong><h2>Valoración del equipo</h2></strong>
                    <textarea class="textarea" name="teamValoration" placeholder="Valoración del catedrático sobre el equipo" min="650" maxlength="800"></textarea>
                    @foreach($students as $student)
                        <h2><strong>{{ $student->name }}</strong></h2>
                        <table id="data-table-criteria" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Criterios de evaluacion</th>
                                    <th>Calificación (1 - 10)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-values="Criterio">El estudiante ha sido responsable con el proceso.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-1" maxlength="2" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td data-values="Criterio">Ha participado de las reuniones con puntualidad.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-2" maxlength="2" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td data-values="Criterio">Ha Evidenciado interés por el proceso.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-3" maxlength="2" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td data-values="Criterio">Se ha apropiado de la temática.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-4" maxlength="2" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td data-values="Criterio">Realimenta y exterioriza sus comentarios, dudas y reflexiones personales.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-5" maxlength="2" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td data-values="Criterio">El estudiante es capaz de autogestionar su conocimiento y el proceso, mejorando su desempeño y capacidad de análisis.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-6" maxlength="2" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td data-values="Criterio">El estudiante ha desarrollado cada una de las actividades asignadas con diligencia y esmero.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-7" maxlength="2" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td data-values="Criterio">El estudiante ha elevado su dominio sobre el tema.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-8" maxlength="2" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td data-values="Criterio">El estudiante ha contribuido al resultado esperado en términos de volumen y calidad.</td>
                                    <td data-values="Calificación"><input type="text" class="calification" name="Criterio-{{ $student->name }}-9" maxlength="2" autocomplete="off"></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="text" name="{{ $student->name }}" hidden value="{{ $student->name }}">
                    @endforeach
                </div>
                <div class="sixth-content">
                    <strong><h2>Comentario final</h2></strong>
                    <textarea id="finalComment" class="textarea" name="finalComment" placeholder="Comentario final" min="850" maxlength="1000"></textarea>
                </div>
                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                <button type="submit" class="btn">Generar Documento</button>
            </form>
            <div id="notification" class="notification"></div>
        @else
            <div class="source-content">
                <div class="fuentes">
                    <strong><h2>Fuentes bibliográficas</h2></strong>
                    <button type="button" id="btnAddInfo" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
                </div>
                <div>
                    <table id="data-table-sources" class="table content-table">
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Autor</th>
                                <th>Tema</th>
                                <th>Tipo de medio</th>
                                <th>Enlace</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <td data-values="Año">{{ $source->year }}</td>
                                    <td data-values="Autor">{{ $source->author }}</td>
                                    <td data-values="Tema">{{ $source->theme }}</td>
                                    <td data-values="Tipo de medio">{{ $source->averageType }}</td>
                                    <td data-values="Enlace"><a href="{{ $source->link }}" target="_blank" rel="noreferrer" class="link">{{ $source->link }}</a></td>
                                    <td data-values="Estado">{{ $source->state }}</td>
                                    <td data-values="Acciones">
                                        @if($source->state !== 'Aprobado')
                                            <button type="button" class="btn btn-edit" data-modal="editarModalSource" data-bibliographicSourceid="{{ $source->bibliographicSourceId }}"
                                                data-year="{{ $source->year }}" data-author="{{ $source->author }}" data-theme="{{ $source->theme }}"
                                                data-averageType="{{ $source->averageType }}" data-source="{{ $source->source }}" data-link="{{ $source->link }}" data-state="{{ $source->state }}"
                                            >
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-delete" data-modal="eliminarModalSource" 
                                                data-bibliographicSourceid="{{ $source->bibliographicSourceId }}"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal add Source -->
                    <div id="myModalInfo" class="modal">
                        <div class="modal-content">
                            <header class="head">
                                <h2>Nueva fuente bibliográfica</h2>
                                <button type="button" id="cerrarModalInfo"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <form id="formSourceCreate" action="{{ route('source.create') }}" method="POST" class="basic-information">
                                @csrf
                                <input class="year" name="year" id="año" placeholder="Año" autocomplete="off" maxlength="4">
                                <textarea class="textarea" name="author" id="autor" placeholder="Autor" autocomplete="off" maxlength="400"></textarea>
                                <textarea class="textarea" name="theme" id="fuente" placeholder="Tema" autocomplete="off" maxlength="100"></textarea>
                                <textarea class="textarea" name="averageType" id="tipoMedio" placeholder="Tipo de medio" autocomplete="off" maxlength="150"></textarea>
                                <textarea class="textarea" name="link" id="enlace" placeholder="Enlace" autocomplete="off" maxlength="1000"></textarea>
                                <textarea class="textarea" name="source" id="fuente" placeholder="Fuente" autocomplete="off" maxlength="100"></textarea>
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                <div id="notificationS" class="notificationM"></div>
                                <button type="submit" class="btn" id="submitButtonSourceCreate">Agregar</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal edit Source -->
                    <div id="editarModalSource" class="modal">
                        <div class="modal-content">
                            <header class="head">
                                <h2>Datos de la fuente bibliográfica</h2>
                                <button type="button" class="close cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <form id="formSourceEdit" action="{{ route('source.edit') }}" method="POST" class="basic-information">
                                @csrf
                                <input class="year" name="year" id="year" placeholder="Año" autocomplete="off" maxlength="4">
                                <textarea class="textarea textareaEdit" name="author" id="author" placeholder="Autor" autocomplete="off" maxlength="400"></textarea>
                                <textarea class="textarea textareaEdit" name="theme" id="theme" placeholder="Tema" autocomplete="off" maxlength="100"></textarea>
                                <textarea class="textarea textareaEdit" name="averageType" id="averageType" placeholder="Tipo de medio" autocomplete="off" maxlength="150"></textarea>
                                <textarea class="textarea textareaEdit" name="link" id="link" placeholder="Enlace" autocomplete="off" maxlength="1000"></textarea>
                                <textarea class="textarea textareaEdit" name="source" id="source" placeholder="Fuente" autocomplete="off" maxlength="100"></textarea>
                                <input hidden type="text" name="sourceId" id="bibliographicSourceId" autocomplete="off">
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                <div id="notificationSE" class="notificationM"></div>
                                <button type="submit" class="btn" id="submitButtonSourceEdit">Agregar</button>
                            </form>
                        </div>
                    </div>
                    <!-- Delete source modal -->
                    <div class="modal" id="eliminarModalSource">
                        <div class="modal-content">
                            <header class="head">
                                <h2>¿Realmente deseas eliminar la fuente bibliográfica?</h2>
                                <button type="button" class="close cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <div class="optionDelete">
                                <form action="{{ route('source.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input hidden type="text" name="sourceId" id="bibliographicSourceEId">
                                    <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                    <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                    <button class="btn">Eliminar</button>
                                </form>
                                <button class="btn close">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fuentes">
                    <strong><h2>Objetivo general</h2></strong>
                    <button id="btnAddObjetivoGeneral" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
                </div>
                <div id="myModalObjetivoGeneral" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo objetivo general</h2>
                            <button type="button" id="cerrarModalObjetivoGeneral"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formObjetiveG" action="{{ route('objetive.create') }}" method="POST" class="basic-information">
                            @csrf
                            <textarea id="objetivoGeneral" class="textarea textareaOG" name="objetive" placeholder="Objetivo general"></textarea>
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                            <input name="type" type="text" hidden value="General">
                            <div id="notificationOG" class="notificationM"></div>
                            <button type="submit" class="btn" id="submitButtonObjetiveG">Agregar</button>
                        </form>
                    </div>
                </div>
                <table id="data-table-objetivesG" class="table content-table">
                    <thead>
                        <tr>
                            <th>Objetivo general</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($objetivesG as $objetive)
                            <tr>
                                <td data-values="Objetivo general">{{ $objetive->objetive }}</td>
                                <td data-values="Estado">{{ $objetive->state }}</td>
                                <td data-values="Acciones">
                                    @if($objetive->state !== 'Aprobado')
                                        <button type="button" class="btn btn-edit" data-modal="editarModalObjetiveG" data-objetiveId="{{ $objetive->objetiveId }}" 
                                            data-objetive="{{ $objetive->objetive }}" data-state="{{ $objetive->state }}"
                                        >
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-delete" data-modal="eliminarModalObjetiveG" data-objetiveId="{{ $objetive->objetiveId }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Edit general objetive modal -->
                <div id="editarModalObjetiveG" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos objetivo general</h2>
                            <button type="button" class="cerrarModal close"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formObjetiveGEdit" action="{{ route('objetive.edit') }}" method="POST" class="basic-information">
                            @csrf
                            <textarea id="generalObjetive" class="textarea textareaOG" name="objetive" placeholder="Objetivo general"></textarea>
                            <input hidden type="text" name="objetiveId" id="objetiveGGId" autocomplete="off">
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                            <input name="type" type="text" hidden value="General">
                            <div id="notificationOGEdit" class="notificationM"></div>
                            <button type="submit" class="btn" id="submitButtonObjetiveGEdit">Agregar</button>
                        </form>
                    </div>
                </div>
                <!-- Delete general objetive modal -->
                <div class="modal" id="eliminarModalObjetiveG">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar el objetivo general?</h2>
                            <button type="button" class="close cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDelete">
                            <form action="{{ route('objetive.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="objetiveId" id="objetiveGId" autocomplete="off">
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                <button class="btn">Eliminar</button>
                            </form>
                            <button class="btn close">Cancelar</button>
                        </div>
                    </div>
                </div>
                <div class="fuentes">
                    <strong><h2>Objetivos especifícos</h2></strong>
                    <button id="btnAddObjetivoEspecifico" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
                </div>
                <div id="myModalObjetivoEspecifico" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo objetivo especifíco</h2>
                            <button type="button" id="cerrarModalObjetivoEspecifico"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formObjetiveE" action="{{ route('objetive.create') }}" method="POST" class="basic-information">
                            @csrf
                            <textarea id="objetivoEspecifico" class="textarea textareaOE" name="objetive" placeholder="Objetivo especifíco"></textarea>
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                            <input name="type" type="text" hidden value="Especifico">
                            <div id="notificationOE" class="notificationM"></div>
                            <button type="submit" class="btn" id="submitButtonObjetiveE">Agregar</button>
                        </form>
                    </div>
                </div>
                <table id="data-table-objetivesE" class="table content-table">
                    <thead>
                        <tr>
                            <th>Objetivo específico</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($objetivesE as $objetive)
                                <td data-values="Objetivo específico">{{ $objetive->objetive }}</td>
                                <td data-values="Estado">{{ $objetive->state }}</td>
                                <td data-values="Acciones">
                                    @if($objetive->state !== 'Aprobado')
                                        <button type="button" class="btn btn-edit" data-modal="editarModalObjetiveE" data-objetiveId="{{ $objetive->objetiveId }}" 
                                            data-objetive="{{ $objetive->objetive }}" data-state="{{ $objetive->state }}"
                                        >
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-delete" data-modal="eliminarModalObjetiveE" data-objetiveId="{{ $objetive->objetiveId }}" 
                                            data-objetive="{{ $objetive->objetive }}" data-state="{{ $objetive->state }}"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Edit specific objetive modal -->
                <div id="editarModalObjetiveE" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos objetivo específico</h2>
                            <button type="button" class="cerrarModal close"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formObjetiveEEdit" action="{{ route('objetive.edit') }}" method="POST" class="basic-information">
                            @csrf
                            <textarea id="specificObjetive" class="textarea textareaOE" name="objetive" placeholder="Objetivo específico"></textarea>
                            <input hidden type="text" name="objetiveId" id="objetiveEEId" autocomplete="off">
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                            <input name="type" type="text" hidden value="General">
                            <div id="notificationOEEdit" class="notificationM"></div>
                            <button type="submit" class="btn" id="submitButtonObjetiveEEdit">Agregar</button>
                        </form>
                    </div>
                </div>
                <!-- Delete specific objetive modal -->
                <div class="modal" id="eliminarModalObjetiveE">
                    <div class="modal-content">
                        <header class="head">
                            <h2>¿Realmente deseas eliminar el objetivo específico?</h2>
                            <button type="button" class="close cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="optionDelete">
                            <form action="{{ route('objetive.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="objetiveId" id="objetiveEId" autocomplete="off">
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                <button class="btn">Eliminar</button>
                            </form>
                            <button class="btn close">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
@endsection

@section('scripts')
    @if(session('role') === 'Docente')
        <script src="{{ asset('js/topicSearchReport.js') }}"></script>
    @elseif(session('role') === 'Estudiante')
        <script src="{{ asset('js/topicSearchReportStudent.js') }}"></script>
    @endif
@endsection