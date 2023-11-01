<?php
    namespace App\Http\Controllers;

    use App\Models\ResearchTopic as ModelsResearchTopic;

    class ResearchTopic extends Controller
    {
        public function index($subjectId)
        {
            $researchTopics = ModelsResearchTopic::where('idSubject', $subjectId)->get();

            return view('layouts.temas', compact('researchTopics', 'subjectId'));
        }
    }
?>