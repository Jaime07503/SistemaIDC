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
    use App\Notifications\NewTeam;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class TeamController extends Controller
    {
        public function getInformation($researchTopicId)
        {
            $researchTopics = ResearchTopic::where('researchTopicId', $researchTopicId)->first();
            $subject = Subject::join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->find($researchTopics->idSubject);
    
            if ($subject->userId !== auth()->user()->userId) {
                return redirect()->back();
            }

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

        public function approveTeam() {
            $researchTopics = ResearchTopic::all();

            
        }

        public function create(Request $request)
        {
            $INITIAL_STATE = 'Sin Intento';
            $INITIAL_PATH = 'Por generar';
            $UPLOAD_PATH = 'Por subir';
            $INITIAL_STATE_IDC = 'En proceso';
            $INITIAL_TEAM_STATE = 'Postulado';
            $studentId = session('studentId');
            $researchTopicId = $request->input('idResearchTopic');
            $subjectId = $request->input('subjectId');
            $selectedStudentIds = explode(',', $request->input('selectedStudentIds', ''));
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

            $idc = new Idc();
            $idc->badgeProcessCompleted = 'Por obtener';
            $idc->state = $INITIAL_STATE_IDC;
            $idc->idUser = 1;
            $idc->idTeam = $team->teamId;
            $idc->save();

            $searchReport = new TopicSearchReport();
            $searchReport->code = '';
            $searchReport->storagePath = $INITIAL_PATH;
            $searchReport->state = $INITIAL_STATE;
            $searchReport->previousState = $INITIAL_STATE;
            $searchReport->nameCorrectDocument = '';
            $searchReport->correctDocumentStoragePath = $UPLOAD_PATH;
            $searchReport->nameCorrectedDocument = '';
            $searchReport->correctedDocumentStoragePath = $UPLOAD_PATH;
            $searchReport->idIdc = $idc->idcId;
            $searchReport->save();

            $scientificArticle = new ScientificArticleReport();
            $scientificArticle->code = '';
            $scientificArticle->numberOfWords = 0;
            $scientificArticle->storagePath = $INITIAL_PATH;
            $scientificArticle->state = $INITIAL_STATE;
            $scientificArticle->previousState = $INITIAL_STATE;
            $scientificArticle->nameDocumentImage = '';
            $scientificArticle->documentImageStoragePath = $UPLOAD_PATH;
            $scientificArticle->nameCorrectDocument = '';
            $scientificArticle->correctDocumentStoragePath = $UPLOAD_PATH;
            $scientificArticle->nameCorrectedDocument = '';
            $scientificArticle->correctedDocumentStoragePath = $UPLOAD_PATH;
            $scientificArticle->idIdc = $idc->idcId;
            $scientificArticle->save();

            $nextIdcTopic = new NextIdcTopicReport();
            $nextIdcTopic->code = '';
            $nextIdcTopic->storagePath = $INITIAL_PATH;
            $nextIdcTopic->state = $INITIAL_STATE;
            $nextIdcTopic->previousState = $INITIAL_STATE;
            $nextIdcTopic->nameCorrectDocument = '';
            $nextIdcTopic->correctDocumentStoragePath = $UPLOAD_PATH;
            $nextIdcTopic->nameCorrectedDocument = '';
            $nextIdcTopic->correctedDocumentStoragePath = $UPLOAD_PATH;
            $nextIdcTopic->idIdc = $idc->idcId;
            $nextIdcTopic->save();

            foreach ($selectedStudentIds as $studentId) {
                StudentResearchTopic::where('idStudent', $studentId)
                    ->where('idResearchTopic', $researchTopicId)
                    ->update(['state' => 'Aprobado']);
            }

            $researchTopic = ResearchTopic::where('researchTopicId', $researchTopicId)->first();
            $subject = Subject::where('subjectId', $subjectId)->first();

            $teams = Team::where('idResearchTopic', $researchTopicId)
                ->with('studentTeam.student')
                ->get();

            foreach ($teams as $team) {
                $studentTeamIds = StudentTeam::where('idTeam', $team->teamId)->pluck('idStudent')->toArray();
            
                $students = $team->studentTeam->pluck('student');
            }

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new NewTeam($researchTopicId, $subjectId));
            }

            return redirect()->route('researchTopicInformation', compact('researchTopicId', 'subjectId'));
        }
    }
?>