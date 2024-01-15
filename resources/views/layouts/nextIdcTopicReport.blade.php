@extends('layout')

@section('title')
    Informe de Temas para siguiente IDC
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/own/topicSearchReport.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <header class="head-content">
            <h1>Datos del informe de temas para siguiente IDC</h1>
            <nav class="history">
                <a class="view" href="{{ url('/tablero') }}">Tablero</a>
                <a class="view" >Mis cursos</a>
                <a class="view" href="">ADS104-A-I24</a>
                <a class="view" href="">Tema</a>
                <a class="view" href=""> Etapas </a>
            </nav>
        </header>
        @if($role === 'Docente')
            <form action="" method="POST">
                @csrf

            </form>
        @else
        <div class="source-content">
                <div class="fuentes">
                    <strong><h2>Temas de investigación propuestos</h2></strong>
                    <button type="button" id="btnTopic" class="btn">Proponer tema</button>
                </div>
                <!-- Modal -->
                <div id="myModalTopic" class="modal">
                    <div class="modal-content">
                        <header class="head">
                            <h2>Nuevo tema propuesto</h2>
                            <button type="button" id="cerrarModalTopic"><i class="fa-solid fa-xmark"></i></button>
                        </header>
                        <form action="" method="POST" class="basic-information">
                            @csrf
                            <input type="text" name="year" id="año" placeholder="Tema" autocomplete="off">
                            <input type="text" name="author" id="autor" placeholder="¿Es pertinente para la materia?" autocomplete="off">
                            <!-- <div class="container file-container" id="container3">
                                <input type="file" name="imageDiagram" class="file-input" accept="image/*" hidden>
                                <div class="img-area" data-img="">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h4>Global</h4>
                                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                </div>
                            </div>
                            <div class="container file-container" id="container3">
                                <input type="file" name="imageDiagram" class="file-input" accept="image/*" hidden>
                                <div class="img-area" data-img="">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h4>Regional</h4>
                                    <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
                                </div>
                            </div> -->
                            <input type="text" name="averageType" id="tipoMedio" placeholder="Existe información actualizada sobre el tema" autocomplete="off">
                            <input type="text" name="link" id="enlace" placeholder="Qué tan pertinente es el tema geográficamente, que tanto me sirve localmente, ¿hay empresas o instituciones dedicadas al tema?" autocomplete="off">
                            <input type="text" name="link" id="enlace" placeholder="Qué tan pertinente es el tema globalmente. Cual es el estadio en términos de pertinencia de la temática, se sigue investigando sobre esto, está estancado o hay una zona de oportunidad para crear nuevo conocimiento." autocomplete="off">
                            <input name="idcId" type="text" hidden value="{{ $idcId }}">
                            <input name="idTopicSearchReport" type="text" hidden value="{{ $idNextIdcTopicReport }}">
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
                        </tbody>
                    </table>
                </div>
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
                    topic: document.getElementById('myModalTopic')
                };

                var btns = {
                    addTopic: document.getElementById('btnTopic')
                };

                var closeBtns = {
                    topic: document.getElementById('cerrarModalTopic')
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
                btns.addTopic.addEventListener('click', handleAddButtonClick(modals.topic));

                closeBtns.topic.addEventListener('click', handleCloseButtonClick(modals.topic));
            </script>
        @endif
    </main>
@endsection

@section('scripts')
    <script src=" {{ asset('js/topicSearchReport.js') }}"></script>
@endsection