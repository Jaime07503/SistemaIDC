<?php
    namespace App\Http\Controllers;
    use App\Models\BibliographicSource;
    use App\Models\Idc;
    use App\Models\Objetive;
    use App\Models\SourceObjetive;
    use App\Models\SourceSearch;
    use App\Models\User;
    use Illuminate\Http\Request;

    class TopicSearchReportController extends Controller
    {
        public function getSources($idcId, $idTopicSearchReport) {
            $role = session('role');
            if($role !== 'Estudiante') {
                $sources = BibliographicSource::join('Source_Search', 'Bibliographic_Source.bibliographicSourceId', '=', 'Source_Search.idBibliographicSource')
                    ->where('idTopicSearchReport', $idTopicSearchReport)
                    ->orderby('state')
                    ->orderByDesc('year')
                    ->get();

                $objetivesG = Objetive::join('Source_Objetive', 'Objetive.objetiveId', '=', 'Source_Objetive.idObjetive')
                    ->where('type', 'General')
                    ->where('idTopicSearchReport', $idTopicSearchReport)
                    ->orderby('state')
                    ->get();

                $objetivesE = Objetive::join('Source_Objetive', 'Objetive.objetiveId', '=', 'Source_Objetive.idObjetive')
                    ->where('type', 'Especifico')
                    ->where('idTopicSearchReport', $idTopicSearchReport)
                    ->orderby('state')
                    ->get();

                $topicSearchReport = Idc::join('Topic_Search_Report', 'Idc.idcId', '=', 'Topic_Search_Report.idIdc')
                    ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                    ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                    ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                    ->select('Topic_Search_Report.state', 'Topic_Search_Report.storagePath',
                    'Idc.idcId', 'Topic_Search_Report.updated_at', 'Research_Topic.researchTopicId', 'Research_Topic.themeName',
                    'Research_Topic.code', 'Subject.subjectId', 'Team.teamId', 'Topic_Search_Report.code as searchReportCode')
                    ->where('Topic_Search_Report.topicSearchReportId', $idTopicSearchReport)
                    ->first();

                $students = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                    ->join('Student_Team', 'Team.teamId', '=', 'Student_Team.idTeam')
                    ->join('Student', 'Student_Team.idStudent', '=', 'Student.studentId')
                    ->join('User', 'Student.idUser', '=', 'User.userId')
                    ->where('Idc.idcId', $idcId)
                    ->select('User.name')
                    ->get();

                if($topicSearchReport->state !== 'Sin Intento') {
                    return redirect()->back();
                }

                return view('layouts.topicSearchReport', compact('sources', 'objetivesG', 'objetivesE', 'students','role', 'idcId', 'idTopicSearchReport', 'topicSearchReport'));
            } 
            else {
                $sources = BibliographicSource::join('Source_Search', 'Bibliographic_Source.bibliographicSourceId', '=', 'Source_Search.idBibliographicSource')
                    ->where('idTopicSearchReport', $idTopicSearchReport)
                    ->where('studentContribute', auth()->user()->userId)
                    ->orderby('state')
                    ->orderByDesc('year')
                    ->get();

                $objetivesG = Objetive::join('Source_Objetive', 'Objetive.objetiveId', '=', 'Source_Objetive.idObjetive')
                    ->where('type', 'General')
                    ->where('idTopicSearchReport', $idTopicSearchReport)
                    ->where('studentContribute', auth()->user()->userId)
                    ->orderby('state')
                    ->get();

                $objetivesE = Objetive::join('Source_Objetive', 'Objetive.objetiveId', '=', 'Source_Objetive.idObjetive')
                    ->where('type', 'Especifico')
                    ->where('idTopicSearchReport', $idTopicSearchReport)
                    ->where('studentContribute', auth()->user()->userId)
                    ->orderby('state')
                    ->get();

                $topicSearchReport = Idc::join('Topic_Search_Report', 'Idc.idcId', '=', 'Topic_Search_Report.idIdc')
                    ->join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                    ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                    ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                    ->select('Topic_Search_Report.state', 'Topic_Search_Report.storagePath',
                    'Idc.idcId', 'Topic_Search_Report.updated_at', 'Research_Topic.researchTopicId', 'Research_Topic.themeName',
                    'Research_Topic.code', 'Subject.subjectId', 'Team.teamId', 'Topic_Search_Report.code as searchReportCode')
                    ->where('Topic_Search_Report.topicSearchReportId', $idTopicSearchReport)
                    ->first();

                if($topicSearchReport->state !== 'Sin Intento') {
                    return redirect()->back();
                }

                return view('layouts.topicSearchReport', compact('sources', 'objetivesG', 'objetivesE', 'role', 'idcId', 'idTopicSearchReport', 'topicSearchReport'));
            }
        }

        public function create(Request $request) {
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $userId = session('userId');
            $user = User::find($userId);

            $bibliographicSource = new BibliographicSource();
            $bibliographicSource->theme = $request->input('theme');
            $bibliographicSource->author = $request->input('author');
            $bibliographicSource->year = $request->input('year');
            $bibliographicSource->averageType = $request->input('averageType');
            $bibliographicSource->studentContribute = $user->userId;
            $bibliographicSource->link = $request->input('link');
            $bibliographicSource->source = $request->input('source');
            $bibliographicSource->state = 'Por Aprobar';
            $bibliographicSource->save();

            $sourceSearch = new SourceSearch();
            $sourceSearch->idTopicSearchReport = $idTopicSearchReport;
            $sourceSearch->idBibliographicSource = $bibliographicSource->bibliographicSourceId;
            $sourceSearch->save();

            return redirect()->route('topicSearchReport', compact('idcId', 'idTopicSearchReport'));
        }

        public function createObjetive(Request $request) {
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $userId = session('userId');

            $user = User::find($userId);
            $objetive = new Objetive();
            $objetive->objetive = $request->input('objetive');
            $objetive->type = $request->input('type');
            $objetive->studentContribute = $user->userId;
            $objetive->state = 'Por aprobar';
            $objetive->save();

            $sourceObjetive = new SourceObjetive();
            $sourceObjetive->idTopicSearchReport = $idTopicSearchReport;
            $sourceObjetive->idObjetive = $objetive->objetiveId;
            $sourceObjetive->save(); 

            return redirect()->route('topicSearchReport', compact('idcId', 'idTopicSearchReport'));
        }

        public function updateObjetiveG($idObjetive) {            
            $objetiveApproved = Objetive::where('type', 'General')
                ->where('state', 'Aprobado')
                ->first();
            
            if(!empty($objetiveApproved)){
                $objetiveApproved->state = 'Por aprobar';
                $objetiveApproved->save();

                $objetive = Objetive::find($idObjetive);
                $objetive->state = 'Aprobado';
                $objetive->save();

                return $objetive->state;
            } else {
                $objetive = Objetive::find($idObjetive);
                $objetive->state = 'Aprobado';
                $objetive->save();
            
                return $objetive->state;
            }
        }        

        public function updateObjetiveE($idObjetive) {
            try {
                $objetive = Objetive::find($idObjetive);
                $objetive->state = 'Aprobado';
                $objetive->save();

                return $objetive->state;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        public function updateSource($idSource) {
            try {
                $source = BibliographicSource::find($idSource);
                $source->state = 'Aprobado';
                $source->save();
        
                return $source->state;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        public function editSource(Request $request) {
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $sourceId = $request->input('sourceId');

            $source = BibliographicSource::find($sourceId);
            $source->year = $request->input('year');
            $source->theme = $request->input('theme');
            $source->author = $request->input('author');
            $source->averageType = $request->input('averageType');
            $source->link = $request->input('link');
            $source->source = $request->input('source');
            $source->save();

            return redirect()->route('topicSearchReport', compact('idcId', 'idTopicSearchReport'));
        }

        public function deleteSource(Request $request) {
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $sourceId = $request->input('sourceId');
            $source = BibliographicSource::find($sourceId);

            $source->delete();

            return redirect()->route('topicSearchReport', compact('idcId', 'idTopicSearchReport'));
        }

        public function editObjetive(Request $request) {
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $objetiveId = $request->input('objetiveId');

            $objetive = Objetive::find($objetiveId);
            $objetive->objetive = $request->input('objetive');
            $objetive->save();

            return redirect()->route('topicSearchReport', compact('idcId', 'idTopicSearchReport'));
        }

        public function deleteObjetive(Request $request) {
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $objetiveId = $request->input('objetiveId');

            $objetive = Objetive::find($objetiveId);
            $objetive->delete();

            return redirect()->route('topicSearchReport', compact('idcId', 'idTopicSearchReport'));
        }
    }
?>