<?php
    namespace App\Http\Controllers;
    use App\Models\Student;
    use App\Models\StudentSubject;
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

                session(['studentId' => $student->studentId]);

                $idStudent = $student->studentId;

                $subjectsIds = StudentSubject::where('idStudent', $idStudent)->pluck('idSubject');

                $courses = Subject::whereIn('subjectId', $subjectsIds)->get();

                return view('layouts.home', compact('courses', 'role'));
            } else {
                $teacher = Teacher::whereHas('user', function ($query) use ($idUser) {
                    $query->where('userId', $idUser);
                })->first();
    
                if (!$teacher) {
                    return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
                }
     
                $courses = Subject::where('idTeacher', $idUser) 
                    ->where('subjectCycle', 'Ciclo I 2024') 
                    ->get();
            }

            return view('layouts.home', compact('courses', 'role'));
        }
    }
?>