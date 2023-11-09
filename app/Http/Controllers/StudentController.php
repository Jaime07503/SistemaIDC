<?php
    namespace App\Http\Controllers;

    use App\Models\Student;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class StudentController extends Controller
    {
        public function store(Request $request){            
            $student = new Student;
            $student->carnet = $request->input('carnet');
            $student->career = $request->input('career');
            $student->studentYear = $request->input('year');
            $student->studentCycle = 'Ciclo I 2024';
            $student->enrolledSubject = $request->input('selectedMaterias');
            $student->previousIDC = $request->input('previousIDC');
            $student->state = 'Activo';
            $student->idUser = 1;

            $student->save();

            $user = User::find($student->idUser);
            if ($user) {
                $user->name = $request->input('name'); 
                $user->firstLoginPresentCycle = Carbon::now();
                if ($user->firstLogin === null) {
                    $user->firstLogin = Carbon::now();
                }
                $result = $user->save();
            }

            if($result) {
                return redirect('/home')->with('success', 'El estudiante ha sido guardado con éxito');
            }
        }
    }
?>