<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Formulario para postularse</title>

    <!-- Fonts and Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="https://plataforma.catolica.edu.sv/pluginfile.php/1/theme_moove/favicon/1672891795/favicon.ico">

    <!-- Style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/own/formularioPostulacion.css') }}">
</head>
<body>
    <div class="wrapper">
        <form class="form" action=" {{ url('/addStudent') }} " method="POST">
            @csrf
            <h1>Postularse</h1>

            <!-- Input Name -->
            <div class="input-box">
                <input type="text" name="name" id="nameInput" placeholder="Nombre completo" class="error-input" autocomplete="off">
                <i class="fa-solid fa-circle-exclamation errores" id="nameInputError"></i>
            </div>

            <!-- Carnet and CUM Inputs -->
            <div class="info-carnet-año">
                <div class="input-box item">
                    <input class="error-input" type="text" name="carnet" placeholder="Número de carnet" id="carnetInput" maxlength="11" autocomplete="off">
                    <i class="fa-solid fa-circle-exclamation errores" id="carnetInputError"></i>
                </div>
                <div class="input-box item">
                    <input class="error-input" type="text" name="cum" placeholder="CUM actual" id="cumInput" maxlength="3" autocomplete="off">
                    <i class="fa-solid fa-circle-exclamation errores" id="cumInputError"></i>
                </div>
            </div>

            <!-- Listbox Careers -->
            <div class="options-courses">
                <div class="custom-listbox career">
                    <div class="listbox-header">
                        <input class="selected-option listbox error-input" name="career" id="career" placeholder="Carrera" readonly></input>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                        <i class="fa-solid fa-circle-exclamation error" id="careerInputError"></i>
                    </div>
                    <ul class="options">
                        @foreach($careers as $career)
                            <li>{{$career->nameCareer}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Listbox Enrolled Subjects -->
            <div class="options-subjects subject">
                <div class="custom-listbox enrolled">
                    <div class="listbox-header">
                        <input class="selected-option listbox" placeholder="Materias inscritas" id="enrolledInputSubjects" readonly></input>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                        <i class="fa-solid fa-circle-exclamation error" id="enrolledInputError"></i>
                    </div>
                    <ul class="options">
                        <div class="custom-checkbox" id="enrolledSubjects">
                        </div>
                    </ul>
                </div>
                <input type="hidden" name="selectedMaterias" id="selectedMaterias" value="">
            </div>

            <!-- Listbox Postulate Subject -->
            <div class="subject-postulate pos">
                <div class="custom-listbox subjectPostulated">
                    <div class="listbox-header">
                        <input class="selected-option listbox" name="subjectApply" id="subjectPostulated" placeholder="Materia a postular" readonly></input>
                        <i class="fa-solid fa-chevron-down arrow-down"></i>
                        <i class="fa-solid fa-circle-exclamation error" id="subjectPostulatedError"></i>
                    </div>
                    <ul class="options" id="subject-pos">
                    </ul>
                </div>
            </div>

            <!-- Radios Yes No Particpated IDC -->
            <div class="input-radio">
                <h2>¿Ha participado en IDC?</h2>
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

            <!-- Participated IDC Subject -->
            <div class="input-box idc" id="input-box">
                <input type="text" name="previousIDC" placeholder="En que materia" id="participated-idc-input" autocomplete="off">
                <i class="fa-solid fa-circle-exclamation errores" id="previousIDCInputError"></i>
            </div>

            <!-- Button -->
            <button type="submit" class="btn" id="submitButton">Postularse</button>
        </form>
    </div>

    <script src="{{ asset('js/formularioPostulacion.js') }}"></script>
</body>
</html>