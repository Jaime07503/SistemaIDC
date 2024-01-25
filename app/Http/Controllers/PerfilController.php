<?php
    namespace App\Http\Controllers;
    use App\Models\Student;
    use App\Models\StudentTeam;
    use App\Models\Teacher;
    use App\Models\Team;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class PerfilController extends Controller
    {
        public function getInformation($idUser) {
            $user = User::find($idUser);

            if($user->role === 'Estudiante'){
                $student = Student::where('idUser' ,$user->userId)
                    ->first();

                $idcs = StudentTeam::join('Team as t', 't.teamId', '=', 'Student_Team.idTeam')
                    ->join('Idc', 't.teamId', '=', 'Idc.idTeam')
                    ->join('Research_Topic as rt', 'rt.researchTopicId', '=', 't.idResearchTopic')
                    ->where('Student_Team.idStudent', $student->studentId)
                    ->select('Student_Team.studentTeamId', 't.*', 'rt.*', 'Idc.idcId')
                    ->get();
                
                    $firstLogin = $user->firstLogin ? Carbon::parse($user->firstLogin) : null;
                    $lastLogin = $user->lastLogin ? Carbon::parse($user->lastLogin) : null;

                    if ($firstLogin && $lastLogin) {
                        $formattedFL = $firstLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                        $formattedLL = $lastLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                    } elseif ($firstLogin) {
                        $formattedFL = $firstLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                        $formattedLL = "El usuario aún no ha cerrado sesión.";
                    } elseif ($lastLogin) {
                        $formattedFL = "El usuario aún no ha iniciado sesión.";
                        $formattedLL = $lastLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                    } else {
                        $formattedFL = "El usuario aún no ha iniciado sesión.";
                        $formattedLL = "El usuario aún no ha iniciado sesión.";
                    }

                return view('layouts.perfil', compact('user', 'idcs', 'formattedFL', 'formattedLL'));
            }else if($user->role === 'Docente'){
                $teacher = Teacher::where('idUser', $user->userId)
                    ->first();

                $idcs = Team::join('Research_Topic as rt', 'rt.researchTopicId', '=', 'Team.idResearchTopic')
                    ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                    ->where('Team.idTeacher', $teacher->teacherId)
                    ->where('Team.state', 'Aprobado')
                    ->select('Team.*', 'rt.*', 'Idc.idcId')
                    ->get();

                    $firstLogin = $user->firstLogin ? Carbon::parse($user->firstLogin) : null;
                    $lastLogin = $user->lastLogin ? Carbon::parse($user->lastLogin) : null;

                    if ($firstLogin && $lastLogin) {
                        $formattedFL = $firstLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                        $formattedLL = $lastLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                    } elseif ($firstLogin) {
                        $formattedFL = $firstLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                        $formattedLL = "El usuario aún no ha cerrado sesión.";
                    } elseif ($lastLogin) {
                        $formattedFL = "El usuario aún no ha iniciado sesión.";
                        $formattedLL = $lastLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                    } else {
                        $formattedFL = "El usuario aún no ha iniciado sesión.";
                        $formattedLL = "El usuario aún no ha iniciado sesión.";
                    }

                return view('layouts.perfil', compact('user', 'idcs', 'formattedFL', 'formattedLL'));
            } else {
                $idcs = Team::join('Research_Topic as rt', 'rt.researchTopicId', '=', 'Team.idResearchTopic')
                    ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                    ->where('Idc.idUser', $idUser)
                    ->where('Team.state', 'Aprobado')
                    ->select('Team.*', 'rt.*', 'Idc.idcId')
                    ->get();

                    $firstLogin = $user->firstLogin ? Carbon::parse($user->firstLogin) : null;
                    $lastLogin = $user->lastLogin ? Carbon::parse($user->lastLogin) : null;

                    if ($firstLogin && $lastLogin) {
                        $formattedFL = $firstLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                        $formattedLL = $lastLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                    } elseif ($firstLogin) {
                        $formattedFL = $firstLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                        $formattedLL = "El usuario aún no ha cerrado sesión.";
                    } elseif ($lastLogin) {
                        $formattedFL = "El usuario aún no ha iniciado sesión.";
                        $formattedLL = $lastLogin->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm');
                    } else {
                        $formattedFL = "El usuario aún no ha iniciado sesión.";
                        $formattedLL = "El usuario aún no ha iniciado sesión.";
                    }

                return view('layouts.perfil', compact('user', 'idcs', 'formattedFL', 'formattedLL'));
            }
        }

        public function updateAvatar(Request $request, $idUser){
            $avatar = $request->file('avatar');
            $avatarName = null;
        
            if ($avatar) {
                $avatarName = uniqid('avatar') . '_' . time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('images'), $avatarName);
            }
        
            $user = User::find($idUser);
        
            if ($avatarName) {
                $user->avatar = asset('images/' . $avatarName);
            }
        
            $user->save();
        
            return redirect()->route('perfil', compact('idUser'));
        }
    }
?>