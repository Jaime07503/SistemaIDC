<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/home', function(){
    return view('layouts.home');
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

Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-callback', function () {
    $user = Socialite::driver('google')->user();

    if(strpos($user->email, '@catolica.edu.sv') !== false){
        $usuarioExiste = User::where('email', $user->email)->first();

        if($usuarioExiste) {
            Auth::login($usuarioExiste);
            
            session(['avatarUrl' => $user->getAvatar()]);
            session(['name' => $user->getName()]);
        } else {
            return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontro una cuenta con su dirección email.');
        }

        return redirect('/home');
    } else{
        return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: La dirección de correo electrónico no está permitida en este sitio.');
    }
});
