<?php
    namespace App\Http\Controllers;
    use App\Models\NextIdcTopicReport;
    use App\Models\ScientificArticleReport;
    use App\Models\TopicSearchReport;

    class GenerateDocumentsController extends Controller
    {
        public function getGenerateDocuments() {
            $topicSearchReports = TopicSearchReport::join('Idc', 'Topic_Search_Report.idIdc', '=', 'Idc.idcId')
                ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->select('Topic_Search_Report.topicSearchReportId', 'Topic_Search_Report.idIdc','Topic_Search_Report.code', 
                'Topic_Search_Report.storagePath', 'Topic_Search_Report.nameCorrectDocument', 'Topic_Search_Report.correctDocumentStoragePath', 
                'Topic_Search_Report.nameCorrectedDocument', 'Topic_Search_Report.correctedDocumentStoragePath', 'Topic_Search_Report.state', 'Team.teamId')
                ->get();

            $scientificArticleReports = ScientificArticleReport::join('Idc', 'Scientific_Article_Report.idIdc', '=', 'Idc.idcId')
                ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->select('Scientific_Article_Report.scientificArticleReportId', 'Scientific_Article_Report.idIdc','Scientific_Article_Report.code', 
                'Scientific_Article_Report.storagePath', 'Scientific_Article_Report.nameDocumentImage', 'Scientific_Article_Report.documentImageStoragePath', 
                'Scientific_Article_Report.nameCorrectDocument', 'Scientific_Article_Report.correctDocumentStoragePath', 'Scientific_Article_Report.nameCorrectedDocument', 
                'Scientific_Article_Report.correctedDocumentStoragePath', 'Scientific_Article_Report.state', 'Team.teamId')
                ->get();

            $nextIdcTopicReports = NextIdcTopicReport::join('Idc', 'Next_Idc_Topic_Report.idIdc', '=', 'Idc.idcId')
                ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->select('Next_Idc_Topic_Report.nextIdcTopicReportId', 'Next_Idc_Topic_Report.idIdc','Next_Idc_Topic_Report.code', 
                'Next_Idc_Topic_Report.storagePath', 'Next_Idc_Topic_Report.nameCorrectDocument', 'Next_Idc_Topic_Report.correctDocumentStoragePath', 
                'Next_Idc_Topic_Report.nameCorrectedDocument', 'Next_Idc_Topic_Report.correctedDocumentStoragePath', 'Next_Idc_Topic_Report.state', 'Team.teamId')
                ->get();

            return view('layouts.generateDocuments', compact('scientificArticleReports', 'topicSearchReports', 'nextIdcTopicReports'));
        }
    }
?>