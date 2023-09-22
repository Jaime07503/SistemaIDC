<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/home', function(){
    return view('home');
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
        } else {
            return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontro una cuenta con su dirección email.');
        }

        return redirect('/home');
    } else{
        return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: La dirección de correo electrónico no está permitida en este sitio.');
    }
});