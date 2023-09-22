<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Investigaciones de Cátedra</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="main-container">
            <img class="logo" src="{{ asset('images/logo_unicaes.png') }}" alt="Logo UNICAES">
            <div class="login-container">
                <header class="login-left">
                    <h2>Investigaciones de Cátedra</h2>
                    @if(session('error'))
                        <div class="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </header>
                <div class="line"></div>
                <section class="login-right">
                    <h3>Iniciar sesión con</h3>
                    <a href="{{ url('/login-google') }}" class="btn-login">
                        <img src="{{ asset('images/logo_google.png') }}" alt="Logo Google">
                        Correo Institucional
                    </a>
                </section>
            </div>
        </div>
    </body>
</html>