<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use App\Models\NextIdcTopicReport;
    use App\Models\ResearchTopic;
    use App\Models\ScientificArticleReport;
    use App\Models\Student;
    use App\Models\StudentResearchTopic;
    use App\Models\StudentTeam;
    use App\Models\Subject;
    use App\Models\Team;
    use App\Models\TopicSearchReport;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class TeamController extends Controller
    {
        public function getInformation($researchTopicId)
        {
            $researchTopics = ResearchTopic::where('researchTopicId', $researchTopicId)->first();
            $subject = Subject::find($researchTopics->idSubject);

            $students = Student::join('User', 'Student.idUser', '=', 'User.userId')
                ->join('Student_History', 'Student.studentId', '=', 'Student_History.idStudent')
                ->join('Student_Research_Topic', 'Student.studentId', '=', 'Student_Research_Topic.idStudent')
                ->where('Student_Research_Topic.state', '=', 'Postulado')
                ->where('Student_Research_Topic.idResearchTopic', '=', $researchTopicId)
                ->select('User.name', 'User.email', 'User.avatar', 'Student.studentId', 'Student_History.cum', 
                'Student_History.enrolledSubject')
                ->orderByDesc('Student_History.cum')
                ->get();

            if ($students->isEmpty()) {
                return view('layouts.newTeam', compact('researchTopics', 'subject'))->with('noTeams', true);
            }

            return view('layouts.newTeam', compact('researchTopics', 'subject', 'students'));
        }

        public function create(Request $request)
        {
            // Variables
            $INITIAL_STATE = 'Sin Intento';
            $INITIAL_PATH = 'Por generar';
            $INITIAL_STATE_IDC = 'Creado';
            $INITIAL_TEAM_STATE = 'Postulado';
            $studentId = session('studentId');
            $researchTopicId = $request->input('idResearchTopic');
            $subjectId = $request->input('subjectId');
            $selectedStudentIds = explode(',', $request->input('selectedStudentIds', ''));
            $integrantQuantity = count($selectedStudentIds);

            // Create team
            $team = new Team;
            $team->creationDate = Carbon::now();
            $team->integrantQuantity = $integrantQuantity;
            $team->state = 'Aprobado';
            $team->idResearchTopic = $researchTopicId;
            $team->idTeacher = $request->input('idTeacher');
            $team->save();

            // Create all the StudenTeam with studentId
            foreach ($selectedStudentIds as $studentId) {
                if (is_numeric($studentId)) {
                    $studentTeam = new StudentTeam;
                    $studentTeam->idStudent = $studentId;
                    $studentTeam->idTeam = $team->teamId;
                    $studentTeam->save();
                }
            }

            // Create Idc
            $idc = new Idc();
            $idc->startDateSearchReport = '2024-01-22 23:59:59';
            $idc->endDateSearchReport = '2024-02-29 23:59:59';
            $idc->startDateScientificArticleReport = '2024-03-01 23:59:59';
            $idc->endDateScientificArticleReport = '2024-04-30 23:59:59';
            $idc->startDateNextIdcTopic = '2024-05-01 23:59:59';
            $idc->endDateNextIdcTopic = '2024-06-15 23:59:59';
            $idc->badgeProcessCompleted = 'Por obtener';
            $idc->state = $INITIAL_STATE_IDC;
            $idc->idUser = 1;
            $idc->idTeam = $team->teamId;
            $idc->save();

            // Create empty Topic Search Report
            $searchReport = new TopicSearchReport();
            $searchReport->code = '';
            $searchReport->induction = '';
            $searchReport->searchPlan = '';
            $searchReport->meetings = '';
            $searchReport->teamValoration = '';
            $searchReport->finalComment = '';
            $searchReport->storagePath = $INITIAL_PATH;
            $searchReport->state = $INITIAL_STATE;
            $searchReport->previousState = $INITIAL_STATE;
            $searchReport->idIdc = $idc->idcId;
            $searchReport->save();

            // Create empty Scientific Article Report
            $scientificArticle = new ScientificArticleReport();
            $scientificArticle->code = '';
            $scientificArticle->spanishSummary = '';
            $scientificArticle->englishSummary = '';
            $scientificArticle->keywords = '';
            $scientificArticle->introduction = '';
            $scientificArticle->methodology = '';
            $scientificArticle->numberOfWords = '';
            $scientificArticle->storagePath = $INITIAL_PATH;
            $scientificArticle->state = $INITIAL_STATE;
            $scientificArticle->previousState = $INITIAL_STATE;
            $scientificArticle->idIdc = $idc->idcId;
            $scientificArticle->save();

            // Create empty Next Idc Topic Report
            $nextIdcTopic = new NextIdcTopicReport();
            $nextIdcTopic->code = '';
            $nextIdcTopic->introduction = '';
            $nextIdcTopic->continueTopic = '';
            $nextIdcTopic->proposeTopics = '';
            $nextIdcTopic->storagePath = $INITIAL_PATH;
            $nextIdcTopic->state = $INITIAL_STATE;
            $nextIdcTopic->previousState = $INITIAL_STATE;
            $nextIdcTopic->idIdc = $idc->idcId;
            $nextIdcTopic->save();

            foreach ($selectedStudentIds as $studentId) {
                StudentResearchTopic::where('idStudent', $studentId)
                    ->where('idResearchTopic', $researchTopicId)
                    ->update(['state' => 'Aprobado']);
            }

            $researchTopic = ResearchTopic::where('researchTopicId', $researchTopicId)->first();

            $studentResearch = Subject::join('Student_Subject', function ($join) use ($subjectId, $studentId) {
                $join->on('Subject.subjectId', '=', 'Student_Subject.idSubject')
                    ->where('Student_Subject.idStudent', '=', $studentId);
            })
            ->where('Subject.subjectId', $subjectId)
            ->select('Subject.*', 'Student_Subject.applicationCount')
            ->first();

            $postulatedSubject = ResearchTopic::join('Student_Research_Topic', function ($join) use ($researchTopicId, $studentId) {
                $join->on('Research_Topic.researchTopicId', '=', 'Student_Research_Topic.idResearchTopic')
                    ->where('Student_Research_Topic.idStudent', '=', $studentId)
                    ->where('Student_Research_Topic.idResearchTopic', '=', $researchTopicId);
            })
            ->where('Research_Topic.researchTopicId', $researchTopicId)
            ->select('Research_Topic.*', 'Student_Research_Topic.state')
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
                $students = User::join('Student', 'User.userId', '=', 'Student.idUser')
                    ->join('Student_Team', 'Student_Team.idStudent', '=', 'Student.studentId')
                    ->whereIn('Student_Team.idTeam', $studentTeamIds)
                    ->select('User.name', 'User.avatar')
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