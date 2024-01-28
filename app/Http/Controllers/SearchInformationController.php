<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use App\Models\TopicSearchReport;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class SearchInformationController extends Controller
    {
        public function getInformation($idcId, $idTopicSearchReport) {
            $searchReport = Idc::join('Topic_Search_Report', 'Idc.idcId', '=', 'Topic_Search_Report.idIdc')
                ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->select('Idc.endDateSearchReport', 'Topic_Search_Report.state', 'Topic_Search_Report.storagePath',
                'Idc.idcId', 'Topic_Search_Report.updated_at', 'Topic_Search_Report.previousState','Research_Topic.researchTopicId', 
                'Topic_Search_Report.correctDocumentStoragePath', 'Topic_Search_Report.nameCorrectDocument',
                'Topic_Search_Report.correctedDocumentStoragePath', 'Topic_Search_Report.nameCorrectedDocument', 
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

        public function approveTopicSearchReport($idcId, $idTopicSearchReport) {
            $APPROVE_STATE = 'Aprobado';
            $topicSearchReport = TopicSearchReport::find($idTopicSearchReport);
    
            $topicSearchReport->state = $APPROVE_STATE;
    
            $topicSearchReport->save();

            return redirect()->route('searchInformation', compact('idcId', 'idTopicSearchReport'));
        }

        public function approveCorrectedTopicSearchReport($idcId, $idTopicSearchReport) {
            $APPROVE_STATE = 'Aprobado';
            $PREVIOUS_STATE = 'Corregido';
            $topicSearchReport = TopicSearchReport::find($idTopicSearchReport);
    
            $topicSearchReport->state = $APPROVE_STATE;
            $topicSearchReport->previousState = $PREVIOUS_STATE;
    
            $topicSearchReport->save();

            return redirect()->route('searchInformation', compact('idcId', 'idTopicSearchReport'));
        }

        public function correctTopicSearchReport($idcId, $idTopicSearchReport, Request $request) {
            $CORRECT_STATE = 'Debe corregirse';
            $topicSearchReport = TopicSearchReport::find($idTopicSearchReport);
    
            if($request->hasFile('archivoCorrecciones')) {
                $file = $request->file('archivoCorrecciones');

                $fileName = $file->getClientOriginalName();

                $topicSearchReport->nameCorrectDocument = $fileName;
                $topicSearchReport->correctDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $topicSearchReport->state = $CORRECT_STATE;
            $topicSearchReport->save();

            return redirect()->route('searchInformation', compact('idcId', 'idTopicSearchReport'));
        }

        public function correctedTopicSearchReport($idcId, $idTopicSearchReport, Request $request) {
            $CORRECTED_STATE = 'Corregido';
            $topicSearchReport = TopicSearchReport::find($idTopicSearchReport);
    
            if($request->hasFile('archivoCorregido')) {
                $file = $request->file('archivoCorregido');

                $fileName = $file->getClientOriginalName();

                $topicSearchReport->nameCorrectedDocument = $fileName;
                $topicSearchReport->correctedDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $topicSearchReport->state = $CORRECTED_STATE;
            $topicSearchReport->save();

            return redirect()->route('searchInformation', compact('idcId', 'idTopicSearchReport'));
        }

        public function declineTopicSearchReport($idcId, $idTopicSearchReport) {
            $DECLINE_STATE = 'Rechazado';
            $PREVIOUS_STATE = 'Corregido';
            $topicSearchReport = TopicSearchReport::find($idTopicSearchReport);

            $topicSearchReport->state = $DECLINE_STATE;
            $topicSearchReport->previousState = $PREVIOUS_STATE;
            $topicSearchReport->save();

            return redirect()->route('searchInformation', compact('idcId', 'idTopicSearchReport'));
        }
    }
?>