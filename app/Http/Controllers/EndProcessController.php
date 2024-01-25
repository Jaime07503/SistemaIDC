<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use Carbon\Carbon;

    class EndProcessController extends Controller
    {
        public function getInformation($idcId, $idNextIdcTopicReport) {
            $nextIdcTopicReport = Idc::join('Next_Idc_Topic_Report', 'Idc.idcId', '=', 'Next_Idc_Topic_Report.idIdc')
                ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->select('Next_Idc_Topic_Report.storagePath', 'Next_Idc_Topic_Report.code as nextIdcTopicReportCode', 'Idc.idcId',
                'Idc.endDateNextIdcTopic','Next_Idc_Topic_Report.updated_at', 'Next_Idc_Topic_Report.state', 'Next_Idc_Topic_Report.previousState',
                'Next_Idc_Topic_Report.correctedDocStoragePath', 'Next_Idc_Topic_Report.nameCorrectedDoc', 
                'Research_Topic.researchTopicId', 'Research_Topic.code', 'Research_Topic.themeName', 'Team.teamId',
                 'Subject.subjectId')
                ->where('Idc.idcId', $idcId)
                ->first();

            if ($nextIdcTopicReport && $nextIdcTopicReport->endDateNextIdcTopic) {
                $deadline = Carbon::parse($nextIdcTopicReport->endDateNextIdcTopic);
                $updated_at = Carbon::parse($nextIdcTopicReport->updated_at);

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

            return view('layouts.endProcess', compact('nextIdcTopicReport', 'timeRemaining', 'formattedDeadline', 'formattedupdated_at', 'idNextIdcTopicReport'));
        }
    }
?>