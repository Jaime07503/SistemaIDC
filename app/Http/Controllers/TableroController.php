<?php
    namespace App\Http\Controllers;

    use App\Models\ResearchTopic;
    use App\Models\Student;
    use App\Models\StudentResearchTopic;
    use App\Models\StudentTeam;
    use App\Models\Subject;
    use App\Models\Teacher;
    use App\Models\Team;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class TableroController extends Controller
    {
        public function getResearchTopics()
        {
            $idUser = session('userId');
            $role = session('role');

            if($role == 'Estudiante'){
                $student = Student::whereHas('user', function ($query) use ($idUser){
                    $query->where('userId', $idUser);
                })->first();

                session(['studentId' => $student->studentId]);

                $studentId = $student->studentId;

                $teams = StudentTeam::join('team as t', 't.teamId', '=', 'student_team.idTeam')
                    ->join('research_topic as rt', 'rt.researchTopicId', '=', 't.idResearchTopic')
                    ->where('student_team.idStudent', $studentId)
                    ->select('student_team.idStudentTeam', 't.*', 'rt.*')
                    ->get();

                return view('layouts.tablero', compact('role', 'teams'));
            } else {
                $teacher = Teacher::whereHas('user', function ($query) use ($idUser) {
                    $query->where('userId', $idUser);
                })->first();

                $teams = Team::join('research_topic as rt', 'rt.researchTopicId', '=', 'team.idResearchTopic')
                    ->where('team.idTeacher', $teacher->teacherId)
                    ->where('team.state', 'Aprobado')
                    ->select('team.*', 'rt.*')
                    ->get();
            }

            return view('layouts.tablero', compact('role', 'teams'));
        }
    }
?>