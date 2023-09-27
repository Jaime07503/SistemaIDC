@extends('layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endsection

@section('content')
        <main class="main-content">
        <div class="container">
            <div class="contenido-main">
                <h1>Perfil del usuario</h1>
            </div>
            <!--div class="contenido-info">
                <div class="perfil">.col-sm-6 .col-md-8</div>
                <div class="datos">.col-6 .col-md-4</div>
            </-div-->
            <div class="contenido-info">
                <div class="cont">
                    <div class="mision">
                    <img src="https://www.google.com/search?sca_esv=568362559&rlz=1C1CHZN_esSV945SV945&sxsrf=AM9HkKl83Zafn-KwfY-1-o3meCruVi8nsA:1695692380540&q=foto+random+perfil&tbm=isch&source=lnms&sa=X&sqi=2&ved=2ahUKEwiq7PWvkseBAxXVTDABHdYpBbwQ0pQJegQIDBAB&biw=1536&bih=739&dpr=1.25#imgrc=8NjeCn6YJoJ3yM" class="img-thumbnail" alt="...">
                    <h3>Sergio Alexander Moran</h3>
                </div>
                    <div class="cont">
                        <div>
                            <h4>Detalles del usuario</h4>
                            <h6>Direccion Email</h6>
                            <h6>Insignias IDC</h6>
                        </div>
                        <div>
                            <h4>Actividad de ingresos</h4>
                            <h6>Primer acceso al sitio</h6>
                            <h6>Primer acceso al sitio</h6>
                        </div>
                    </div>
                </div>
                <div>
                        <h4>Detalles de las investigaciones de catedra</h4>
                        <a href="URL">Texto del enlace</a> <br>
                        <a href="URL">Texto del enlace</a>


                    </div>
            </div>
        </main-->

    <!-- Scripts -->
    <script src=" {{ asset('js/home.js') }}"></script>
    </body>
@endsection
