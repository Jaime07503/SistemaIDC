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

                $teams = StudentTeam::join('Team as t', 't.teamId', '=', 'Student_Team.idTeam')
                    ->join('Research_Topic as rt', 'rt.researchTopicId', '=', 't.idResearchTopic')
                    ->where('Student_Team.idStudent', $studentId)
                    ->select('Student_Team.studentTeamId', 't.*', 'rt.*')
                    ->get();

                return view('layouts.tablero', compact('role', 'teams'));
            } else {
                $teacher = Teacher::whereHas('user', function ($query) use ($idUser) {
                    $query->where('userId', $idUser);
                })->first();

                $teams = Team::join('Research_Topic as rt', 'rt.researchTopicId', '=', 'Team.idResearchTopic')
                    ->where('Team.idTeacher', $teacher->teacherId)
                    ->where('Team.state', 'Aprobado')
                    ->select('Team.*', 'rt.*')
                    ->get();
            }

            return view('layouts.tablero', compact('role', 'teams'));
        }
    }
?>