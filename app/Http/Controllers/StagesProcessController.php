<?php
    namespace App\Http\Controllers;

    use App\Models\ResearchTopic;
    use Illuminate\Http\Request;

    class StagesProcessController extends Controller
    {
        public function getResearchTopic($researchTopicId) 
        {
            $researchTopic = ResearchTopic::join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->where('Research_Topic.researchTopicId', $researchTopicId)
                ->select('Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Subject.subjectId', 'Subject.code')
                ->first();

            return view('layouts.stagesProcess', compact('researchTopic'));
        }
    }
?>