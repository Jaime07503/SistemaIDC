<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
use App\Models\StudentResearchTopic;
use App\Models\StudentTeam;
use App\Models\Subject;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

    class TeamController extends Controller
    {
        public function getInformation($researchTopicId)
        {
            $researchTopics = ResearchTopic::where('researchTopicId', $researchTopicId)->first();
            $subject = Subject::find($researchTopics->idSubject);

            $idStudent = session('studentId');
            $students = DB::table('user as u')
                ->select('u.name', 'u.avatar', 's.studentId')
                ->join('student as s', 'u.userId', '=', 's.idUser')
                ->join('student_research_topic as srt', 's.studentId', '=', 'srt.idStudent')
                ->where('srt.state', '=', 'Postulado')
                ->where('srt.idResearchTopic', '=', $researchTopicId)
                ->get();

            return view('layouts.newTeam', compact('researchTopics', 'subject', 'students'));
        }

        public function create(Request $request)
        {
            $selectedStudentIds = explode(',', $request->input('selectedStudentIds', ''));
            $researchTopicId = $request->input('idResearchTopic');
            $subjectId = $request->input('subjectId');
            $integrantQuantity = count($selectedStudentIds);

            $team = new Team;
            $team->creationDate = Carbon::now();
            $team->integrantQuantity = $integrantQuantity;
            $team->state = 'Aprobado';
            $team->idResearchTopic = $researchTopicId;
            $team->idTeacher = $request->input('idTeacher');
            $team->save();

            foreach ($selectedStudentIds as $studentId) {
                if (is_numeric($studentId)) {
                    $studentTeam = new StudentTeam;
                    $studentTeam->idStudent = $studentId;
                    $studentTeam->idTeam = $team->teamId;
                    $studentTeam->save();
                }
            }

            foreach ($selectedStudentIds as $studentId) {
                StudentResearchTopic::where('idStudent', $studentId)
                    ->where('idResearchTopic', $researchTopicId)
                    ->update(['state' => 'Aprobado']);
            }

            $studentId = session('studentId');
            $researchTopic = ResearchTopic::where('researchTopicId', $researchTopicId)->first();

            $studentResearch = Subject::join('student_subject', function ($join) use ($subjectId, $studentId) {
                $join->on('subject.subjectId', '=', 'student_subject.idSubject')
                    ->where('student_subject.idStudent', '=', $studentId);
            })
            ->where('subject.subjectId', $subjectId)
            ->select('subject.*', 'student_subject.applicationCount')
            ->first();

            $postulatedSubject = ResearchTopic::join('student_research_topic', function ($join) use ($researchTopicId, $studentId) {
                $join->on('research_topic.researchTopicId', '=', 'student_research_topic.idResearchTopic')
                    ->where('student_research_topic.idStudent', '=', $studentId)
                    ->where('student_research_topic.idResearchTopic', '=', $researchTopicId);
            })
            ->where('research_topic.researchTopicId', $researchTopicId)
            ->select('research_topic.*', 'student_research_topic.state')
            ->first();

            // Obtener todos los equipos (teams) asociados al $researchTopicId
            $teams = Team::where('idResearchTopic', $researchTopicId)
                ->with('studentTeam.student') // Cargar la relación studentTeam y, a través de ella, cargar la relación student
                ->get();

            $students = null;
            $team = null;
             
            // Inicializar un array para almacenar los resultados finales
            $result = [];

            // Recorrer cada equipo para obtener los estudiantes asociados
            foreach ($teams as $team) {
                // Obtener los idStudent asociados a este equipo desde la tabla student_team
                $studentTeamIds = StudentTeam::where('idTeam', $team->teamId)->pluck('idStudent')->toArray();
            
                // Utilizar los IDs de los equipos en la consulta
                $students = User::join('student', 'user.userId', '=', 'student.idUser')
                    ->join('student_team', 'student_team.idStudent', '=', 'student.studentId')
                    ->whereIn('student_team.idTeam', $studentTeamIds)
                    ->select('user.name', 'user.avatar')
                    ->get();
                }

                $result[] = [
                'team' => $team,
                'students' => $students,
            ];

            return Redirect::route('researchTopicInformation', compact('researchTopic', 'researchTopicId', 'studentResearch', 'postulatedSubject' , 'studentId', 'subjectId', 'result'));
        }
    }
?>