<?php
    namespace App\Http\Controllers;
    use App\Models\Comments;
    use App\Models\Idc;
    use App\Models\IDCDates;
    use App\Models\NextIdcTopicReport;
    use App\Models\StudentTeam;
    use App\Models\Team;
    use App\Models\User;
    use App\Notifications\ApproveNTR;
    use App\Notifications\ChangeCorrectDocumentNTR;
    use App\Notifications\changeCorrectedDocumentNTR;
    use App\Notifications\CorrectDocumentNTR;
    use App\Notifications\CorrectedDocumentNTR;
    use App\Notifications\DeclineNTR;
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
                'Next_Idc_Topic_Report.creationDate', 'Next_Idc_Topic_Report.state', 'Next_Idc_Topic_Report.previousState',
                'Next_Idc_Topic_Report.correctDocumentStoragePath', 'Next_Idc_Topic_Report.nameCorrectDocument', 
                'Next_Idc_Topic_Report.correctedDocumentStoragePath', 'Next_Idc_Topic_Report.nameCorrectedDocument', 
                'Research_Topic.researchTopicId', 'Research_Topic.code', 'Research_Topic.themeName', 'Team.teamId',
                 'Subject.subjectId')
                ->where('Idc.idcId', $idcId)
                ->first();

            $dates = IDCDates::select('Idc_Date.startDateNextIdcTopic', 'Idc_Date.endDateNextIdcTopic')->first();

            $comment = Comments::where('idUser', auth()->user()->userId)->first();

            if($comment !== null){
                $commentA = 'Ya comento';
            } else {
                $commentA = 'No ha comentado';
            }

            $comments = null;
            $user = auth()->user();
            if ($user->role === 'Coordinador' || $user->role === 'Administrador del Proceso' || $user->role === 'Administrador del Sistema') {
                $comments = Comments::join('Idc_Comment', 'Comment.commentId', '=', 'Idc_Comment.idComment')
                    ->join('Idc', 'Idc_Comment.idIdc', '=', 'Idc.idcId')
                    ->where('Idc_Comment.idIdc', $idcId)
                    ->get();
            }

            // $now = Carbon::now();

            // if ($now < Carbon::parse($nextIdcTopicReport->startDateNextIdcTopic)) {
            //     return redirect()->back();
            // }

            if ($nextIdcTopicReport && $dates->endDateNextIdcTopic) {
                $deadline = Carbon::parse($dates->endDateNextIdcTopic);
                $updated_at = Carbon::parse($nextIdcTopicReport->creationDate);

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

            return view('layouts.endProcess', compact('nextIdcTopicReport', 'timeRemaining', 'formattedDeadline', 'formattedupdated_at', 'idNextIdcTopicReport', 'comments','commentA'));
        }

        public function approveNextIdcTopicReport($idcId, $idNextIdcTopicReport) {
            $APPROVE_STATE = 'Aprobado';
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
    
            $nextIdcTopicReport->state = $APPROVE_STATE;
    
            $nextIdcTopicReport->save();

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
            $user->notify(new ApproveNTR($nextIdcTopicReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new ApproveNTR($nextIdcTopicReport, $idcId));
            }

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function approveCorrectedNextIdcTopicReport($idcId, $idNextIdcTopicReport) {
            $APPROVE_STATE = 'Aprobado';
            $PREVIOUS_STATE = 'Corregido';
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
    
            $nextIdcTopicReport->state = $APPROVE_STATE;
            $nextIdcTopicReport->previousState = $PREVIOUS_STATE;
    
            $nextIdcTopicReport->save();

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
            $user->notify(new ApproveNTR($nextIdcTopicReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new ApproveNTR($nextIdcTopicReport, $idcId));
            }

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

            $teacher = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Teacher', 'Team.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->select('User.userId')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($teacher->userId);
            $user->notify(new CorrectDocumentNTR($nextIdcTopicReport, $idcId));

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

            $coordinator = Idc::select('Idc.idUser')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($coordinator->idUser);
            $user->notify(new CorrectedDocumentNTR($nextIdcTopicReport, $idcId));

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function changeCorrectNextIdcTopicReport($idcId, $idNextIdcTopicReport, Request $request) {
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
    
            if($request->hasFile('archivoCorrecciones')) {
                $file = $request->file('archivoCorrecciones');

                $fileName = $file->getClientOriginalName();

                $nextIdcTopicReport->nameCorrectDocument = $fileName;
                $nextIdcTopicReport->correctDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $nextIdcTopicReport->save();

            $teacher = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Teacher', 'Team.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->select('User.userId')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($teacher->userId);
            $user->notify(new ChangeCorrectDocumentNTR($nextIdcTopicReport, $idcId));

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function changeCorrectedNextIdcTopicReport($idcId, $idNextIdcTopicReport, Request $request) {
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
    
            if($request->hasFile('archivoCorregido')) {
                $file = $request->file('archivoCorregido');

                $fileName = $file->getClientOriginalName();

                $nextIdcTopicReport->nameCorrectedDocument = $fileName;
                $nextIdcTopicReport->correctedDocumentStoragePath = 'documents/'.$fileName;
        
                $file->move(public_path('documents'), $fileName);
            }

            $nextIdcTopicReport->save();

            $coordinator = Idc::select('Idc.idUser')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($coordinator->idUser);
            $user->notify(new changeCorrectedDocumentNTR($nextIdcTopicReport, $idcId));

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function declineNextIdcTopicReport($idcId, $idNextIdcTopicReport) {
            $DECLINE_STATE = 'Rechazado';
            $PREVIOUS_STATE = 'Corregido';
            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);

            $nextIdcTopicReport->state = $DECLINE_STATE;
            $nextIdcTopicReport->previousState = $PREVIOUS_STATE;
            $nextIdcTopicReport->save();

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
            $user->notify(new DeclineNTR($nextIdcTopicReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new DeclineNTR($nextIdcTopicReport, $idcId));
            }

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }
    }
?>