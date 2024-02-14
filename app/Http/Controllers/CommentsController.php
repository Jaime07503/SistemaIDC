<?php
    namespace App\Http\Controllers;
    use App\Models\Comments;
    use App\Models\Idc;
    use App\Models\IDCComments;
    use App\Models\Team;
    use Illuminate\Http\Request;

    class CommentsController extends Controller
    {
        public function addComment($idcId, $idNextIdcTopicReport, Request $request) {
            $comment = new Comments();
            $comment->commentsIdc = $request->input('commentsIdc');
            $comment->opportunityForImprovements = $request->input('opportunityForImprovements');
            $comment->whoContributes = auth()->user()->name;
            $comment->idUser = auth()->user()->userId;
            $comment->save();

            $idcComment = new IDCComments();
            $idcComment->idIdc = $idcId;
            $idcComment->idComment = $comment->commentId;
            $idcComment->save();

            $idc = Idc::find($idcId);
            $teamId = $idc->idTeam;
            $team = Team::find($teamId);

            $userIds = [];

            if ($team) {
                $teacher = $team->teacher;

                if ($teacher && $teacher->user) {
                    $userIds[] = $teacher->user->userId;
                }

                $studentTeam = $team->studentTeam;

                foreach ($studentTeam as $studentTeamMember) {
                    $student = $studentTeamMember->student;

                    if ($student && $student->user) {
                        $userIds[] = $student->user->userId;
                    }
                }
            }

            $commentUserIds = Comments::pluck('idUser')->toArray();

            $incomplete = false;
            foreach ($userIds as $userId) {
                if (!in_array($userId, $commentUserIds)) {
                    $incomplete = true;
                    break;
                }
            }

            if ($incomplete === false) {
                $idc->state = 'Finalizado';
                $idc->save();

                $teacher = $team->teacher;
                $teacher->idcQuantity += 1;
                $teacher->save();

                foreach ($team->studentTeam as $studentTeamMember) {
                    $student = $studentTeamMember->student;
                    if ($student) {
                        $student->idcQuantity += 1;
                        $student->save();
                    }
                }
    
                return redirect()->route('tablero');
            }

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }
    }
?>