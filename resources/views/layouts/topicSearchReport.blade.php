@extends('layout')

@section('title')
    Informe de Búsqueda de Información
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/topicSearchReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="head-content">
            <h1>Datos del informe y ordenamiento de búsqueda del tema</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
                <a class="view" href="">Tema</a>
                <a class="view" href=""> Etapas </a>
            </nav>
        </div>
        @if($role === 'Docente')
            <form id="myForm" class="source-content" action="{{ route('generate-word') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="first-section">
                    <strong><h2>Orientación del equipo</h2></strong>
                    <textarea class="textarea" name="orientation" placeholder="Organización del equipo">{{ old('orientation') }}</textarea>
                    <textarea class="textarea" name="induction" placeholder="Inducción del tema">{{ old('induction') }}</textarea>
                </div>
                <div class="second-section">
                    <strong><h2>Plan de búsqueda de información</h2></strong>
                    <textarea class="textarea" name="searchPlan" placeholder="Plan de búsqueda"></textarea>
                    <div class="container file-container" id="container3">
                        <input type="file" name="imageDiagram" class="file-input" accept="image/*" hidden>
                        <div class="img-area" data-img="">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <h4>Diagrama (Temas explorados)</h4>
                            <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                        </div>
                    </div>
                </div>
                <div class="fourth-section">
                    <strong><h2>Reuniones y objetivos</h2></strong>
                    <textarea class="textarea" name="meetings" placeholder="Resumen de reuniones"></textarea>
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
                                            <form class="ajax-form" action="{{ route('objetiveG.update', ['idObjetive' => $objetive->objetiveId]) }}" method="GET">
                                                @csrf
                                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                                <button type="button" id="aprobarObjetiveG" class="btn btn-aprobar">Aprobar</button>
                                            </form>
                                        @else
                                            <h6 class="state">{{ $objetive->state }}</h6>
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
                                            <form class="ajax-form" action="{{ route('objetiveE.update', ['idObjetive' => $objetive->objetiveId]) }}" method="GET">
                                                @csrf
                                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                                <button class="btn btn-aprobar">Aprobar</button>
                                            </form>
                                        @else
                                            <h6 class="state">{{ $objetive->state }}</h6>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="third-section">
                    <strong><h2>Tabla de volcado de información</h2></strong>
                    <textarea class="textarea" name="criteria" placeholder="Criterios de selección de la información"></textarea>
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
                                            <form class="ajax-form" action="{{ route('source.update', ['idSource' => $source->bibliographicSourceId]) }}" method="GET">
                                                @csrf
                                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                                <button class="btn btn-aprobar">Aprobar</button>
                                            </form>
                                        @else
                                            <h6 class="state">{{ $source->state }}</h6>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="fifth-content">
                    <strong><h2>Valoración del equipo</h2></strong>
                    <textarea class="textarea" name="teamValoration" placeholder="Valoración del catedrático sobre el equipo"></textarea>
                    <table id="data-table" class="table content-table">
                        <thead>
                            <tr>
                                <th>Criterios de evaluacion</th>
                                <th>Calificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-values="Criterio">El estudiante ha sido responsable con el proceso.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification" maxlength="2"></td>
                            </tr>
                            <tr>
                                <td data-values="Criterio">Ha participado de las reuniones con puntualidad.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification2" maxlength="2"></td>
                            </tr>
                            <tr>
                                <td data-values="Criterio">Ha Evidenciado interés por el proceso.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification3" maxlength="2"></td>
                            </tr>
                            <tr>
                                <td data-values="Criterio">Se ha apropiado de la temática.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification4" maxlength="2"></td>
                            </tr>
                            <tr>
                                <td data-values="Criterio">Realimenta y exterioriza sus comentarios, dudas y reflexiones personales.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification5" maxlength="2"></td>
                            </tr>
                            <tr>
                                <td data-values="Criterio">El estudiante es capaz de autogestionar su conocimiento y el proceso, mejorando su desempeño y capacidad de análisis.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification6" maxlength="2"></td>
                            </tr>
                            <tr>
                                <td data-values="Criterio">El estudiante ha desarrollado cada una de las actividades asignadas con diligencia y esmero.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification7" maxlength="2"></td>
                            </tr>
                            <tr>
                                <td data-values="Criterio">El estudiante ha elevado su dominio sobre el tema.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification8" maxlength="2"></td>
                            </tr>
                            <tr>
                                <td data-values="Criterio">El estudiante ha contribuido al resultado esperado en términos de volumen y calidad.</td>
                                <td data-values="Calificación"><input type="text" class="calification" name="calification9" maxlength="2"></td>
                            </tr>
                        </tbody>
                    </table>
                    <textarea class="textarea" name="teamComment" placeholder="Comentarios sobre el equipo"></textarea>
                </div>
                <div class="sixth-content">
                    <strong><h2>Comentario final</h2></strong>
                    <textarea id="finalComment" class="textarea" name="finalComment" placeholder="Comentario final"></textarea>
                </div>
                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                <button type="submit" class="btn">Generar Documento</button>
            </form>
        @else
            <div class="source-content">
                <div class="fuentes">
                    <strong><h2>Fuentes bibliográficas</h2></strong>
                    <button type="button" id="btnAddInfo" class="btn">Nueva Fuente</button>
                </div>
                <!-- Modal -->
                <div id="myModalInfo" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nueva fuente bibliográfica</h2>
                            <button type="button" id="cerrarModalInfo"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form action="{{ route('source.create') }}" method="POST" class="basic-information">
                            @csrf
                            <input type="text" name="year" id="año" placeholder="Año" autocomplete="off">
                            <input type="text" name="author" id="autor" placeholder="Autor" autocomplete="off">
                            <input type="text" name="theme" id="fuente" placeholder="Tema" autocomplete="off">
                            <input type="text" name="averageType" id="tipoMedio" placeholder="Tipo de medio" autocomplete="off">
                            <input type="text" name="link" id="enlace" placeholder="Enlace" autocomplete="off">
                            <input type="text" name="source" id="enlace" placeholder="Fuente" autocomplete="off">
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                            <button type="submit" class="btn" id="submitButton">Agregar</button>
                        </form>
                    </div>
                </div>
                <div>
                    <table id="data-table-sources" class="table content-table">
                        <thead>
                            <tr>
                                <th>Contribuyente</th>
                                <th>Año</th>
                                <th>Autor</th>
                                <th>Tema</th>
                                <th>Tipo de medio</th>
                                <th>Enlace</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <td data-values="Contribuyente">{{ $source->studentContribute }}</td>
                                    <td data-values="Año">{{ $source->year }}</td>
                                    <td data-values="Autor">{{ $source->author }}</td>
                                    <td data-values="Tema">{{ $source->theme }}</td>
                                    <td data-values="Tipo de medio">{{ $source->averageType }}</td>
                                    <td data-values="Enlace"><a href="{{ $source->link }}" target="_blank" rel="noreferrer" class="link">{{ $source->link }}</a></td>
                                    <td data-values="Estado">Aprobado</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="fuentes">
                    <strong><h2>Objetivo General</h2></strong>
                    <button id="btnAddObjetivoGeneral" class="btn">Nuevo Objetivo</button>
                </div>
                <div id="myModalObjetivoGeneral" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo objetivo general</h2>
                            <button type="button" id="cerrarModalObjetivoGeneral"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="basic-information">
                            <form action="{{ route('objetive.create') }}" method="POST">
                                @csrf
                                <textarea id="objetivoGeneral" class="textarea" name="objetive" placeholder="Objetivo general"></textarea>
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                <input name="type" type="text" hidden value="General">
                                <button type="submit" class="btn" id="submitButton">Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>
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
                                <td data-values="Estado">{{ $objetive->state }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="fuentes">
                    <strong><h2>Objetivos Especifícos</h2></strong>
                    <button id="btnAddObjetivoEspecifico" class="btn">Nuevo Objetivo</button>
                </div>
                <div id="myModalObjetivoEspecifico" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo objetivo especifíco</h2>
                            <button type="button" id="cerrarModalObjetivoEspecifico"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <div class="basic-information">
                            <form action="{{ route('objetive.create') }}" method="POST">
                                @csrf
                                <textarea id="objetivoGeneral" class="textarea" name="objetive" placeholder="Objetivo especifíco"></textarea>
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idTopicSearchReport" type="text" hidden value="{{ $idTopicSearchReport }}">
                                <input name="type" type="text" hidden value="Especifico">
                                <button type="submit" class="btn" id="submitButton">Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>
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
                                <td data-values="Estado">{{ $objetive->state }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <script>
                // Función para mostrar un modal
                function showModal(modal) {
                    modal.style.display = 'block';
                }

                // Función para cerrar un modal
                function closeModal(modal) {
                    modal.style.display = 'none';
                }

                // Obtén referencias a los elementos relevantes
                var modals = {
                    info: document.getElementById('myModalInfo'),
                    objetivoGeneral: document.getElementById('myModalObjetivoGeneral'),
                    objetivoEspecifico: document.getElementById('myModalObjetivoEspecifico')
                };

                var btns = {
                    addInfo: document.getElementById('btnAddInfo'),
                    addObjetivoGeneral: document.getElementById('btnAddObjetivoGeneral'),
                    addObjetivoEspecifico: document.getElementById('btnAddObjetivoEspecifico')
                };

                var closeBtns = {
                    info: document.getElementById('cerrarModalInfo'),
                    objetivoGeneral: document.getElementById('cerrarModalObjetivoGeneral'),
                    objetivoEspecifico: document.getElementById('cerrarModalObjetivoEspecifico')
                };

                // Funciones para mostrar y cerrar modales al hacer clic
                function handleModalClick(event, modal) {
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                }

                function handleAddButtonClick(modal) {
                    return function () {
                        showModal(modal);
                    };
                }

                function handleCloseButtonClick(modal) {
                    return function () {
                        closeModal(modal);
                    };
                } 

                // Asignar eventos
                btns.addInfo.addEventListener('click', handleAddButtonClick(modals.info));
                btns.addObjetivoGeneral.addEventListener('click', handleAddButtonClick(modals.objetivoGeneral));
                btns.addObjetivoEspecifico.addEventListener('click', handleAddButtonClick(modals.objetivoEspecifico));

                closeBtns.info.addEventListener('click', handleCloseButtonClick(modals.info));
                closeBtns.objetivoGeneral.addEventListener('click', handleCloseButtonClick(modals.objetivoGeneral));
                closeBtns.objetivoEspecifico.addEventListener('click', handleCloseButtonClick(modals.objetivoEspecifico));
            </script>
        @endif
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/topicSearchReport.js') }}"></script>
@endsection