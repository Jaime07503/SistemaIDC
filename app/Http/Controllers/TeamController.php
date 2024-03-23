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
    use App\Notifications\ApprovedTeam;
    use App\Notifications\PostulateTeam;
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

            $teams = Team::join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->with('studentTeam.student', 'researchTopic.subject') 
                ->where('Team.state', 'Postulado')
                ->get();

            $result = [];

            foreach ($teams as $team) {
                $students = $team->studentTeam->pluck('student');
                $userDetails = $students->map(function ($student) {
                    return $student->user; 
                });

                $result[] = [
                    'team' => $team,
                    'students' => $students,
                    'user' => $userDetails,
                ];
            }
            
            if (empty($result)) {
                return view('layouts.approveTeam', compact('researchTopics'))->with('noTeams', true);
            }

            return view('layouts.approveTeam', compact('researchTopics', 'result'));
        }

        public function approvedTeam($teamId) {
            $INITIAL_STATE = 'Sin Intento';
            $INITIAL_PATH = 'Por generar';
            $UPLOAD_PATH = 'Sin Intento';
            $INITIAL_STATE_IDC = 'En proceso';
            $APPROVED_TEAM = 'Aprobado';

            $team = Team::find($teamId);
            $team->state = $APPROVED_TEAM;
            $team->save();

            $idc = new Idc();
            $idc->badgeProcessCompleted = 'Por obtener';
            $idc->state = $INITIAL_STATE_IDC;
            $idc->idTeam = $teamId;
            $idc->save();

            $searchReport = new TopicSearchReport();
            $searchReport->code = '';
            $searchReport->storagePath = $INITIAL_PATH;
            $searchReport->nameCorrectDocument = '';
            $searchReport->correctDocumentStoragePath = $UPLOAD_PATH;
            $searchReport->nameCorrectedDocument = '';
            $searchReport->correctedDocumentStoragePath = $UPLOAD_PATH;
            $searchReport->state = $INITIAL_STATE;
            $searchReport->previousState = $INITIAL_STATE;
            $searchReport->idIdc = $idc->idcId;
            $searchReport->save();

            $scientificArticle = new ScientificArticleReport();
            $scientificArticle->code = '';
            $scientificArticle->spanishSummary = '';
            $scientificArticle->englishSummary = '';
            $scientificArticle->keywords = '';
            $scientificArticle->introduction = '';
            $scientificArticle->methodology = '';
            $scientificArticle->subtitle = '';
            $scientificArticle->secondSubtitle = '';
            $scientificArticle->thirdSubtitle = '';
            $scientificArticle->numberOfWords = 0;
            $scientificArticle->storagePath = $INITIAL_PATH;
            $scientificArticle->nameDocumentImage = '';
            $scientificArticle->documentImageStoragePath = $UPLOAD_PATH;
            $scientificArticle->nameCorrectDocument = '';
            $scientificArticle->correctDocumentStoragePath = $UPLOAD_PATH;
            $scientificArticle->nameCorrectedDocument = '';
            $scientificArticle->correctedDocumentStoragePath = $UPLOAD_PATH;
            $scientificArticle->state = $INITIAL_STATE;
            $scientificArticle->previousState = $INITIAL_STATE;
            $scientificArticle->idIdc = $idc->idcId;
            $scientificArticle->save();

            $nextIdcTopic = new NextIdcTopicReport();
            $nextIdcTopic->code = '';
            $nextIdcTopic->storagePath = $INITIAL_PATH;
            $nextIdcTopic->nameCorrectDocument = '';
            $nextIdcTopic->correctDocumentStoragePath = $UPLOAD_PATH;
            $nextIdcTopic->nameCorrectedDocument = '';
            $nextIdcTopic->correctedDocumentStoragePath = $UPLOAD_PATH;
            $nextIdcTopic->state = $INITIAL_STATE;
            $nextIdcTopic->previousState = $INITIAL_STATE;
            $nextIdcTopic->idIdc = $idc->idcId;
            $nextIdcTopic->save();

            $data = Team::join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->join('Teacher', 'Team.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->where('Team.teamId', $teamId)
                ->select('Research_Topic.researchTopicId', 'Subject.subjectId', 'User.userId')
                ->first();

            $user = User::find($data->userId);
            $user->notify(new ApprovedTeam($data->researchTopicId, $data->subjectId));

            $students = $team->studentTeam->pluck('student');

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new ApprovedTeam($data->researchTopicId, $data->subjectId));
            }

            return redirect()->route('approveTeam');
        }

        public function create(Request $request)
        {
            $INITIAL_TEAM_STATE = 'Postulado';
            $studentId = session('studentId');
            $researchTopicId = $request->input('idResearchTopic');
            $subjectId = $request->input('subjectId');
            $selectedStudentIds = explode(',', $request->input('selectedStudentIds', ''));
            $integrantQuantity = count($selectedStudentIds);

            $team = new Team;
            $team->creationDate = Carbon::now();
            $team->integrantQuantity = $integrantQuantity;
            $team->state = $INITIAL_TEAM_STATE;
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

            $data = Team::join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->where('Team.teamId', $team->teamId)
                ->select('Research_Topic.researchTopicId', 'Subject.subjectId')
                ->first();

            $processAdmins = User::select('userId')
            ->where('role', 'Administrador del Proceso')
            ->get();

            foreach ($processAdmins as $processAdmin) {
                $user = User::find($processAdmin->userId);
                $user->notify(new PostulateTeam($data->researchTopicId, $data->subjectId));
            }
            return redirect()->route('researchTopicInformation', compact('researchTopicId', 'subjectId'));
        }
    }
?>