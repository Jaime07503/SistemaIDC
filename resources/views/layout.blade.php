<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="shortcut icon" href="https://plataforma.catolica.edu.sv/pluginfile.php/1/theme_moove/favicon/1672891795/favicon.ico">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/partials/navbar.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/partials/footer.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/partials/modal.css') }}" >
        @yield('styles')

    </head>
    <body>
        @include('partials.navbar')

        @yield('content')

        @include('partials.modal')

        @include('partials.footer')

        @yield('scripts')
        <script src=" {{ asset('js/modal.js') }}"></script>
        <script src=" {{ asset('js/footer.js') }}"></script>
    </body>
</html>