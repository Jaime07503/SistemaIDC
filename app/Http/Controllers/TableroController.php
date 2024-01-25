<?php
    namespace App\Http\Controllers;
    use App\Models\Student;
    use App\Models\StudentSubject;
    use App\Models\StudentTeam;
    use App\Models\Teacher;
    use App\Models\Subject;
    use App\Models\Team;

    class TableroController extends Controller
    {
        public function viewCourses()
        {
            $idUser = session('userId');
            $role = session('role');

            if (!$idUser)
            {
                return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
            }

            if($role == 'Estudiante')
            {
                $student = Student::whereHas('User', function ($query) use ($idUser){
                    $query->where('userId', $idUser);
                })->first();

                session(['studentId' => $student->studentId]);

                $idStudent = $student->studentId;

                $subjectsIds = StudentSubject::where('idStudent', $idStudent)->pluck('idSubject');

                $courses = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                    ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                    ->join('User', 'Teacher.idUser', '=', 'User.userId')
                    ->whereIn('subjectId', $subjectsIds)
                    ->select('User.name', 'Subject.subjectId', 'Subject.nameSubject', 'Subject.section', 
                    'Subject.avatar', 'Cycle.cycle')
                    ->orderBy('nameSubject')
                    ->get();

                $teams = StudentTeam::join('Team as t', 't.teamId', '=', 'Student_Team.idTeam')
                    ->join('Idc', 't.teamId', '=', 'Idc.idTeam')
                    ->join('Research_Topic as rt', 'rt.researchTopicId', '=', 't.idResearchTopic')
                    ->where('Student_Team.idStudent', $idStudent)
                    ->select('Student_Team.studentTeamId', 't.*', 'rt.*', 'Idc.idcId')
                    ->get();

                if ($courses->isEmpty() && $teams->isEmpty()) {
                    return view('layouts.tablero', compact('role'))->with('noContent', true);
                }

                if ($courses->isEmpty()) {
                    return view('layouts.tablero', compact('role', 'teams'))->with('noCourses', true);
                }

                if ($teams->isEmpty()) {
                    return view('layouts.tablero', compact('courses', 'role'))->with('noTeams', true);
                }

                return view('layouts.tablero', compact('courses', 'role', 'teams'));
            } 
            else if($role === 'Docente')
            {
                $teacher = Teacher::whereHas('User', function ($query) use ($idUser) {
                    $query->where('userId', $idUser);
                })->first();

                if (!$teacher) {
                    return redirect('/login')->with('error', 'Falló el intento de ingreso. Motivo: No se encontró una cuenta con su dirección de correo electrónico.');
                }

                $courses = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                    ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                    ->join('User', 'Teacher.idUser', '=', 'User.userId')
                    ->where('idTeacher', $teacher->teacherId)
                    ->where('idCycle', 1)
                    ->select('User.name', 'User.avatar as userAvatar', 'User.role', 'Subject.subjectId', 'Subject.nameSubject', 'Subject.section', 
                    'Subject.avatar', 'Cycle.cycle')
                    ->orderBy('nameSubject')
                    ->get();

                $teams = Team::join('Research_Topic as rt', 'rt.researchTopicId', '=', 'Team.idResearchTopic')
                    ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                    ->where('Team.idTeacher', $teacher->teacherId)
                    ->where('Team.state', 'Aprobado')
                    ->select('Team.*', 'rt.*', 'Idc.idcId')
                    ->get();

                if ($courses->isEmpty() && $teams->isEmpty()) {
                    return view('layouts.tablero', compact('role'))->with('noContent', true);
                }

                if ($courses->isEmpty()) {
                    return view('layouts.tablero', compact('role', 'teams'))->with('noCourses', true);
                }

                if ($teams->isEmpty()) {
                    return view('layouts.tablero', compact('courses', 'role'))->with('noTeams', true);
                }

                return view('layouts.tablero', compact('courses', 'role', 'teams'));
            } 
            else {
                $teams = Team::join('Research_Topic as rt', 'rt.researchTopicId', '=', 'Team.idResearchTopic')
                    ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                    ->where('Idc.idUser', $idUser)
                    ->where('Team.state', 'Aprobado')
                    ->select('Team.*', 'rt.*', 'Idc.idcId')
                    ->get();

                if ($teams->isEmpty()) {
                    return view('layouts.tablero', compact('role'))->with('noTeams', true);
                }

                return view('layouts.tablero', compact('role', 'teams'));
            }
        }
    }
?>
