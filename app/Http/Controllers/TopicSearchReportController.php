<?php
    namespace App\Http\Controllers;
    use App\Models\BibliographicSource;
    use App\Models\Objetive;
    use App\Models\SourceObjetive;
    use App\Models\SourceSearch;
    use Illuminate\Http\Request;

    class TopicSearchReportController extends Controller
    {
        public function getSources($idcId, $idTopicSearchReport) {
            $role = session('role');
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

            return view('layouts.topicSearchReport', compact('sources', 'objetivesG', 'objetivesE', 'role', 'idcId', 'idTopicSearchReport'));
        }

        public function create(Request $request) {
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $bibliographicSource = new BibliographicSource();
            $bibliographicSource->theme = $request->input('theme');
            $bibliographicSource->author = $request->input('author');
            $bibliographicSource->year = $request->input('year');
            $bibliographicSource->averageType = $request->input('averageType');
            $bibliographicSource->studentContribute = 'Mario Jaime Martínez Herrera';
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
            $objetive = new Objetive();
            $objetive->objetive = $request->input('objetive');
            $objetive->type = $request->input('type');
            $objetive->studentContribute = 'Mario Jaime Martínez Herrera';
            $objetive->state = 'Por aprobar';
            $objetive->save();

            $sourceObjetive = new SourceObjetive();
            $sourceObjetive->idTopicSearchReport = $idTopicSearchReport;
            $sourceObjetive->idObjetive = $objetive->objetiveId;
            $sourceObjetive->save(); 

            return redirect()->route('topicSearchReport', compact('idcId', 'idTopicSearchReport'));
        }

        public function updateObjetiveG(Request $request, $idObjetive) {
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            
            $objetiveApproved = Objetive::join('Source_Objetive', 'Objetive.objetiveId','=', 'Source_Objetive.idObjetive')
                ->where('type', 'General')
                ->where('state', 'Aprobado')
                ->where('idTopicSearchReport', $idTopicSearchReport)
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

        public function updateObjetiveE(Request $request, $idObjetive) {
            $objetive = Objetive::find($idObjetive);
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $objetive->state = 'Aprobado';
            $objetive->save();

            return $objetive->state;
        }

        public function updateSource(Request $request, $idSource) {
            $source = BibliographicSource::find($idSource);
            $idcId = $request->input('idcId');
            $idTopicSearchReport = $request->input('idTopicSearchReport');
            $source->state = 'Aprobado';
            $source->save();

            return $source->state;
        }
    }
?>