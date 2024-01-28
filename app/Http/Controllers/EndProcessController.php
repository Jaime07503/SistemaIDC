<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use App\Models\NextIdcTopicReport;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class EndProcessController extends Controller
    {
        public function getInformation($idcId, $idNextIdcTopicReport) {
            $nextIdcTopicReport = Idc::join('Next_Idc_Topic_Report', 'Idc.idcId', '=', 'Next_Idc_Topic_Report.idIdc')
                ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->select('Next_Idc_Topic_Report.storagePath', 'Next_Idc_Topic_Report.code as nextIdcTopicReportCode', 'Idc.idcId',
                'Idc.endDateNextIdcTopic','Next_Idc_Topic_Report.updated_at', 'Next_Idc_Topic_Report.state', 'Next_Idc_Topic_Report.previousState',
                'Next_Idc_Topic_Report.correctDocumentStoragePath', 'Next_Idc_Topic_Report.nameCorrectDocument', 
                'Next_Idc_Topic_Report.correctedDocumentStoragePath', 'Next_Idc_Topic_Report.nameCorrectedDocument', 
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

        public function approveNextIdcTopicReport($idcId, $idNextIdcTopicReport) {
            $APPROVE_STATE = 'Aprobado';
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
    
            $nextIdcTopicReport->state = $APPROVE_STATE;
    
            $nextIdcTopicReport->save();

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function approveCorrectedNextIdcTopicReport($idcId, $idNextIdcTopicReport) {
            $APPROVE_STATE = 'Aprobado';
            $PREVIOUS_STATE = 'Corregido';
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
    
            $nextIdcTopicReport->state = $APPROVE_STATE;
            $nextIdcTopicReport->previousState = $PREVIOUS_STATE;
    
            $nextIdcTopicReport->save();

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function correctNextIdcTopicReport($idcId, $idNextIdcTopicReport, Request $request) {
            $CORRECT_STATE = 'Debe corregirse';
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
    
            if($request->hasFile('archivoCorrecciones')) {
                $file = $request->file('archivoCorrecciones');

                $fileName = $file->getClientOriginalName();

                $nextIdcTopicReport->nameCorrectDocument = $fileName;
                $nextIdcTopicReport->correctDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $nextIdcTopicReport->state = $CORRECT_STATE;
            $nextIdcTopicReport->save();

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function correctedNextIdcTopicReport($idcId, $idNextIdcTopicReport, Request $request) {
            $CORRECTED_STATE = 'Corregido';
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
    
            if($request->hasFile('archivoCorregido')) {
                $file = $request->file('archivoCorregido');

                $fileName = $file->getClientOriginalName();

                $nextIdcTopicReport->nameCorrectedDocument = $fileName;
                $nextIdcTopicReport->correctedDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $nextIdcTopicReport->state = $CORRECTED_STATE;
            $nextIdcTopicReport->save();

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function declineNextIdcTopicReport($idcId, $idNextIdcTopicReport) {
            $DECLINE_STATE = 'Rechazado';
            $PREVIOUS_STATE = 'Corregido';
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);

            $nextIdcTopicReport->state = $DECLINE_STATE;
            $nextIdcTopicReport->previousState = $PREVIOUS_STATE;
            $nextIdcTopicReport->save();

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }
    }
?>