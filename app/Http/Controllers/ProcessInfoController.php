<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;

    class ProcessInfoController extends Controller
    {
        public function getResearchTopic($researchTopicId) 
        {
            $researchTopic = ResearchTopic::join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->join('Team', 'Research_Topic.researchTopicId', '=', 'Team.idResearchTopic')
                ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                ->where('Research_Topic.researchTopicId', $researchTopicId)
                ->select('Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                'Subject.subjectId', 'Team.teamId', 'Idc.idcId')
                ->first();

            return view('layouts.processInfo', compact('researchTopic'));
        }
    }
?>