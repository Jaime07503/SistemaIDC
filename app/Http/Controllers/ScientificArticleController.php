<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use App\Models\IDCDates;
    use App\Models\ScientificArticleReport;
    use App\Models\StudentTeam;
    use App\Models\Team;
    use App\Models\User;
    use App\Notifications\ApproveSAR;
    use App\Notifications\ChangeCorrectDocumentSAR;
    use App\Notifications\changeCorrectedDocumentSAR;
    use App\Notifications\changeDocumentImageSAR;
    use App\Notifications\CorrectDocumentSAR;
    use App\Notifications\CorrectedDocumentSAR;
    use App\Notifications\DeclineSAR;
    use App\Notifications\DocumentImageSAR;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class ScientificArticleController extends Controller
    {
        public function getInformation($idcId, $idScientificArticleReport) {
            $scientificArticle = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Scientific_Article_Report', 'Idc.idcId', '=', 'Scientific_Article_Report.idIdc')
                ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->select('Idc.idcId', 'Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                'Team.teamId', 'Subject.subjectId',  'Scientific_Article_Report.state', 'Scientific_Article_Report.previousState', 
                'Scientific_Article_Report.correctDocumentStoragePath', 'Scientific_Article_Report.nameCorrectDocument',
                'Scientific_Article_Report.correctedDocumentStoragePath', 'Scientific_Article_Report.nameCorrectedDocument', 
                'Scientific_Article_Report.documentImageStoragePath', 'Scientific_Article_Report.nameDocumentImage',
                'Scientific_Article_Report.code AS scientificArticleCode', 'Scientific_Article_Report.creationDate', 'Scientific_Article_Report.storagePath')
                ->where('Idc.idcId', $idcId)
                ->first();
            
            $dates = IDCDates::select('Idc_Date.startDateScientificArticleReport', 'Idc_Date.endDateScientificArticleReport')->first();

            // $now = Carbon::now();

            // if ($now < Carbon::parse($dates->startDateScientificArticleReport)) {
            //     return redirect()->back();
            // }

            if ($scientificArticle && $dates->endDateScientificArticleReport) {
                $deadline = Carbon::parse($dates->endDateScientificArticleReport);
                $updated_at = Carbon::parse($scientificArticle->creationDate);

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

            $researchTopicId = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
            ->where('Idc.idcId', $idcId)
            ->select('Team.idResearchTopic')->first();

            $teams = Team::where('idResearchTopic', $researchTopicId->idResearchTopic)
                ->with('studentTeam.student')
                ->get();

            foreach ($teams as $team) {
                $studentTeamIds = StudentTeam::where('idTeam', $team->teamId)->pluck('idStudent')->toArray();
            
                $students = $team->studentTeam->pluck('student');
            }

            $teacher = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Teacher', 'Team.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->select('User.userId')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($teacher->userId);
            $user->notify(new ApproveSAR($scientificArticleReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new ApproveSAR($scientificArticleReport, $idcId));
            }

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function approveCorrectedScientificArticleReport($idcId, $idScientificArticleReport) {
            $APPROVE_STATE = 'Aprobado';
            $PREVIOUS_STATE = 'Corregido';
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            $scientificArticleReport->state = $APPROVE_STATE;
            $scientificArticleReport->previousState = $PREVIOUS_STATE;
    
            $scientificArticleReport->save();

            $researchTopicId = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
            ->where('Idc.idcId', $idcId)
            ->select('Team.idResearchTopic')->first();

            $teams = Team::where('idResearchTopic', $researchTopicId->idResearchTopic)
                ->with('studentTeam.student')
                ->get();

            foreach ($teams as $team) {
                $studentTeamIds = StudentTeam::where('idTeam', $team->teamId)->pluck('idStudent')->toArray();
            
                $students = $team->studentTeam->pluck('student');
            }

            $teacher = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Teacher', 'Team.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->select('User.userId')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($teacher->userId);
            $user->notify(new ApproveSAR($scientificArticleReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new ApproveSAR($scientificArticleReport, $idcId));
            }

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

            $teacher = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Teacher', 'Team.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->select('User.userId')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($teacher->userId);
            $user->notify(new CorrectDocumentSAR($scientificArticleReport, $idcId));

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

            $researchTopicId = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
            ->where('Idc.idcId', $idcId)
            ->select('Team.idResearchTopic')->first();

            $teams = Team::where('idResearchTopic', $researchTopicId->idResearchTopic)
                ->with('studentTeam.student')
                ->get();

            foreach ($teams as $team) {
                $studentTeamIds = StudentTeam::where('idTeam', $team->teamId)->pluck('idStudent')->toArray();
            
                $students = $team->studentTeam->pluck('student');
            }

            $coordinator = Idc::select('Idc.idUser')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($coordinator->idUser);
            $user->notify(new DocumentImageSAR($scientificArticleReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new DocumentImageSAR($scientificArticleReport, $idcId));
            }

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

            $coordinator = Idc::select('Idc.idUser')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($coordinator->idUser);
            $user->notify(new CorrectedDocumentSAR($scientificArticleReport, $idcId));

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function changeCorrectScientificArticleReport($idcId, $idScientificArticleReport, Request $request) {
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            if($request->hasFile('archivoCorrecciones')) {
                $file = $request->file('archivoCorrecciones');

                $fileName = $file->getClientOriginalName();

                $scientificArticleReport->nameCorrectDocument = $fileName;
                $scientificArticleReport->correctDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $scientificArticleReport->save();

            $teacher = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Teacher', 'Team.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->select('User.userId')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($teacher->userId);
            $user->notify(new ChangeCorrectDocumentSAR($scientificArticleReport, $idcId));

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function changeDocImageScientificArticleReport($idcId, $idScientificArticleReport, Request $request) {
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            if($request->hasFile('archivoImagenes')) {
                $file = $request->file('archivoImagenes');

                $fileName = $file->getClientOriginalName();

                $scientificArticleReport->nameDocumentImage = $fileName;
                $scientificArticleReport->documentImageStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $scientificArticleReport->save();

            $researchTopicId = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
            ->where('Idc.idcId', $idcId)
            ->select('Team.idResearchTopic')->first();

            $teams = Team::where('idResearchTopic', $researchTopicId->idResearchTopic)
                ->with('studentTeam.student')
                ->get();

            foreach ($teams as $team) {
                $studentTeamIds = StudentTeam::where('idTeam', $team->teamId)->pluck('idStudent')->toArray();
            
                $students = $team->studentTeam->pluck('student');
            }

            $coordinator = Idc::select('Idc.idUser')
            ->where('Idc.idcId', $idcId)
            ->first();
            
            $user = User::find($coordinator->idUser);
            $user->notify(new changeDocumentImageSAR($scientificArticleReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new changeDocumentImageSAR($scientificArticleReport, $idcId));
            }

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function changeCorrectedScientificArticleReport($idcId, $idScientificArticleReport, Request $request) {
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);
    
            if($request->hasFile('archivoCorregido')) {
                $file = $request->file('archivoCorregido');

                $fileName = $file->getClientOriginalName();

                $scientificArticleReport->nameCorrectedDocument = $fileName;
                $scientificArticleReport->correctedDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $scientificArticleReport->save();

            $coordinator = Idc::select('Idc.idUser')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($coordinator->idUser);
            $user->notify(new changeCorrectedDocumentSAR($scientificArticleReport, $idcId));

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }

        public function declineScientificArticleReport($idcId, $idScientificArticleReport) {
            $DECLINE_STATE = 'Rechazado';
            $PREVIOUS_STATE = 'Corregido';
            $scientificArticleReport = ScientificArticleReport::find($idScientificArticleReport);

            $scientificArticleReport->state = $DECLINE_STATE;
            $scientificArticleReport->previousState = $PREVIOUS_STATE;
            $scientificArticleReport->save();

            $researchTopicId = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
            ->where('Idc.idcId', $idcId)
            ->select('Team.idResearchTopic')->first();

            $teams = Team::where('idResearchTopic', $researchTopicId->idResearchTopic)
                ->with('studentTeam.student')
                ->get();

            foreach ($teams as $team) {
                $studentTeamIds = StudentTeam::where('idTeam', $team->teamId)->pluck('idStudent')->toArray();
            
                $students = $team->studentTeam->pluck('student');
            }

            $teacher = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Teacher', 'Team.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->select('User.userId')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($teacher->userId);
            $user->notify(new DeclineSAR($scientificArticleReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new DeclineSAR($scientificArticleReport, $idcId));
            }

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }
    }
?>