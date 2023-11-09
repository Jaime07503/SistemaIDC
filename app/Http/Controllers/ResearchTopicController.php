<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
    use App\Models\Subject;

    class ResearchTopicController extends Controller
    {
        public function index($subjectId)
        {
            $researchTopics = ResearchTopic::where('idSubject', $subjectId)->get();
            $subject = Subject::find($subjectId);

            return view('layouts.temas', compact('researchTopics', 'subjectId', 'subject'));
        }

        public function getResearchTopicInformation($researchTopicId)
        {
            $researchTopic = ResearchTopic::where('researchTopicId', $researchTopicId)->first();

            return view('layouts.temasInformation', compact('researchTopic', 'researchTopicId'));
        }
    }
?>