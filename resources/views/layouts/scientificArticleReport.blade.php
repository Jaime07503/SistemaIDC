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
        <section class="scientific-article-content">
            <form id="formSaveProgress" class="scientific-article" action="{{ route('scientificArticleReport.saveProgress', ['idScientificArticleReport' => $idScientificArticleReport]) }}" method="POST">
                @csrf
                <div class="first-section">
                    <strong><h2>Resúmenes</h2></strong>
                    <textarea class="textarea textareaSC" id="spanishSummary" name="spanishSummary" placeholder="Resumen en español" min="650" maxlength="850">{{ $scientificArticleReport->spanishSummary }}</textarea>
                    <textarea class="textarea textareaSC" name="englishSummary" placeholder="Resumen en inglés" min="650" maxlength="850">{{ $scientificArticleReport->englishSummary }}</textarea>
                    <textarea class="textarea textareaSC" name="keywords" placeholder="Palabras clave" min="80" maxlength="160">{{ $scientificArticleReport->keywords }}</textarea>
                </div>
                <div class="second-section">
                    <strong><h2>Introducción</h2></strong>
                    <textarea class="textarea textareaSC" name="introduction" placeholder="Introducción" min="1300" maxlength="1450">{{ $scientificArticleReport->introduction }}</textarea>
                    <textarea class="textarea textareaSC" name="methodology" placeholder="Metodología" min="375" maxlength="500">{{ $scientificArticleReport->methodology }}</textarea>
                </div>
                <div class="third-section">
                <strong><h2>Desarrollo</h2></strong>
                    <textarea class="textarea textareaSC" name="subtitle" placeholder="Primer Sub-título" min="3000" maxlength="4000">{{ $scientificArticleReport->subtitle }}</textarea>
                    <textarea class="textarea textareaSC" name="secondSubtitle" placeholder="Segundo Sub-título" min="3000" maxlength="4000">{{ $scientificArticleReport->secondSubtitle }}</textarea>
                    <textarea class="textarea textareaSC" name="thirdSubtitle" placeholder="Tercer Sub-título" min="3000" maxlength="4000">{{ $scientificArticleReport->thirdSubtitle }}</textarea>
                </div>
                <button type="submit" class="btn btn-save-progress">Guardar Progreso <i class="fa-solid fa-shield"></i></button>
            </form>

            <div class="fourth-section">
                <header class="conclusion">
                    <strong><h2>Conclusiones</h2></strong>
                    @if(auth()->user()->role === 'Estudiante')
                        <button type="button" id="btnAddConclusion" class="btn"><i class="fa-solid fa-square-plus"></i> Agregar</button>
                    @endif
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
                            <textarea class="textarea textareaC" name="conclusion" placeholder="Conclusión" min="300" maxlength="400"></textarea>
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                            <div id="notificationC" class="notificationM"></div>
                            <button type="submit" class="btn" id="btn-add-conclusion">Agregar</button>
                        </form>
                    </div>
                </div>
                @if($conclusions->isEmpty())
                    <h3 class="empty">No se han agregado <strong>Conclusiones</strong></h3>
                @else
                    <table id="data-table-conclusion" class="table content-table">
                        <thead>
                            <tr>
                                <th>Conclusión</th>
                                <th>Estado</th>
                                @if(auth()->user()->role === 'Estudiante')
                                    <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conclusions as $conclusion)
                                    <td data-values="Conclusión">{{ $conclusion->conclusion }}</td>
                                    <td data-values="Estado">
                                        @if($conclusion->state !== 'Aprobado')
                                            @if(auth()->user()->role === 'Docente')
                                                <button type="button" class="btn btn-aproved-conclusion" 
                                                    data-values="{{ $conclusion->conclusionId }}">Aprobar
                                                </button>
                                                <h4 style="font-weight: 100; display: none" class="stateContribute" 
                                                    id="state-conclusion-{{ $conclusion->conclusionId }}">{{ $conclusion->state }}
                                                </h4>
                                            @else
                                                <h4 class="state">{{ $conclusion->state }}</h4>
                                            @endif
                                        @else
                                            <h4 class="state">{{ $conclusion->state }}</h4>
                                        @endif
                                    </td>
                                    @if(auth()->user()->role === 'Estudiante')
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
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <!-- Edit Conclusion Modal -->
                <div id="editarModalConclusion" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Datos conclusión</h2>
                            <button type="button" class="cerrarModal close"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form id="formConclusionEdit" action="{{ route('conclusion.edit') }}" method="POST" class="basic-information">
                            @csrf
                            <textarea id="conclusion" class="textarea textareaCO" name="conclusion" placeholder="Conclusión"></textarea>
                            <input hidden type="text" name="conclusionId" id="conclusionEId" autocomplete="off">
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                            <div id="notificationCO" class="notificationM"></div>
                            <button type="submit" class="btn" id="submitButtonConclusionEdit">Agregar</button>
                        </form>
                    </div>
                </div>
                <!-- Delete Conclusion Modal -->
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
                                <button type="submit" class="btn">Eliminar</button>
                            </form>
                            <button type="button" class="btn close">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="third-section">
                <header class="references">
                    <strong><h2>Referencias bibliográficas</h2></strong>
                    @if(auth()->user()->role === 'Estudiante')
                        <button type="button" id="btnAddReference" class="btn"><i class="fa-solid fa-square-plus"></i> Agregar</button>
                    @endif
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
                            <textarea class="textarea textareaR" name="reference" placeholder="Referencia bibliográfica" min="" maxlength="800"></textarea>
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                            <div id="notificationR" class="notificationM"></div>
                            <button type="submit" class="btn" id="btn-add-reference">Agregar</button>
                        </form>
                    </div>
                </div>
                @if($references->isEmpty())
                    <h3 class="empty">No se han agregado <strong>Referencias Bibliográficas</strong></h3>
                @else
                    <table id="data-table-references" class="table content-table">
                        <thead>
                            <tr>
                                <th>Referencia bibliográfica</th>
                                <th>Estado</th>
                                @if(auth()->user()->role === 'Estudiante')
                                    <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($references as $reference)
                                <tr>
                                    <td data-values="Referencia bibliográfica"><p class="reference">{{ $reference->reference }}</p></td>
                                    <td data-values="Estado">
                                        @if($reference->state !== 'Aprobado')
                                            @if(auth()->user()->role === 'Docente')
                                                <button type="button" class="btn btn-aproved-reference" 
                                                    data-values="{{ $reference->referenceId }}">Aprobar
                                                </button>
                                                <h4 style="font-weight: 100; display: none" class="stateReference" 
                                                    id="state-reference-{{ $reference->referenceId }}">{{ $reference->state }}
                                                </h4>   
                                            @else
                                                <h4 class="state">{{ $reference->state }}</h4>
                                            @endif
                                        @else
                                            <h4 class="state">{{ $reference->state }}</h4>
                                        @endif
                                    </td>
                                    @if(auth()->user()->role === 'Estudiante')
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
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <!-- Edit Reference Modal -->
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
                            <div id="notificationRE" class="notificationM"></div>
                            <button type="submit" class="btn" id="submitButtonReferenceEdit">Agregar</button>
                        </form>
                    </div>
                </div>
                <!-- Delete Content Modal -->
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
                                <button type="submit" class="btn">Eliminar</button>
                            </form>
                            <button type="button" class="btn close">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
                
            @if(auth()->user()->role === 'Docente')
                <form id="myForm" class="scientific-article" action="{{ route('generate-scientific-article') }}" method="POST">
                    @csrf
                    <input name="idcId" type="text" hidden value="{{ $idcId }}">
                    <input name="idScientificArticleReport" type="text" hidden value="{{ $idScientificArticleReport }}">
                    <input type="hidden" id="wordCount" name="numbersOfWords" value="0">
                    <button type="submit" class="btn">Generar Documento <i class="fa-regular fa-file-word"></i></button>
                </form>
            @endif
            <div id="notification" class="notification"></div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/scientificArticleReport.js') }}"></script>
@endsection