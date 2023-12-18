<?php
    namespace App\Http\Controllers;
    use Laravel\Socialite\Facades\Socialite;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use App\Models\User;

    class AuthGoogleLoginController extends Controller
    {
        public function redirectToGoogle()
        {
            return Socialite::driver('google')->redirect();
        }

        public function handleGoogleCallback()
        {
            $user = Socialite::driver('google')->user();

            if (strpos($user->email, '@catolica.edu.sv') !== false || strpos($user->email, 'mariojaimemartinez27@gmail.com') !== false) {
                $usuarioExiste = User::where('email', $user->email)->first();

                if ($usuarioExiste) {
                    Auth::login($usuarioExiste);

                    session(['userId' => $usuarioExiste->userId]);
                    session(['avatarUrl' => $usuarioExiste->avatar]);
                    session(['name' => $usuarioExiste->name]);
                    session(['role' => $usuarioExiste->role]);

                    if($usuarioExiste->firstLogin === null)
                    {
                        User::where('userId', $usuarioExiste->userId)
                        ->update(['avatar' => $user->avatar]);
                    }
                    
                    if($usuarioExiste->firstLoginPresentCycle === null && $usuarioExiste->role === 'Estudiante')
                    {
                        return redirect('/formularioPostulacion');
                    }

                    return redirect('/home');
                } 
                else 
                {
                    return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
                }
            } 
            else 
            {
                return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: La dirección de correo electrónico no está permitida en este sitio.');
            }
        }

        public function logout()
        {
            Auth::logout(); 
            Session::flush();

            return redirect('/login');
        }
    }
?>