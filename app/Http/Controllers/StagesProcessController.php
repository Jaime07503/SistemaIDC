<?php
    namespace App\Http\Controllers;
    use App\Models\IDCDates;
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
                'Subject.subjectId', 'Team.teamId', 'Idc.idcId',
                'Topic_Search_Report.topicSearchReportId',
                'Scientific_Article_Report.scientificArticleReportId', 'Next_Idc_Topic_Report.nextIdcTopicReportId')
                ->first();

            $dates = IDCDates::select('Idc_Date.startDateSearchReport', 'Idc_Date.endDateSearchReport', 
                'Idc_Date.startDateScientificArticleReport', 'Idc_Date.endDateScientificArticleReport', 
                'Idc_Date.startDateNextIdcTopic', 'Idc_Date.endDateNextIdcTopic')->first();

            $now = Carbon::now();

            $researchTopic->canShowStageCard = false;
            $researchTopic->canShowLastStageCard = false;

            if ($now > Carbon::parse($dates->startDateScientificArticleReport)) {
                $researchTopic->canShowStageCard = true;
            }

            if ($now > Carbon::parse($dates->startDateNextIdcTopic)) {
                $researchTopic->canShowLastStageCard = true;
            }

            return view('layouts.stagesProcess', compact('researchTopic'));
        }
    }
?>