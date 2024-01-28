<?php
    namespace App\Http\Controllers;
    use App\Models\ArticleConclusion;
    use App\Models\ArticleDevelopment;
    use App\Models\ArticleReference;
    use App\Models\Conclusion;
    use App\Models\Development;
    use App\Models\Idc;
    use App\Models\Reference;
    use App\Models\ResearchTopic;
    use App\Models\ScientificArticleReport;
    use App\Models\User;
    use Carbon\Carbon;
    use DateTime;
    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor as TemplateProcessor;

    class ScientificArticleReportController extends Controller
    {
        public function getSources($idcId, $idScientificArticleReport) {
            $role = session('role');
            if($role !== 'Estudiante') {
                $scientificArticleReport = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                    ->join('Scientific_Article_Report', 'Idc.idcId', '=', 'Scientific_Article_Report.idIdc')
                    ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                    ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                    ->select('Idc.endDateScientificArticleReport', 'Idc.idcId',
                    'Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                    'Team.teamId', 'Subject.subjectId',  'Scientific_Article_Report.state', 'Scientific_Article_Report.previousState',
                    'Scientific_Article_Report.code AS scientificArticleCode',
                    'Scientific_Article_Report.updated_at', 'Scientific_Article_Report.storagePath')
                    ->where('Idc.idcId', $idcId)
                    ->first();

                $contents = Development::join('Article_Development', 'Development.developmentId', '=', 'Article_Development.idDevelopment')
                    ->where('idScientificArticleReport', $idScientificArticleReport)
                    ->orderby('state')
                    ->get();

                $references = Reference::join('Article_Reference', 'Reference.referenceId', '=', 'Article_Reference.idReference')
                    ->where('idScientificArticleReport', $idScientificArticleReport)
                    ->orderby('state')
                    ->get();

                $conclusions = Conclusion::join('Article_Conclusion', 'Conclusion.conclusionId', '=', 'Article_Conclusion.idConclusion')
                    ->where('idScientificArticleReport', $idScientificArticleReport)
                    ->orderby('state')
                    ->get();

                return view('layouts.scientificArticleReport', compact('role', 'idcId', 'idScientificArticleReport', 'scientificArticleReport', 'contents', 'references', 'conclusions'));
            } else {
                $userId = session('userId');
                $user = User::find($userId);

                $scientificArticleReport = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                    ->join('Scientific_Article_Report', 'Idc.idcId', '=', 'Scientific_Article_Report.idIdc')
                    ->join('Research_Topic', 'Team.idResearchTopic', '=', 'Research_Topic.researchTopicId')
                    ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                    ->select('Idc.endDateScientificArticleReport', 'Idc.idcId',
                    'Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                    'Team.teamId', 'Subject.subjectId',  'Scientific_Article_Report.state', 'Scientific_Article_Report.code AS scientificArticleCode',
                    'Scientific_Article_Report.updated_at', 'Scientific_Article_Report.storagePath')
                    ->where('Idc.idcId', $idcId)
                    ->first();

                $contents = Development::join('Article_Development', 'Development.developmentId', '=', 'Article_Development.idDevelopment')
                    ->where('idScientificArticleReport', $idScientificArticleReport)
                    ->where('studentContribute', $user->name)
                    ->orderby('state')
                    ->get();

                $references = Reference::join('Article_Reference', 'Reference.referenceId', '=', 'Article_Reference.idReference')
                    ->where('idScientificArticleReport', $idScientificArticleReport)
                    ->where('studentContribute', $user->name)
                    ->orderby('state')
                    ->get();

                $conclusions = Conclusion::join('Article_Conclusion', 'Conclusion.conclusionId', '=', 'Article_Conclusion.idConclusion')
                    ->where('idScientificArticleReport', $idScientificArticleReport)
                    ->where('studentContribute', $user->name)
                    ->orderby('state')
                    ->get();

                return view('layouts.scientificArticleReport', compact('role', 'idcId', 'idScientificArticleReport', 'scientificArticleReport', 'contents', 'references', 'conclusions'));
            }
        }

        public function createDevelopment(Request $request) {
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $userId = session('userId');
            $user = User::find($userId);
            $INIT_STATE = 'Por aprobar';

            $development = new Development();
            $development->subtitle = $request->input('subtitle');
            $development->content = $request->input('content');
            $development->studentContribute = $user->name;
            $development->state = $INIT_STATE;
            $development->save();

            $articleDevelopment = new ArticleDevelopment();
            $articleDevelopment->idScientificArticleReport = $idScientificArticleReport;
            $articleDevelopment->idDevelopment = $development->developmentId;
            $articleDevelopment->save(); 

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
        }

        public function updateDevelopment($idDevelopment) {
            $APROVED_STATE = 'Aprobado';

            try {
                $development = Development::find($idDevelopment);
                $development->state = $APROVED_STATE;
                $development->save();
        
                return $development->state;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        public function editDevelopment(Request $request) {
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $developmentId = $request->input('developmentId');

            $development = Development::find($developmentId);
            $development->subtitle = $request->input('subtitle');
            $development->content = $request->input('content');
            $development->save();

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
        }

        public function deleteDevelopment(Request $request) {
            $idcId = $request->input('idcId');
            $idScientificArticleReport = $request->input('idScientificArticleReport');
            $developmentId = $request->input('developmentId');
            $development = Development::find($developmentId);

            $development->delete();

            return redirect()->route('scientificArticleReport', compact('idcId', 'idScientificArticleReport'));
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
            $conclusion->studentContribute = $user->name;
            $conclusion->state = $INIT_STATE;
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
            $reference->studentContribute = $user->name;
            $reference->state = $INIT_STATE;
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
            $scientificArticle->spanishSummary = $data['spanishSummary'];
            $scientificArticle->englishSummary = $data['englishSummary'];
            $scientificArticle->keywords = $data['keywords'];
            $scientificArticle->introduction = $data['introduction'];
            $scientificArticle->methodology = $data['methodology'];
            $scientificArticle->numberOfWords = 300;
            $scientificArticle->storagePath = 'documents/'.$fileName;
            $scientificArticle->state = $REVISION_STATE;
            $scientificArticle->save();

            // Cargamos la plantilla del primer informe
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
            $templateProcessor->setValue('spanishSummary', $data['spanishSummary']);
            $templateProcessor->setValue('englishSummary', $data['englishSummary']);
            $templateProcessor->setValue('keywords', $data['keywords']);

            // 2. Introducción y metodología
            $templateProcessor->setValue('introduction', $data['introduction']);
            $templateProcessor->setValue('methodology', $data['methodology']);

            // 3. Desarrollo
            $development = Development::join('Article_Development', 'Development.developmentId', '=', 'Article_Development.idDevelopment')
                ->where('Article_Development.idScientificArticleReport', $idScientificArticleReport)
                ->where('Development.state', 'Aprobado')
                ->select('Development.subtitle as sub-title', 'Development.content')
                ->get();

            $datosDevelopments = json_decode($development, true);
            $templateProcessor->cloneBlock('block_development', 0, true, false, $datosDevelopments);

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

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }
    }
?>