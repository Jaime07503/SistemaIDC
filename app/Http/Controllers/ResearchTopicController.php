<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
    use App\Models\StudentSubject;
    use App\Models\Subject;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class ResearchTopicController extends Controller
    {
        public function index($subjectId)
        {
            $researchTopics = ResearchTopic::where('idSubject', $subjectId)->get();
            $subject = Subject::join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->find($subjectId);
            
            if ($subject->userId !== auth()->user()->userId) {
                $isStudentOfSubject = StudentSubject::where('idStudent', auth()->user()->userId)
                                                    ->where('idSubject', $subjectId)
                                                    ->exists();
                if (!$isStudentOfSubject) {
                    return redirect()->back();
                }
            }

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
            $fileA = $request->file('Avatar');

            $fileNameIR = uniqid().'.'.$fileIR->getClientOriginalExtension();
            $fileNameIG = uniqid().'.'.$fileIG->getClientOriginalExtension();
            $fileNameA = uniqid().'.'.$fileA->getClientOriginalExtension();

            $fileIR->move(public_path('images'), $fileNameIR);
            $fileIG->move(public_path('images'), $fileNameIG);
            $fileA->move(public_path('images'), $fileNameA);

            $researchTopic = new ResearchTopic;
            $researchTopic->code = $request->input('code');
            $researchTopic->themeName = $request->input('themeName');
            $researchTopic->description = $request->input('description');
            $researchTopic->avatar = 'http://localhost/SistemaIDC/public/images/'.$fileNameA;
            $researchTopic->importanceRegional = 'http://localhost/SistemaIDC/public/images/'.$fileNameIR;
            $researchTopic->importanceGlobal = 'http://localhost/SistemaIDC/public/images/'.$fileNameIG;
            $researchTopic->state = $TO_BE_APPROVED;
            $researchTopic->idSubject = $subjectId;
            $researchTopic->save();

            return Redirect::route('researchTopics', ['subjectId' => $subjectId]);
        }

        public function approveResearchTopic() {
            $topics = ResearchTopic::join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->where('Research_Topic.state', 'Por aprobar')
                ->get();
            
            $subjects = Subject::all();

            return view('layouts.approveResearchTopics', compact('topics', 'subjects'));
        }

        public function approvedTopic($researchTopicId) {
            $APPROVE_STATE = 'Aprobado';
            $researchTopic = ResearchTopic::find($researchTopicId);

            $researchTopic->state = $APPROVE_STATE;

            $researchTopic->save();

            return redirect()->route('approveResearchTopics');
        }
    }
?>