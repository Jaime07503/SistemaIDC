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

            foreach ($users as $user) {
                // Verificar si el usuario es de tipo docente
                if ($user->role == 'Docente') {
                    // Cargar información adicional para docentes
                    $docenteInfo = Teacher::where('idUser', $user->userId)->first();
                    $user->teacherId = $docenteInfo->teacherId;
                    $user->contractType = $docenteInfo->contractType;
                    $user->specialty = $docenteInfo->specialty;
                }
            }

            return view('layouts.administration', compact('careers', 'users'));
        }

        public function addUser(Request $request) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->avatar = 'http://localhost/SistemaIDC/public/images/curso_logo.webp';
            $user->role = $request->input('role');
            $user->state = 'Activo';
            $user->save();

            if($request->input('role') === 'Docente')
            {
                $teacher = new Teacher();
                $teacher->contractType = $request->input('contractType');
                $teacher->specialty = $request->input('specialty');
                $teacher->idcQuantity = 0;
                $teacher->idUser = $user->userId;
                $teacher->save();
            }

            return redirect()->route('administration');
        }

        public function editUser(Request $request) {
            $userId = $request->input('userId');
            $teacherId = $request->input('teacherId');

            $user = User::find($userId);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role = $request->input('role');

            if ($request->input('role') === 'Docente') {
                $teacher = Teacher::find($teacherId);
                $teacher->contractType = $request->input('contractType');
                $teacher->specialty = $request->input('specialty');
                $teacher->save();
            }

            $user->save();

            return redirect()->route('administration')->with('success', 'Usurario Actualizado');
        }

        public function deleteUser(Request $request) {
            $userId = $request->input('userId');
            $user = User::find($userId);

            $user->delete();

            return redirect()->route('administration');
        }
    }
?>
