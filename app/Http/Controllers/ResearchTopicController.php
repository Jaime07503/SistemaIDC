<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
    use App\Models\StudentSubject;
    use App\Models\Subject;
    use App\Models\Topic;
    use App\Models\User;
    use App\Notifications\ApprovedResearchTopic;
    use App\Notifications\PostulateResearchTopic;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class ResearchTopicController extends Controller
    {
        public function index($subjectId)
        {
            $subject = Subject::join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->find($subjectId);

            $researchTopics = ResearchTopic::where('idSubject', $subjectId)->get();

            // if(auth()->user()->role === 'Docente') {
            //     if ($subject->userId !== auth()->user()->userId) {
            //         $isStudentOfSubject = StudentSubject::where('idStudent', session('studentId'))
            //             ->where('idSubject', $subjectId)
            //             ->exists();

            //     if (!$isStudentOfSubject) {
            //         return redirect()->back();
            //     }
            //     }
            // } else {
            //     $isStudentOfSubject = StudentSubject::where('idStudent', session('studentId'))
            //         ->where('idSubject', $subjectId)
            //         ->exists();

            //     if (!$isStudentOfSubject) {
            //         return redirect()->back();
            //     }
            // }
            
            if ($researchTopics->isEmpty()) {
                return view('layouts.researchTopics', compact('subjectId', 'subject'))->with('noTopics', true);
            }

            return view('layouts.researchTopics', compact('researchTopics', 'subjectId', 'subject'));
        }

        public function getInformation($subjectId)
        {
            $researchTopics = ResearchTopic::where('idSubject', $subjectId)->get();
            $subject = Subject::find($subjectId);

            return view('layouts.newResearhTopic', compact('researchTopics', 'subjectId', 'subject'));
        }

        public function create(Request $request, $subjectId)
        {
            $TO_BE_APPROVED = 'Por aprobar';
            $fileIR = $request->file('Imagen-Importancia-Local');
            $fileIG = $request->file('Imagen-Importancia-Global');

            $subject = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->select('Subject.nameSubject', 'Subject.section', 'Cycle.cycle')
                ->find($subjectId);

            $themeName = $request->input('themeName');
            $themeWords = explode(' ', $themeName);
            $themeInitials = '';
            foreach ($themeWords as $word) {
                $themeInitials .= strtoupper(substr($word, 0, 1));
            }

            $words = explode(' ', $subject->nameSubject);
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }

            if (preg_match('/\bI\b/', $subject->cycle)) {
                $cycleType = 'I';
            } elseif (preg_match('/\bII\b/', $subject->cycle)) {
                $cycleType = 'II';
            }

            $year = substr($subject->cycle, -4);

            $code = $initials . '-' . $subject->section . '-' . $cycleType . substr($year, -2). '-' . $themeInitials;

            $researchTopic = new ResearchTopic;
            $researchTopic->code = $code;
            $researchTopic->themeName = $request->input('themeName');
            $researchTopic->description = $request->input('description');
            $researchTopic->avatar = 'http://localhost/SistemaIDC/public/images/curso_logo.webp';
            if ($fileIR !== null) {
                $fileNameIR = uniqid().'.'.$fileIR->getClientOriginalExtension();
                $fileIR->move(public_path('images'), $fileNameIR);
                $researchTopic->importanceRegional = 'http://localhost/SistemaIDC/public/images/'.$fileNameIR;
            } elseif ($fileIG !== null) {
                $fileNameIG = uniqid().'.'.$fileIG->getClientOriginalExtension();
                $fileIG->move(public_path('images'), $fileNameIG);
                $researchTopic->importanceGlobal = 'http://localhost/SistemaIDC/public/images/'.$fileNameIG;
            } elseif($fileIR !== null && $fileIG !== null) {
                $fileNameIR = uniqid().'.'.$fileIR->getClientOriginalExtension();
                $fileNameIG = uniqid().'.'.$fileIG->getClientOriginalExtension();

                $fileIR->move(public_path('images'), $fileNameIR);
                $fileIG->move(public_path('images'), $fileNameIG);

                $researchTopic->importanceRegional = 'http://localhost/SistemaIDC/public/images/'.$fileNameIR;
                $researchTopic->importanceGlobal = 'http://localhost/SistemaIDC/public/images/'.$fileNameIG;
            }
            $researchTopic->state = $TO_BE_APPROVED;
            $researchTopic->idSubject = $subjectId;
            $researchTopic->save();

            $users = User::where('role', 'Administrador del Proceso');

            foreach ($users as $user) {
                $user = User::find($users->userId);
                $user->notify(new PostulateResearchTopic($subjectId));
            }

            return Redirect::route('researchTopics', ['subjectId' => $subjectId]);
        }

        public function addTopicIdc($subjectId, $topicId) {
            $STATE_APPROVED = 'Aprobado';

            $subject = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
            ->select('Subject.nameSubject', 'Subject.section', 'Cycle.cycle')
            ->find($subjectId);

            $topic = Topic::find($topicId);
            $topic->state = $STATE_APPROVED;
            $topic->save();

            $themeName = $topic->nameTopic;
    
            $themeWords = explode(' ', $themeName);
            $themeInitials = '';
            foreach ($themeWords as $word) {
                $themeInitials .= strtoupper(substr($word, 0, 1));
            }
            $themeInitials = substr($themeInitials, 0, 3);

            $words = explode(' ', $subject->nameSubject);
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }

            if (preg_match('/\bI\b/', $subject->cycle)) {
                $cycleType = 'I';
            } elseif (preg_match('/\bII\b/', $subject->cycle)) {
                $cycleType = 'II';
            }

            $year = substr($subject->cycle, -4);

            $code = $initials . '-' . $subject->section . '-' . $cycleType . substr($year, -2). '-' . $themeInitials;

            $researchTopic = new ResearchTopic;
            $researchTopic->code = $code;
            $researchTopic->themeName = $themeName;
            $researchTopic->description = $topic->description;
            $researchTopic->avatar = 'http://localhost/SistemaIDC/public/images/curso_logo.webp';
            $researchTopic->importanceRegional = $topic->localUpdateImg;
            $researchTopic->importanceGlobal = $topic->globalUpdateImg;
            $researchTopic->state = $STATE_APPROVED;
            $researchTopic->idSubject = $subjectId;
            $researchTopic->save();

            return Redirect::route('researchTopics', ['subjectId' => $subjectId]);
        }

        public function approveResearchTopic() {
            $researchTopics = ResearchTopic::join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->where('Research_Topic.state', 'Por aprobar')
                ->get();

            $topics = Topic::where('state', 'Seleccionado')
                ->get();
            
            $subjects = Subject::all();

            if ($researchTopics->isEmpty()) {
                return view('layouts.approveResearchTopics', compact('subjects', 'topics'))->with('noTopics', true);
            }

            return view('layouts.approveResearchTopics', compact('researchTopics', 'subjects', 'topics'));
        }

        public function approvedTopic($researchTopicId) {
            $APPROVE_STATE = 'Aprobado';
            $researchTopic = ResearchTopic::find($researchTopicId);
            $researchTopic->state = $APPROVE_STATE;
            $researchTopic->save();

            $data = ResearchTopic::join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->where('Research_Topic.researchTopicId', $researchTopicId)
                ->select('User.userId', 'Subject.subjectId')
                ->first();

            $user = User::find($data->userId);
            $user->notify(new ApprovedResearchTopic($data->subjectId));

            return redirect()->route('approveResearchTopics');
        }
    }
?>