<?php
    namespace App\Http\Controllers;
    use Laravel\Socialite\Facades\Socialite;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use App\Models\User;
    use Carbon\Carbon;
    use DateTime;

    class AuthGoogleLoginController extends Controller
    {
        public function redirectToGoogle()
        {
            return Socialite::driver('google')->redirect();
        }

        public function handleGoogleCallback()
        {
            $user = Socialite::driver('google')->user();

            if (strpos($user->email, '@catolica.edu.sv') !== false || strpos($user->email, 'mariojaimemartinez27@gmail.com') !== false
                || strpos($user->email, 'mariojaimemartz27@gmail.com') !== false) {
                $usuarioExiste = User::where('email', $user->email)->first();

                if ($usuarioExiste) {
                    Auth::login($usuarioExiste);

                    session(['userId' => $usuarioExiste->userId]);
                    session(['avatarUrl' => $usuarioExiste->avatar]);
                    session(['name' => $usuarioExiste->name]);
                    session(['role' => $usuarioExiste->role]);

                    if($usuarioExiste->firstLogin === null && $usuarioExiste->role === 'Estudiante')
                    {
                        User::where('userId', $usuarioExiste->userId)
                        ->update(['avatar' => $user->avatar]);
                    }
                    
                    if($usuarioExiste->firstLoginPresentCycle === null && $usuarioExiste->role === 'Estudiante')
                    {
                        return redirect('/formularioPostulacion');
                    }

                    return redirect('/tablero');
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
            $fechaActual = new DateTime();
            $fechaCarbon = Carbon::parse($fechaActual);

            User::where('userId', session('userId'))
                ->update(['lastLogin' => $fechaCarbon]);
                
            Auth::logout(); 
            Session::flush();

            return redirect('/login');
        }
    }
?>