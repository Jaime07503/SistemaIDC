<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
    use Carbon\Carbon;

    class StagesProcessController extends Controller
    {
        public function getResearchTopic($researchTopicId, $teamId, $idcId) 
        {
            $researchTopic = ResearchTopic::join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->join('Team', 'Research_Topic.researchTopicId', '=', 'Team.idResearchTopic')
                ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                ->join('Topic_Search_Report', 'Idc.idcId','=', 'Topic_Search_Report.idIdc')
                ->join('Scientific_Article_Report', 'Idc.idcId','=', 'Scientific_Article_Report.idIdc')
                ->join('Next_Idc_Topic_Report', 'Idc.idcId','=', 'Next_Idc_Topic_Report.idIdc')
                ->where('Research_Topic.researchTopicId', $researchTopicId)
                ->where('Idc.idcId', $idcId)
                ->select('Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                'Subject.subjectId', 'Team.teamId', 'Idc.idcId', 'Idc.startDateSearchReport', 'Idc.endDateSearchReport', 
                'Idc.startDateScientificArticleReport', 'Idc.endDateScientificArticleReport', 
                'Idc.startDateNextIdcTopic', 'Idc.endDateNextIdcTopic',
                'Topic_Search_Report.topicSearchReportId',
                'Scientific_Article_Report.scientificArticleReportId', 'Next_Idc_Topic_Report.nextIdcTopicReportId')
                ->first();

            $now = Carbon::now();

            $researchTopic->canShowStageCard = false;

            if ($now > Carbon::parse($researchTopic->startDateScientificArticleReport)) {
                $researchTopic->canShowStageCard = true;
            }

            return view('layouts.stagesProcess', compact('researchTopic'));
        }
    }
?>