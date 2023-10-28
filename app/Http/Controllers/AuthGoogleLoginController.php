<?php
    namespace App\Http\Controllers;
    use Laravel\Socialite\Facades\Socialite;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

    class AuthGoogleLoginController extends Controller
    {
        public function redirectToGoogle()
        {
            return Socialite::driver('google')->redirect();
        }

        public function handleGoogleCallback()
        {
            $user = Socialite::driver('google')->user();

            if (strpos($user->email, '@catolica.edu.sv') !== false) {
                $usuarioExiste = User::where('email', $user->email)->first();

                if ($usuarioExiste) {
                    Auth::login($usuarioExiste);

                    session(['avatarUrl' => $user->getAvatar()]);
                    session(['name' => $user->getName()]);

                    if($usuarioExiste->first_login_at === null){
                        return redirect('/formularioPostulacion');
                    }

                    return redirect('/home');
                } else {
                    return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
                }
            } else {
                return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: La dirección de correo electrónico no está permitida en este sitio.');
            }
        }

        public function logout()
        {
            Auth::logout(); // Cierra la sesión actual del usuario
            Session::flush(); // Borra todas las sesiones, incluyendo las de Google

            return redirect('/login');
        }
    }
?>