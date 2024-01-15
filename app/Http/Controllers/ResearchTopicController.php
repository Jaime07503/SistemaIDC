<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
    use App\Models\Subject;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class ResearchTopicController extends Controller
    {
        public function index($subjectId)
        {
            $researchTopics = ResearchTopic::where('idSubject', $subjectId)->get();
            $subject = Subject::find($subjectId);

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

        public function create(Request $request)
        {
            $subjectId = $request->input('idSubject');
            $fileIR = $request->file('importanceRegional');
            $fileIG = $request->file('importanceGlobal');
            $fileA = $request->file('avatar');

            $fileNameIR = uniqid().'.'.$fileIR->getClientOriginalExtension();
            $fileNameIG = uniqid().'.'.$fileIG->getClientOriginalExtension();
            $fileNameA = uniqid().'.'.$fileA->getClientOriginalExtension();

            $fileIR->move(public_path('images'), $fileNameIR);
            $fileIG->move(public_path('images'), $fileNameIG);
            $fileA->move(public_path('images'), $fileNameA);

            $researchTopic = new ResearchTopic;
            $researchTopic->themeName = $request->input('themeName');
            $researchTopic->description = $request->input('description');
            $researchTopic->importanceReginal = 'http://localhost/SistemaIDC/public/images/'.$fileNameIR;
            $researchTopic->importanceGlobal = 'http://localhost/SistemaIDC/public/images/'.$fileNameIG;
            $researchTopic->state = 'Por Aprobar';
            $researchTopic->avatar = 'http://localhost/SistemaIDC/public/images/'.$fileNameA;
            $researchTopic->idSubject = $subjectId;
            $researchTopic->save();

            return Redirect::route('researchTopics', ['subjectId' => $subjectId]);
        }
    }
?>