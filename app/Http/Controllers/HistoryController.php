<?php
    namespace App\Http\Controllers;
    use App\Models\Student;
    use App\Models\StudentTeam;
    use App\Models\Teacher;
    use App\Models\Team;
    use App\Models\User;
    use Illuminate\Http\Request;

    class HistoryController extends Controller
    {
        public function getIdcs($idUser){

            $user = User::find($idUser);

            if ($user->userId !== auth()->user()->userId) {
                return redirect()->back();
            }

            if($user->role === 'Estudiante'){
                $student = Student::where('idUser' ,$user->userId)
                    ->first();

                $idcs = StudentTeam::join('Team as t', 't.teamId', '=', 'Student_Team.idTeam')
                    ->join('Idc', 't.teamId', '=', 'Idc.idTeam')
                    ->join('Research_Topic as rt', 'rt.researchTopicId', '=', 't.idResearchTopic')
                    ->where('Student_Team.idStudent', $student->studentId)
                    ->where('Idc.state', 'Finalizado')
                    ->select('Student_Team.studentTeamId', 't.*', 'rt.*', 'Idc.idcId')
                    ->get();

                if ($idcs->isEmpty()) {
                    return view('layouts.history', compact('idUser'))->with('noIdcs', true);
                }

                return view('layouts.history', compact('idUser' ,'idcs'));
            }else if($user->role === 'Docente'){
                $teacher = Teacher::where('idUser', $user->userId)
                    ->first();

                $idcs = Team::join('Research_Topic as rt', 'rt.researchTopicId', '=', 'Team.idResearchTopic')
                    ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                    ->where('Team.idTeacher', $teacher->teacherId)
                    ->where('Idc.state', 'Finalizado')
                    ->select('Team.*', 'rt.*', 'Idc.idcId')
                    ->get();

                if ($idcs->isEmpty()) {
                    return view('layouts.history', compact('idUser'))->with('noIdcs', true);
                }

                return view('layouts.history', compact('idUser' ,'idcs'));
            } else {
                $idcs = Team::join('Research_Topic as rt', 'rt.researchTopicId', '=', 'Team.idResearchTopic')
                    ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                    ->where('Idc.state', 'Finalizado')
                    ->select('Team.*', 'rt.*', 'Idc.idcId')
                    ->get();

                if ($idcs->isEmpty()) {
                    return view('layouts.history', compact('idUser'))->with('noIdcs', true);
                }

                return view('layouts.history', compact('idUser' ,'idcs'));
            }
        }
    }
?>