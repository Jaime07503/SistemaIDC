<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Investigaciones de Cátedra: Ingresar al sitio</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="https://plataforma.catolica.edu.sv/pluginfile.php/1/theme_moove/favicon/1672891795/favicon.ico">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/own/login.css') }}">
    </head>
    <body>
        <main class="main-container">
            <img class="logo" src="{{ asset('images/logo_unicaes.webp') }}" alt="Logo UNICAES">
            <div class="login-container">
                <header class="login-left">
                    <h1>Investigaciones de Cátedra</h1>
                    @if(session('error'))
                        <div class="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </header>
                <div class="line"></div>
                <section class="login-right">
                    <h2>Ingresar con</h2>
                    <a href="{{ url('/login-google') }}" class="btn-login">
                        <img src="{{ asset('images/logo_google.png') }}" alt="Logo Google">
                        <h3>Correo Institucional</h3>
                    </a>
                </section>
            </div>
        </main>
    </body>
</html>