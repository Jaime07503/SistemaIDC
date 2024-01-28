<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use App\Models\ScientificArticleReport;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class ScientificArticleController extends Controller
    {
        public function getInformation($idcId, $idScientificArticleReport) {
            $scientificArticle = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Scientific_Article_Report', 'Idc.idcId', '=', 'Scientific_Article_Report.idIdc')
                ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->select('Idc.endDateScientificArticleReport', 'Idc.idcId',
                'Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                'Team.teamId', 'Subject.subjectId',  'Scientific_Article_Report.state', 'Scientific_Article_Report.previousState', 
                'Scientific_Article_Report.correctDocumentStoragePath', 'Scientific_Article_Report.nameCorrectDocument',
                'Scientific_Article_Report.correctedDocumentStoragePath', 'Scientific_Article_Report.nameCorrectedDocument', 
                'Scientific_Article_Report.documentImageStoragePath', 'Scientific_Article_Report.nameDocumentImage',
                'Scientific_Article_Report.code AS scientificArticleCode', 'Scientific_Article_Report.updated_at', 'Scientific_Article_Report.storagePath')
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

        public function approveScientificArticleReport($idcId, $idScientificArticleReport) {
            $APPROVE_STATE = 'Aprobado';
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            $scientificArticleReport->state = $APPROVE_STATE;
    
            $scientificArticleReport->save();

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function approveCorrectedScientificArticleReport($idcId, $idScientificArticleReport) {
            $APPROVE_STATE = 'Aprobado';
            $PREVIOUS_STATE = 'Corregido';
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            $scientificArticleReport->state = $APPROVE_STATE;
            $scientificArticleReport->previousState = $PREVIOUS_STATE;
    
            $scientificArticleReport->save();

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function correctScientificArticleReport($idcId, $idScientificArticleReport, Request $request) {
            $CORRECT_STATE = 'Debe corregirse';
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            if($request->hasFile('archivoCorrecciones')) {
                $file = $request->file('archivoCorrecciones');

                $fileName = $file->getClientOriginalName();

                $scientificArticleReport->nameCorrectDocument = $fileName;
                $scientificArticleReport->correctDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $scientificArticleReport->state = $CORRECT_STATE;
            $scientificArticleReport->save();

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function docImageScientificArticleReport($idcId, $idScientificArticleReport, Request $request) {
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            if($request->hasFile('archivoImagenes')) {
                $file = $request->file('archivoImagenes');

                $fileName = $file->getClientOriginalName();

                $scientificArticleReport->nameDocumentImage = $fileName;
                $scientificArticleReport->documentImageStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $scientificArticleReport->save();

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function correctedScientificArticleReport($idcId, $idScientificArticleReport, Request $request) {
            $CORRECTED_STATE = 'Corregido';
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            if($request->hasFile('archivoCorregido')) {
                $file = $request->file('archivoCorregido');

                $fileName = $file->getClientOriginalName();

                $scientificArticleReport->nameCorrectedDocument = $fileName;
                $scientificArticleReport->correctedDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $scientificArticleReport->state = $CORRECTED_STATE;
            $scientificArticleReport->save();

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function declineScientificArticleReport($idcId, $idScientificArticleReport) {
            $DECLINE_STATE = 'Rechazado';
            $PREVIOUS_STATE = 'Corregido';
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);

            $scientificArticleReport->state = $DECLINE_STATE;
            $scientificArticleReport->previousState = $PREVIOUS_STATE;
            $scientificArticleReport->save();

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }
    }
?>