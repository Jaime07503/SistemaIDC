<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Formulario para postularse</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="https://plataforma.catolica.edu.sv/pluginfile.php/1/theme_moove/favicon/1672891795/favicon.ico">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/own/formularioInicial.css') }}">
</head>
<body>
    <div class="wrapper">
        <form action="" method="POST">
            @csrf
            <h1>Postularse</h1>
            <div class="input-box">
                <input type="text" placeholder="Nombre completo" required>
            </div>
            <div class="options-courses">
                <!-- Listbox -->
                <div class="custom-listbox">
                    <div class="listbox-header">
                        <span class="selected-option" id="career">Carrera</span>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options">
                        <li>Arquitectura</li>
                        <li>Ingeniería Agronómica</li>
                        <li>Ingeniería Civil</li>
                        <li>Ingeniería Eléctrica</li>
                        <li>Ingeniería en Desarrollo de Software</li>
                        <li>Ingeniería en Sistemas Informáticos</li>
                        <li>Ingeniería en Telecomunicaciones y Redes</li>
                        <li>Ingeniería Industrial</li>
                        <li>Ingeniería Mecánica</li>
                        <li>Ingeniería Química</li>
                    </ul>
                </div>
            </div>
            <div class="info-carnet-año">
                <div class="input-box item">
                    <input type="text" placeholder="Número de carnet" required>
                </div>
                <div class="options-courses item">
                    <!-- Listbox -->
                    <div class="custom-listbox">
                        <div class="listbox-header">
                            <span class="selected-option" id="year">Año</span>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            <li>Primer Año</li>
                            <li>Segundo Año</li>
                            <li>Tercer Año</li>
                            <li>Cuarto Año</li>
                            <li>Quinto Año</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="options-subjects subject">
                <!-- Listbox -->
                <div class="custom-listbox">
                    <div class="listbox-header">
                        <span class="selected-option">Materias inscritas</span>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                    </div>
                    <ul class="options" id="subject-list">
                        <li>
                            <h4>Selecciona las materias que tienes inscritas en este ciclo</h4>
                        </li>
                        <ul class="options" id="subject-list">
                        </ul>
                    </ul>
                </div>
            </div>
            <div class="subject-postulate pos">
                <!-- Listbox -->
                <div class="custom-listbox">
                        <div class="listbox-header">
                            <span class="selected-option">Materia a postular</span>
                            <i class="fa-solid fa-chevron-down arrow-down"></i>
                        </div>
                        <ul class="options">
                            <li>Etica</li>
                            <li>Proyectos de informática</li>
                            <li>Auditoría de sistemas</li>
                            <li>Técnicas de producción de sistemas</li>
                            <li>Desarrollo de aplicaciones móviles</li>
                        </ul>
                    </div>
                </div>
            <div class="input-radio">
                <h4>¿Ha participado en IDC?</h3>
                <div class="radio-options">
                    <div class="div-option">
                        <input type="radio" name="option" id="option-yes">
                        <label for="option-yes">Sí, he participado</label>
                    </div>
                    <div class="div-option">
                        <input type="radio" name="option" id="option-no" checked>
                        <label for="option-no">No, he participado</label>
                    </div>
                </div>
            </div>
            <div class="input-box" id="input-box">
                <input type="text" placeholder="En que materia" required>
            </div>
            <button type="submit" class="btn">Continuar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/formularioInicial.js') }}"></script>
</body>
</html>