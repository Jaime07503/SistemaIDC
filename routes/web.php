<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/google-callback', function () {
    $user = Socialite::driver('google')->user();

    $usuarioExiste = User::where('external_id', $user->id)->where('external_auth', 'google')->first();
    
    if($usuarioExiste) {
        Auth::login($usuarioExiste);
    } else {
        $usuarioNuevo = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'google'
        ]);

        Auth::login($usuarioNuevo);
    }

    return redirect('/dashboard');
});