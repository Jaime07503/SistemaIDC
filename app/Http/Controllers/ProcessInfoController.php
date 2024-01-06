<?php
    namespace App\Http\Controllers;

    use App\Models\ResearchTopic;
    use Illuminate\Http\Request;

    class ProcessInfoController extends Controller
    {
        public function getResearchTopic($researchTopicId) 
        {
            $researchTopic = ResearchTopic::join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->where('Research_Topic.researchTopicId', $researchTopicId)
                ->select('Research_Topic.themeName', 'Subject.code')
                ->first();

            return view('layouts.processInfo', compact('researchTopic'));
        }
    }
?>