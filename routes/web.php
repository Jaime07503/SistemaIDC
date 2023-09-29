<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthGoogleLoginController;
    use App\Http\Controllers\TeacherController;

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/login', function () {
        return view('auth.login');
    });

    Route::get('/tablero', function(){
        return view('layouts.tablero');
    });

    Route::get('/perfil', function(){
        return view('layouts.perfil');
    });

    Route::get('/investigaciones', function(){
        return view('layouts.investigaciones');
    });

    //GET
    Route::get('/home', [TeacherController::class, 'viewCourses']);
    Route::get('/login-google', [AuthGoogleLoginController::class, 'redirectToGoogle']);
    Route::get('/google-callback', [AuthGoogleLoginController::class, 'handleGoogleCallback']);
    Route::get('/google-logout', [AuthGoogleLoginController::class, 'logout']);

    //POST
    //PUT
    //DELETE
?>