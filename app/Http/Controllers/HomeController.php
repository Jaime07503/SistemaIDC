<?php
    namespace App\Http\Controllers;
    use App\Models\Student;
    use App\Models\Teacher;
    use App\Models\Subject;

    class HomeController extends Controller
    {
        public function viewCourses()
        {
            $idUser = session('userId');
            $role = session('role');

            if (!$idUser) {
                return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
            }

            if($role == 'Estudiante'){
                $student = Student::whereHas('user', function ($query) use ($idUser){
                    $query->where('userId', $idUser);
                })->first();

                $career = $student->career;

                $courses = Subject::where('career', $career) // Filtrar por carrera
                    ->where('subjectCycle', 'Ciclo I 2024') // Filtrar por ciclo actual
                    ->get();

                    return view('layouts.home', compact('courses', 'role'));
            }

            $teacher = Teacher::whereHas('user', function ($query) use ($idUser) {
                $query->where('userId', $idUser);
            })->first();

            if (!$teacher) {
                return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
            }

            $specialty = $teacher->specialty; // Obtains the teacher's specialty

            $courses = Subject::with(['teacher.user'])
                ->whereHas('teacher.user', function ($query) use ($idUser) {
                    $query->where('userId', $idUser);
                })
                ->where('career', $specialty) // Filter by specialty
                ->where('subjectCycle', 'Ciclo I 2024') // Filter by actual cycle
                ->get();

            return view('layouts.home', compact('courses', 'role'));
        }
    }
?>