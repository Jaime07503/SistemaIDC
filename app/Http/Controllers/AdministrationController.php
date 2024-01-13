<?php
    namespace App\Http\Controllers;
    use App\Models\Career;
    use App\Models\Teacher;
    use App\Models\User;
    use Illuminate\Http\Request;

    class AdministrationController extends Controller
    {
        public function getCareers()
        {
            $careers = Career::whereHas('Faculty', function ($query) {
                $query->where('nameFaculty', 'Ingeniería y Arquitectura');
            })->select('nameCareer')->get();

            $users = User::get();

            return view('layouts.administration', compact('careers', 'users'));
        }

        public function addUser(Request $request) {
            // Create new User
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->avatar = 'http://localhost/SistemaIDC/public/images/curso_logo.webp';
            $user->role = $request->input('role');
            $user->state = 'Activo';
            $user->save();

            if($request->input('role') === 'Docente') 
            {
                // Create new Teacher
                $teacher = new Teacher();
                $teacher->contractType = $request->input('contractType');
                $teacher->specialty = $request->input('specialty');
                $teacher->idcQuantity = 1;
                $teacher->save();
            }

            return redirect()->route('administration');
        }

        public function editUser(Request $request) {
            // Edit user by userId

            return redirect()->route('administration');
        }

        public function deleteUser(Request $request) {
            // Buscar el usuario por ID
            $userId = $request->input('userId');
            $user = User::find($userId);

            // Verificar si el usuario existe
            if (!$user) {
                // Manejar la situación donde el usuario no existe
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            // Eliminar el usuario
            $user->delete();

            return redirect()->route('administration');
        }
    }
?>