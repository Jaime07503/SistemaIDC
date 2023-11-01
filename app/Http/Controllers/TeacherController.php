<?php
    namespace App\Http\Controllers;

    use App\Models\Teacher;
    use App\Models\Subject;

    class TeacherController extends Controller
    {
        public function viewCourses()
        {
            $idTeacher = session('userId');

            if (!$idTeacher) {
                return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
            }

            $teacher = Teacher::whereHas('user', function ($query) use ($idTeacher) {
                $query->where('userId', $idTeacher);
            })->first();

            if (!$teacher) {
                return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
            }

            $specialty = $teacher->specialty; // Obtains the teacher's specialty

            $courses = Subject::with(['teacher.user'])
                ->whereHas('teacher.user', function ($query) use ($idTeacher) {
                    $query->where('userId', $idTeacher);
                })
                ->where('career', $specialty) // Filter by specialty
                ->where('subjectCycle', 'Ciclo I 2024') // Filter by actual cycle
                ->get();

            return view('layouts.home', compact('courses'));
        }
    }
?>