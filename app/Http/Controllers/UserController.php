<?php
    namespace App\Http\Controllers;
    use App\Models\Career;
    use App\Models\Teacher;
    use App\Models\User;
    use Illuminate\Http\Request;

    class UserController extends Controller
    {
        public function getUsers()
        {
            $careers = Career::select('nameCareer')
                ->get();

            $users = User::select('userId', 'name', 'avatar', 'email', 'role','state')
                ->get();

            foreach ($users as $user) {
                if ($user->role == 'Docente') {
                    $teacherInformation = Teacher::where('idUser', $user->userId)->first();
                    $user->teacherId = $teacherInformation->teacherId;
                    $user->contractType = $teacherInformation->contractType;
                    $user->specialty = $teacherInformation->specialty;
                    $user->title = $teacherInformation->title;
                    $user->idcQuantity = $teacherInformation->idcQuantity;
                }
            }

            if ($users->isEmpty()) {
                return view('layouts.user', compact('careers'))->with('noUsers', true);
            }

            return view('layouts.user', compact('careers', 'users'));
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
                $teacher->title = $request->input('title');
                $teacher->idcQuantity = $request->input('idcQuantity');
                $teacher->idUser = $user->userId;
                $teacher->save();
            }

            return redirect()->route('user');
        }

        public function editUser(Request $request) {
            $userId = $request->input('userId');
            $teacherId = $request->input('teacherId');

            $user = User::find($userId);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            if ($request->input('role') === 'Docente') {
                $teacher = Teacher::find($teacherId);
                $teacher->contractType = $request->input('contractType');
                $teacher->specialty = $request->input('specialty');
                $teacher->title = $request->input('title');
                $teacher->idcQuantity = $request->input('idcQuantity');
                $teacher->save();
            }

            return redirect()->route('user');
        }

        public function deleteUser(Request $request) {
            $userId = $request->input('userId');
            $user = User::find($userId);
            $user->delete();

            return redirect()->route('user');
        }
    }
?>