<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use Carbon\Carbon;

    class SearchInformationController extends Controller
    {
        public function getInformation($idcId, $idTopicSearchReport) {
            $searchReport = Idc::join('Topic_Search_Report', 'Idc.idcId', '=', 'Topic_Search_Report.idIdc')
                ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->select('Idc.endDateSearchReport', 'Topic_Search_Report.state', 'Topic_Search_Report.storagePath',
                'Idc.idcId', 'Topic_Search_Report.updated_at', 'Topic_Search_Report.previousState','Research_Topic.researchTopicId', 
                'Topic_Search_Report.correctedDocStoragePath', 'Topic_Search_Report.nameCorrectedDoc', 
                'Research_Topic.themeName', 'Research_Topic.code', 'Subject.subjectId', 'Team.teamId', 
                'Topic_Search_Report.code as searchReportCode')
                ->where('Topic_Search_Report.topicSearchReportId', $idTopicSearchReport)
                ->first();

            if ($searchReport && $searchReport->endDateSearchReport) {
                $deadline = Carbon::parse($searchReport->endDateSearchReport);
                $updated_at = Carbon::parse($searchReport->updated_at);

                $diff = Carbon::now()->diff($deadline);

                $days = $diff->days;
                $hours = $diff->h;
                $minutes = $diff->i;
                $seconds = $diff->s;

                $timeRemaining = '';

                if ($days > 0) {
                    $timeRemaining .= "{$days} días ";
                }

                if ($hours > 0) {
                    $timeRemaining .= "{$hours} horas ";
                }

                if ($minutes > 0) {
                    $timeRemaining .= "{$minutes} minutos ";
                }

                if ($seconds > 0) {
                    $timeRemaining .= "{$seconds} segundos";
                }

                if (empty($timeRemaining)) {
                    $timeRemaining = 'Menos de un segundo';
                }

                $formattedDeadline = $deadline->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                $formattedupdated_at = $updated_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
            } else {
                $timeRemaining = 'Fecha no válida o informe no encontrado';
                $formattedDeadline = 'Fecha no válida o informe no encontrado';
            }

            return view('layouts.searchInformation', compact('searchReport', 'timeRemaining', 'formattedDeadline', 'formattedupdated_at', 'idTopicSearchReport'));
        }
    }
?>