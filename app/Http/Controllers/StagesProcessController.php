<?php
    namespace App\Http\Controllers;

    use App\Models\ResearchTopic;
    use Illuminate\Http\Request;

    class StagesProcessController extends Controller
    {
        public function getResearchTopic($researchTopicId) 
        {
            $researchTopic = ResearchTopic::where('researchTopicId', $researchTopicId)->first();

            return view('layouts.stagesProcess', compact('researchTopic'));
        }
    }
?>