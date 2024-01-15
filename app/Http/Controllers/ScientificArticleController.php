<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use Carbon\Carbon;

    class ScientificArticleController extends Controller
    {
        public function getInformation($idcId, $idScientificArticleReport) {
            $scientificArticle = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Scientific_Article_Report', 'Idc.idcId', '=', 'Scientific_Article_Report.idIdc')
                ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->select('Idc.endDateScientificArticleReport', 'Idc.idcId',
                'Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                'Team.teamId', 'Subject.subjectId',  'Scientific_Article_Report.state', 'Scientific_Article_Report.code AS scientificArticleCode',
                'Scientific_Article_Report.updated_at', 'Scientific_Article_Report.storagePath')
                ->where('Idc.idcId', $idcId)
                ->first();

            if ($scientificArticle && $scientificArticle->endDateScientificArticleReport) {
                $deadline = Carbon::parse($scientificArticle->endDateScientificArticleReport);
                $updated_at = Carbon::parse($scientificArticle->updated_at);

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

            return view('layouts.scientificArticle', compact('scientificArticle', 'timeRemaining', 'formattedDeadline', 'formattedupdated_at', 'idScientificArticleReport'));
        }
    }
?>