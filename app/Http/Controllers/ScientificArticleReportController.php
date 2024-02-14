<?php
    namespace App\Http\Controllers;
    use App\Models\ArticleConclusion;
    use App\Models\ArticleReference;
    use App\Models\Conclusion;
    use App\Models\Idc;
    use App\Models\IDCDates;
    use App\Models\Reference;
    use App\Models\ResearchTopic;
    use App\Models\ScientificArticleReport;
    use App\Models\StudentTeam;
    use App\Models\Team;
    use App\Models\User;
    use App\Notifications\GenerateSAR;
    use Carbon\Carbon;
    use DateTime;
    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor as TemplateProcessor;

    class ScientificArticleReportController extends Controller
    {
        public function getSources($idcId, $idScientificArticleReport) {
            $role = session('role');

            $dates = IDCDates::select('Idc_Date.startDateScientificArticleReport', 'Idc_Date.endDateScientificArticleReport')->first();

            $scientificArticleReport = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->join('Scientific_Article_Report', 'Idc.idcId', '=', 'Scientific_Article_Report.idIdc')
                ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->select('Idc.idcId', 'Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                'Team.teamId', 'Subject.subjectId',  'Scientific_Article_Report.state', 'Scientific_Article_Report.previousState',
                'Scientific_Article_Report.code AS scientificArticleCode', 'Scientific_Article_Report.spanishSummary', 'Scientific_Article_Report.englishSummary',
                'Scientific_Article_Report.keywords', 'Scientific_Article_Report.introduction', 'Scientific_Article_Report.methodology', 'Scientific_Article_Report.subtitle',
                'Scientific_Article_Report.secondSubtitle', 'Scientific_Article_Report.thirdSubtitle', 'Scientific_Article_Report.updated_at', 'Scientific_Article_Report.storagePath')
                ->where('Idc.idcId', $idcId)
                ->first();

            $references = Reference::join('Article_Reference', 'Reference.referenceId', '=', 'Article_Reference.idReference')
                ->where('idScientificArticleReport', $idScientificArticleReport)
                ->orderby('state')
                ->get();

            $conclusions = Conclusion::join('Article_Conclusion', 'Conclusion.conclusionId', '=', 'Article_Conclusion.idConclusion')
                ->where('idScientificArticleReport', $idScientificArticleReport)
                ->orderby('state')
                ->get();

            if($scientificArticleReport->state !== 'Sin Intento') {
                return redirect()->back();
            }

            // $now = Carbon::now();

            // if ($now < Carbon::parse($dates->startDateScientificArticleReport)) {
            //     return redirect()->back();
            // }

            return view('layouts.scientificArticleReport', compact('role', 'idcId', 'idScientificArticleReport', 'scientificArticleReport', 'references', 'conclusions'));
        }

        public function editConclusion(Request $request) {
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $conclusionId = $request->input('conclusionId');

            $conclusion = Conclusion::find($conclusionId);
            $conclusion->conclusion = $request->input('conclusion');
            $conclusion->save();

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
        }

        public function deleteConclusion(Request $request) {
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $conclusionId = $request->input('conclusionId');
            $conclusion = Conclusion::find($conclusionId);

            $conclusion->delete();

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
        }

        public function editReference(Request $request) {
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $referenceId = $request->input('referenceId');

            $reference = Reference::find($referenceId);
            $reference->reference = $request->input('reference');
            $reference->save();

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
        }

        public function deleteReference(Request $request) {
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $referenceId = $request->input('referenceId');
            $reference = Reference::find($referenceId);

            $reference->delete();

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
        }

        public function createConclusion(Request $request){
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $userId = session('userId');
            $user = User::find($userId);
            $INIT_STATE = 'Por aprobar';

            $conclusion = new Conclusion();
            $conclusion->conclusion = $request->input('conclusion');
            $conclusion->state = $INIT_STATE;
            $conclusion->studentContribute = auth()->user()->userId;
            $conclusion->save();

            $articleConclusion = new ArticleConclusion();
            $articleConclusion->idScientificArticleReport = $idScientificArticleReport;
            $articleConclusion->idConclusion = $conclusion->conclusionId;
            $articleConclusion->save(); 

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
        }

        public function updateConclusion($idConclusion) {
            $APROVED_STATE = 'Aprobado';
            
            try {
                $conclusion = Conclusion::find($idConclusion);
                $conclusion->state = $APROVED_STATE;
                $conclusion->save();
        
                return $conclusion->state;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        public function createReference(Request $request) {
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $userId = session('userId');
            $user = User::find($userId);
            $INIT_STATE = 'Por aprobar';
            
            $reference = new Reference();
            $reference->reference = $request->input('reference');
            $reference->state = $INIT_STATE;
            $reference->studentContribute = auth()->user()->userId;
            $reference->save();

            $articleReference = new ArticleReference();
            $articleReference->idScientificArticleReport = $idScientificArticleReport;
            $articleReference->idReference = $reference->referenceId;
            $articleReference->save(); 

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
        }

        public function updateReference($idReference) {
            $APROVED_STATE = 'Aprobado';
            
            try {
                $reference = Reference::find($idReference);
                $reference->state = $APROVED_STATE; 
                $reference->save();
        
                return $reference->state;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        public function saveProgress(Request $request ,$idScientificArticleReport) {
            $scientificArticle = ScientificArticleReport::find($idScientificArticleReport);
            $scientificArticle->spanishSummary = $request->input('spanishSummary');
            $scientificArticle->englishSummary = $request->input('englishSummary');
            $scientificArticle->keywords = $request->input('keywords');
            $scientificArticle->introduction = $request->input('introduction');
            $scientificArticle->methodology = $request->input('methodology');
            $scientificArticle->subtitle = $request->input('subtitle');
            $scientificArticle->secondSubtitle = $request->input('secondSubtitle');
            $scientificArticle->thirdSubtitle = $request->input('thirdSubtitle');
            $scientificArticle->save();

            return redirect()->back();
        }

        public function generateWord(Request $request) {
            // Obtenemos datos del formulario
            $REVISION_STATE = 'En revisión';
            $data = $request->all();
            $idcId = $data['idcId'];
            $idScientificArticleReport = $data['idScientificArticleReport'];

            // Creamos una variable para la fecha actual
            $fechaActual = new DateTime();
            $fechaCarbon = Carbon::parse($fechaActual);
            $fechaFormateada = $fechaCarbon->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
            $fechaFormateadaConHora = $fechaCarbon->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm');

            $topic = ResearchTopic::join('Team', 'Research_Topic.researchTopicId', '=', 'Team.idResearchTopic')
                ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->where('Idc.idcId', $idcId)
                ->select('Research_Topic.themeName', 'Research_Topic.code', 'Subject.nameSubject', 'User.name', 'Cycle.cycle')
                ->first();

            $fileName = $topic->code.'-SAR.docx';
            $filePath = public_path('documents/'.$fileName);

            $scientificArticle = ScientificArticleReport::find($idScientificArticleReport);
            $scientificArticle->code = $fileName;
            $scientificArticle->creationDate = $fechaCarbon;
            $scientificArticle->numberOfWords = $data['numbersOfWords'];
            $scientificArticle->storagePath = 'documents/'.$fileName;
            $scientificArticle->state = $REVISION_STATE;
            $scientificArticle->save();

            // Cargamos la plantilla del segundo informe
            $templatePath = public_path('documents/Segundo_Informe_Plantilla.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            $students = User::whereHas('student.studentTeam.team.idc', function ($query) use ($idcId) {
                $query->where('idcId', $idcId);
            })->get(['userId as i', 'name as student']);

            // Datos de la Portada
            $templateProcessor->setValue('nameTeacher', $topic->name);
            $templateProcessor->setValue('nameSubject', $topic->nameSubject);
            $templateProcessor->setValue('nameResearchTopic', $topic->themeName);
            $templateProcessor->setValue('cycle', $topic->cycle);
            $datosStudents = json_decode($students, true);
            $templateProcessor->cloneBlock('block_students', 0, true, false, $datosStudents);
            $templateProcessor->setValue('date', $fechaFormateada);
            $templateProcessor->setValue('PAGE_BREAK', '</w:t></w:r>'.' <w:r ><w:br w:type="página"/></w:r>' . '<w:r><w:t>');

            // Datos del Artículo Cientifíco
            // 1. Resumenes
            $templateProcessor->setValue('spanishSummary', $scientificArticle['spanishSummary']);
            $templateProcessor->setValue('englishSummary', $scientificArticle['englishSummary']);
            $templateProcessor->setValue('keywords', $scientificArticle['keywords']);

            // 2. Introducción y metodología
            $templateProcessor->setValue('introduction', $scientificArticle['introduction']);
            $templateProcessor->setValue('methodology', $scientificArticle['methodology']);

            // 3. Desarrollo
            $templateProcessor->setValue('subtitle', $scientificArticle['subtitle']);
            $templateProcessor->setValue('secondSubtitle', $scientificArticle['secondSubtitle']);
            $templateProcessor->setValue('thirdSubtitle', $scientificArticle['thirdSubtitle']);

            // 4. Conclusiones
            $conclusions = Conclusion::join('Article_Conclusion', 'Conclusion.conclusionId', '=', 'Article_Conclusion.idConclusion')
                ->where('Article_Conclusion.idScientificArticleReport', $idScientificArticleReport)
                ->where('Conclusion.state', 'Aprobado')
                ->select('Conclusion.conclusion')
                ->get();

            $datosConclusions = json_decode($conclusions, true);
            $templateProcessor->cloneBlock('block_conclusions', 0, true, false, $datosConclusions);
        
            // 5. Referencias bibliográficas
            $references = Reference::join('Article_Reference', 'Reference.referenceId', '=', 'Article_Reference.idReference')
                ->where('Article_Reference.idScientificArticleReport', $idScientificArticleReport)
                ->where('Reference.state', 'Aprobado')
                ->select('Reference.reference')
                ->get();

            $datosReferences = json_decode($references, true);
            $templateProcessor->cloneBlock('block_references', 0, true, false, $datosReferences);

            $templateProcessor->saveAs($filePath);

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

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new GenerateSAR($scientificArticle, $idcId));
            }

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }
    }
?>