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

            if ($idc) {
                $teamId = $idc->idTeam;
                if ($teamId) {
                    $team = Team::find($teamId); 
                    if ($team) {
                        $userIds = $team->studentTeam()->pluck('idStudent')->toArray(); 
                        if (!in_array($team->idTeacher, $userIds)) {
                            $userIds[] = $team->idTeacher;
                        }
                    }
                } 
            } 

            $incomplete = false;

            foreach ($userIds as $userId) {
                $count = Comments::where('idUser', $userId)->count();
                if ($count === 0) {
                    $incomplete = true;
                    break;
                }
            }

            if ($incomplete) {
                $estado = 'Incompleto';
            } else {
                $estado = 'Completo';
            }

            if ($estado === 'Completo') {
                $idc->state = 'Finalizado';
                $idc->save();

                return redirect()->route('tablero');
            }

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }
    }
?>