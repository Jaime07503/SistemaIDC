@extends('layout')

@section('title')
    Artículo de revisión bibliográfica
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/scientificArticleReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1 class="head-lbl">{{ $scientificArticleReport->themeName }} - Equipo #{{ $scientificArticleReport->teamId}} - Artículo de revisión bibliográfica</h1>
            <nav class="history">
                <a class="history-view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="history-view">Mis investigaciones</a>
                <a class="history-view" href="{{ route('researchTopicInformation', ['researchTopicId' => $scientificArticleReport->researchTopicId, 'subjectId' => $scientificArticleReport->subjectId]) }}">{{ $scientificArticleReport->code}}</a>
                <a class="history-view" href="{{ route('stagesProcess', ['researchTopicId' => $scientificArticleReport->researchTopicId, 
                    'teamId' => $scientificArticleReport->teamId, 'idcId' => $scientificArticleReport->idcId]) }}">Etapas del proceso
                </a>
                <a class="history-view" href="{{ route('scientificArticle', ['idcId' => $idcId, 
                    'idScientificArticleReport' => $idScientificArticleReport]) }}">Estatus del informe
                </a>
                <a class="history-view" href="">Artículo de revisión bibliográfica</a>
            </nav>
        </header>
        @if($role === 'Docente')
            <section class="scientific-article-content">
                <form id="myForm" class="scientific-article" action="{{ route('generate-scientific-article') }}" method="POST">
                    @csrf
                    <div class="first-section">
                        <strong><h2>Resúmenes</h2></strong>
                        <textarea class="textarea" name="spanishSummary" placeholder="Resumen en español"></textarea>
                        <textarea class="textarea" name="englishSummary" placeholder="Resumen en inglés"></textarea>
                        <textarea class="textarea" name="keywords" placeholder="Palabras clave"></textarea>
                    </div>
                    <div class="second-section">
                        <strong><h2>Introducción</h2></strong>
                        <textarea class="textarea" name="introduction" placeholder="Introducción"></textarea>
                        <textarea class="textarea" name="methodology" placeholder="Metodología"></textarea>
                    </div>
                    <div class="third-section">
                        <strong><h2>Desarrollo del tema</h2></strong>
                        <table id="data-table-contribute" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Contribuyente</th>
                                    <th>Sub-Título</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contents as $content)
                                    <tr>
                                        <td data-values="Contribuyente">{{ $content->studentContribute }}</td>
                                        <td data-values="Sub-Título">{{ $content->title }}</td>
                                        <td data-values="Estado">
                                            @if($content->state !== 'Aprobado')
                                                <button type="button" class="btn btn-aproved-development" 
                                                    data-values="{{ $content->developmentId }}">Aprobar
                                                </button>
                                                <h4 style="font-weight: 100; display: none" class="stateContribute" 
                                                    id="state-contribute-{{ $content->developmentId }}">{{ $content->state }}
                                                </h4>   
                                            @else
                                                <h4 class="state">{{ $content->state }}</h4>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="fourth-section">
                        <strong><h2>Conclusiones</h2></strong>
                        <table id="data-table-conclusion" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Contribuyente</th>
                                    <th>Conclusión</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($conclusions as $conclusion)
                                    <tr>
                                        <td data-values="Contribuyente">{{ $conclusion->studentContribute }}</td>
                                        <td data-values="Conclusión">{{ $conclusion->conclusion }}</td>
                                        <td data-values="Estado">
                                            @if($conclusion->state !== 'Aprobado')
                                                <button type="button" class="btn btn-aproved-conclusion" 
                                                    data-values="{{ $conclusion->conclusionId }}">Aprobar
                                                </button>
                                                <h4 style="font-weight: 100; display: none" class="stateContribute" 
                                                    id="state-conclusion-{{ $conclusion->conclusionId }}">{{ $conclusion->state }}
                                                </h4>   
                                            @else
                                                <h4 class="state">{{ $conclusion->state }}</h4>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="fifth-section">
                        <strong><h2>Referencias bibliográficas</h2></strong>
                        <table id="data-table-reference" class="table content-table">
                            <thead>
                                <tr>
                                    <th>Contribuyente</th>
                                    <th>Referencia bibliográfica</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($references as $reference)
                                    <tr>
                                        <td data-values="Contribuyente">{{ $reference->studentContribute }}</td>
                                        <td data-values="Referencia bibliográfica">{{ $reference->reference }}</td>
                                        <td data-values="Estado">
                                            @if($reference->state !== 'Aprobado')
                                                <button type="button" class="btn btn-aproved-reference" 
                                                    data-values="{{ $reference->referenceId }}">Aprobar
                                                </button>
                                                <h4 style="font-weight: 100; display: none" class="stateReference" 
                                                    id="state-reference-{{ $reference->referenceId }}">{{ $reference->state }}
                                                </h4>   
                                            @else
                                                <h4 class="state">{{ $reference->state }}</h4>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <input name="idcId" type="text" hidden value="{{ $idcId }}">
                    <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                    <button type="submit" class="btn">Generar Documento</button>
                </form>
                <div id="notification" class="notification"></div>
            </section>
        @else 
            <section class="scientific-article-content">
                <div class="first-section">
                    <header class="head">
                        <strong><h2>Desarrollo del tema</h2></strong>
                        <button type="button" id="btnAddContribute" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
                    </header>
                    <!-- Modal Add Contribute -->
                    <div id="myModalContribute" class="modal">
                        <div class="modal-content">
                            <header class="head">
                                <h2>Nuevo sub-título</h2>
                                <button type="button" id="cerrarModalContribute"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <form id="formContribute" action="{{ route('development.create') }}" method="POST" class="information-development" enctype="multipart/form-data">
                                @csrf
                                <textarea class="textarea textareaD" name="title" placeholder="Sub-Título" maxlength="300"></textarea>
                                <textarea class="textarea textareaD" name="content" placeholder="Contenido" maxlength="3000"></textarea>
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                <div id="notificationD" class="notificationM"></div>
                                <button type="submit" class="btn" id="btn-add-contribute">Agregar</button>
                            </form>
                        </div>
                    </div>
                    <table id="data-table-contribute" class="table content-table">
                        <thead>
                            <tr>
                                <th>Sub-Título</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contents as $content)
                                <tr>
                                    <td data-values="Sub-Título">{{ $content->title }}</td>
                                    <td data-values="Estado">{{ $content->state }}</td>
                                    <td data-values="Acciones">
                                        @if($content->state !== 'Aprobado')
                                            <button type="button" class="btn btn-edit" data-modal="editarModalContent" data-developmentId="{{ $content->developmentId }}" 
                                                data-title="{{ $content->title }}" data-content="{{ $content->content }}" data-image="{{ $content->image }}"
                                            >
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-delete" data-modal="eliminarModalContent" data-developmentId="{{ $content->developmentId }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Edit content modal -->
                    <div id="editarModalContent" class="modal">
                        <div class="modal-content">
                            <header class="head">
                                <h2>Datos del aporte</h2>
                                <button type="button" class="cerrarModal close"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <form id="formContentEdit" action="{{ route('development.edit') }}" method="POST" class="basic-information">
                                @csrf
                                <textarea id="title" class="textarea textareaDE" name="title" placeholder="Titulo"></textarea>
                                <textarea id="content" class="textarea textareaDE" name="content" placeholder="Contenido"></textarea>
                                <input hidden type="text" name="developmentId" id="developmentEId" autocomplete="off">
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                <div id="notificationOG" class="notificationM"></div>
                                <button type="submit" class="btn" id="submitButtonConclusionEdit">Agregar</button>
                            </form>
                        </div>
                    </div>
                    <!-- Delete content modal -->
                    <div class="modal" id="eliminarModalContent">
                        <div class="modal-content">
                            <header class="head">
                                <h2>¿Realmente deseas eliminar el sub-título?</h2>
                                <button type="button" class="close cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <div class="optionDelete">
                                <form action="{{ route('development.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input hidden type="text" name="developmentId" id="developmentId">
                                    <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                    <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                    <button class="btn">Eliminar</button>
                                </form>
                                <button class="btn close">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second-section">
                    <header class="conclusion">
                        <strong><h2>Conclusiones</h2></strong>
                        <button type="button" id="btnAddConclusion" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
                    </header>
                    <!-- Modal Add Conclusion -->
                    <div id="myModalConclusion" class="modal">
                        <div class="modal-content">
                            <header class="head">
                                <h2>Nueva conclusión</h2>
                                <button type="button" id="cerrarModalConclusion"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <form id="formConclusion" action="{{ route('conclusion.create') }}" method="POST" class="information-conclusion">
                                @csrf
                                <textarea class="textarea textareaC" name="conclusion" placeholder="Conclusión" maxlength="800"></textarea>
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                <div id="notificationC" class="notificationM"></div>
                                <button type="submit" class="btn" id="btn-add-conclusion">Agregar</button>
                            </form>
                        </div>
                    </div>
                    <table id="data-table-conclusion" class="table content-table">
                        <thead>
                            <tr>
                                <th>Conclusión</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conclusions as $conclusion)
                                    <td data-values="Conclusión">{{ $conclusion->conclusion }}</td>
                                    <td data-values="Estado">{{ $conclusion->state }}</td>
                                    <td data-values="Acciones">
                                        @if($conclusion->state !== 'Aprobado')
                                            <button type="button" class="btn btn-edit" data-modal="editarModalConclusion" data-conclusionId="{{ $conclusion->conclusionId }}" 
                                                data-conclusion="{{ $conclusion->conclusion }}"
                                            >
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-delete" data-modal="eliminarModalConclusion" data-conclusionId="{{ $conclusion->conclusionId }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Edit conclusion modal -->
                    <div id="editarModalConclusion" class="modal">
                        <div class="modal-content">
                            <header class="head">
                                <h2>Datos conclusión</h2>
                                <button type="button" class="cerrarModal close"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <form id="formConclusionEdit" action="{{ route('conclusion.edit') }}" method="POST" class="basic-information">
                                @csrf
                                <textarea id="conclusion" class="textarea textareaCO" name="conclusion" placeholder="Conclusion"></textarea>
                                <input hidden type="text" name="conclusionId" id="conclusionEId" autocomplete="off">
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                <div id="notificationOG" class="notificationM"></div>
                                <button type="submit" class="btn" id="submitButtonConclusionEdit">Agregar</button>
                            </form>
                        </div>
                    </div>
                    <!-- Delete conclusion modal -->
                    <div class="modal" id="eliminarModalConclusion">
                        <div class="modal-content">
                            <header class="head">
                                <h2>¿Realmente deseas eliminar la conclusión?</h2>
                                <button type="button" class="close cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <div class="optionDelete">
                                <form action="{{ route('conclusion.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input hidden type="text" name="conclusionId" id="conclusionId">
                                    <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                    <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                    <button class="btn">Eliminar</button>
                                </form>
                                <button class="btn close">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="third-section">
                    <header class="references">
                        <strong><h2>Referencias bibliográficas</h2></strong>
                        <button type="button" id="btnAddReference" class="btn"><i class="fa-solid fa-plus"></i> Agregar</button>
                    </header>
                    <!-- Modal Add References -->
                    <div id="myModalReference" class="modal">
                        <div class="modal-content">
                            <header class="head">
                                <h2>Nueva referencia bibliográfica</h2>
                                <button type="button" id="cerrarModalReference"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <form id="formReference" action="{{ route('reference.create') }}" method="POST" class="information-reference">
                                @csrf
                                <textarea class="textarea textareaR" name="reference" placeholder="Referencia bibliográfica" maxlength="800"></textarea>
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                <div id="notificationR" class="notificationM"></div>
                                <button type="submit" class="btn" id="btn-add-reference">Agregar</button>
                            </form>
                        </div>
                    </div>
                    <table id="data-table-references" class="table content-table">
                        <thead>
                            <tr>
                                <th>Referencia bibliográfica</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($references as $reference)
                                <tr>
                                    <td data-values="Referencia bibliográfica">{{ $reference->reference }}</td>
                                    <td data-values="Estado">{{ $reference->state }}</td>
                                    <td data-values="Acciones">
                                        @if($reference->state !== 'Aprobado')
                                            <button type="button" class="btn btn-edit" data-modal="editarModalReference" data-referenceId="{{ $reference->referenceId }}" 
                                                data-reference="{{ $reference->reference }}"
                                            >
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-delete" data-modal="eliminarModalReference" data-referenceId="{{ $reference->referenceId }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Edit reference modal -->
                    <div id="editarModalReference" class="modal">
                        <div class="modal-content">
                            <header class="head">
                                <h2>Datos referencia bibliográfica</h2>
                                <button type="button" class="cerrarModal close"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <form id="formReferenceEdit" action="{{ route('reference.edit') }}" method="POST" class="basic-information">
                                @csrf
                                <textarea id="reference" class="textarea textareaRE" name="reference" placeholder="Referencia bibliografica"></textarea>
                                <input hidden type="text" name="referenceId" id="referenceEId" autocomplete="off">
                                <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                <div id="notificationOG" class="notificationM"></div>
                                <button type="submit" class="btn" id="submitButtonReferenceEdit">Agregar</button>
                            </form>
                        </div>
                    </div>
                    <!-- Delete content modal -->
                    <div class="modal" id="eliminarModalReference">
                        <div class="modal-content">
                            <header class="head">
                                <h2>¿Realmente deseas eliminar la referencia bibliográfica?</h2>
                                <button type="button" class="close cerrarModal"><i class="fa-solid fa-xmark"></i></button>
                            </header>
                            <div class="optionDelete">
                                <form action="{{ route('reference.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input hidden type="text" name="referenceId" id="referenceId">
                                    <input name="idcId" type="text" hidden value="{{ $idcId }}">
                                    <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                                    <button class="btn">Eliminar</button>
                                </form>
                                <button class="btn close">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection

@section('scripts')
    @if(session('role') === 'Docente')
        <script src=" {{ asset('js/scientificArticleReport.js') }}"></script>
    @elseif(session('role') === 'Estudiante')
        <script src=" {{ asset('js/scientificArticleReportStudent.js') }}"></script>
    @endif
@endsection