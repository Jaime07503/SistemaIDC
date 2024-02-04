<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use App\Models\IDCDates;
    use App\Models\ReportTopic;
    use App\Models\Topic;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class NextIdcTopicReportController extends Controller
    {
        public function getTopics($idcId, $idNextIdcTopicReport) {
            $role = session('role');

            $dates = IDCDates::select('Idc_Date.startDateNextIdcTopic', 'Idc_Date.endDateNextIdcTopic')->first();

            if($role !== 'Estudiante') {
                $topics = Topic::join('Report_Topic', 'Topic.topicId', '=', 'Report_Topic.idTopic')
                    ->where('idNextIdcTopicReport', $idNextIdcTopicReport)
                    ->orderby('state')
                    ->get();

                $nextIdcTopicReport = Idc::join('Next_Idc_Topic_Report', 'Idc.idcId', '=', 'Next_Idc_Topic_Report.idIdc')
                    ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                    ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                    ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                    ->select('Next_Idc_Topic_Report.code as nextIdcTopicReportCode', 'Idc.idcId','Next_Idc_Topic_Report.updated_at', 'Next_Idc_Topic_Report.state',
                    'Research_Topic.researchTopicId', 'Research_Topic.code', 'Research_Topic.themeName', 'Team.teamId',
                    'Subject.subjectId')
                    ->where('Idc.idcId', $idcId)
                    ->first();

                // $now = Carbon::now();

                // if ($now < Carbon::parse($dates->startDateNextIdcTopic)) {
                //     return redirect()->back();
                // }

                return view('layouts.nextIdcTopicReport', compact('role', 'idcId', 'topics', 'idNextIdcTopicReport', 'nextIdcTopicReport'));
            } else {
                $userId = session('userId');
                $user = User::find($userId);

                $topics = Topic::join('Report_Topic', 'Topic.topicId', '=', 'Report_Topic.idTopic')
                    ->where('idNextIdcTopicReport', $idNextIdcTopicReport)
                    ->where('studentContribute', $user->name)
                    ->orderby('state')
                    ->get();

                $nextIdcTopicReport = Idc::join('Next_Idc_Topic_Report', 'Idc.idcId', '=', 'Next_Idc_Topic_Report.idIdc')
                    ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                    ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                    ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                    ->select('Next_Idc_Topic_Report.storagePath', 'Next_Idc_Topic_Report.code as nextIdcTopicReportCode', 'Idc.idcId',
                    'Next_Idc_Topic_Report.updated_at', 'Next_Idc_Topic_Report.state',
                    'Research_Topic.researchTopicId', 'Research_Topic.code', 'Research_Topic.themeName', 'Team.teamId',
                    'Subject.subjectId')
                    ->where('Idc.idcId', $idcId)
                    ->first();

                // $now = Carbon::now();

                // if ($now < Carbon::parse($dates->startDateNextIdcTopic)) {
                //     return redirect()->back();
                // }

                return view('layouts.nextIdcTopicReport', compact('role', 'idcId', 'topics', 'idNextIdcTopicReport', 'nextIdcTopicReport'));
            }
        }

        public function create(Request $request) {
            $idcId = $request->input('idcId');
            $idNextIdcTopicReport = $request->input('idNextIdcTopicReport');
            $userId = session('userId');
            $user = User::find($userId);
            $localRelevanceImg = $request->file('Imagen-Importancia-Local');
            if ($localRelevanceImg) {
                $localRelevanceImgName = uniqid('local_relevance_') . '_' . time() . '.' . $localRelevanceImg->getClientOriginalExtension();
                $localRelevanceImg->move(public_path('images'), $localRelevanceImgName);
            }

            $globalRelevanceImg = $request->file('Imagen-Importancia-Global');
            if ($globalRelevanceImg) {
                $globalRelevanceImgName = uniqid('global_relevance_') . '_' . time() . '.' . $globalRelevanceImg->getClientOriginalExtension();
                $globalRelevanceImg->move(public_path('images'), $globalRelevanceImgName);
            }

            $topic = new Topic();
            $topic->nameTopic = $request->input('nameTopic');
            $topic->subjectRelevance = $request->input('subjectRelevance');
            $topic->description = $request->input('description');
            $topic->globalUpdateImg = asset('images/' . $globalRelevanceImgName);
            $topic->localUpdateImg = asset('images/' . $localRelevanceImgName);
            $topic->updatedInformation = $request->input('updatedInformation');
            $topic->localRelevance = $request->input('localRelevance');
            $topic->globalRelevance = $request->input('globalRelevance');
            $topic->studentContribute = $user->name;
            $topic->state = 'Por aprobar';
            $topic->save();

            $reportTopic = new ReportTopic();
            $reportTopic->idNextIdcTopicReport = $idNextIdcTopicReport;
            $reportTopic->idTopic = $topic->topicId;
            $reportTopic->save();

            return redirect()->route('nextIdcTopicReport', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function updateTopic($idTopic){
            try {
                $topic = Topic::find($idTopic);
                $topic->state = 'Aprobado';
                $topic->save();

                return $topic->state;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        public function editTopic (Request $request) {
            $idcId = $request->input('idcId');
            $idNextIdcTopicReport = $request->input('idNextIdcTopicReport');
            $topicId = $request->input('topicId');
            $localRelevanceImgName = null;
            $globalRelevanceImgName = null;
            $localRelevanceImg = $request->file('Importancia-Local');
            if ($localRelevanceImg) {
                $localRelevanceImgName = uniqid('local_relevance_') . '_' . time() . '.' . $localRelevanceImg->getClientOriginalExtension();
                $localRelevanceImg->move(public_path('images'), $localRelevanceImgName);
            }

            $globalRelevanceImg = $request->file('Importancia-Global');
            if ($globalRelevanceImg) {
                $globalRelevanceImgName = uniqid('global_relevance_') . '_' . time() . '.' . $globalRelevanceImg->getClientOriginalExtension();
                $globalRelevanceImg->move(public_path('images'), $globalRelevanceImgName);
            }

            $topic = Topic::finD($topicId);
            $topic->nameTopic = $request->input('nameTopic');
            $topic->description = $request->input('description');
            $topic->subjectRelevance = $request->input('subjectRelevance');
            if($localRelevanceImgName !== null) {
                $topic->localUpdateImg = asset('images/' . $localRelevanceImgName);
            }
            if($globalRelevanceImgName !== null) {
                $topic->globalUpdateImg = asset('images/' . $globalRelevanceImgName);
            }
            $topic->updatedInformation = $request->input('updatedInformation');
            $topic->localRelevance = $request->input('localRelevance');
            $topic->globalRelevance = $request->input('globalRelevance');
            $topic->save();

            return redirect()->route('nextIdcTopicReport', compact('idcId', 'idNextIdcTopicReport'));
        }

        public function deleteTopic (Request $request) {
            $idcId = $request->input('idcId');
            $idNextIdcTopicReport = $request->input('idNextIdcTopicReport');
            $topicId = $request->input('topicId');

            $topic = Topic::find($topicId);
            $topic->delete();

            return redirect()->route('nextIdcTopicReport', compact('idcId', 'idNextIdcTopicReport'));
        }
    }
?>