<?php
    namespace App\Http\Controllers;
    use App\Models\BibliographicSource;
    use App\Models\Idc;
    use App\Models\Objetive;
    use App\Models\ResearchTopic;
    use App\Models\StudentTeam;
    use App\Models\Team;
    use DateTime;
    use App\Models\TopicSearchReport;
    use App\Models\User;
    use App\Notifications\GenerateTSR;
    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor as TemplateProcessor;
    use Carbon\Carbon;
    
    class DocumentController extends Controller
    {
        public function generateWord(Request $request)
        {
            // Obtenemos los datos del formulario
            $REVISION_STATE = 'En revisión';
            $data = $request->all();
            $datos = json_decode($request->input('datos'), true);
            $datosOE = json_decode($request->input('objetivesOE'), true);
            $idcId = $data['idcId'];
            $idTopicSearchReport = $data['idTopicSearchReport'];

            // Creamos una variable para la fecha actual
            $fechaActual = new DateTime();
            $fechaCarbon = Carbon::parse($fechaActual);
            $fechaFormateada = $fechaCarbon->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
            $fechaArchivo = $fechaCarbon->locale('es')->isoFormat('D-MMMM-YYYY-HH:mm');
            
            $topic = ResearchTopic::join('Team', 'Research_Topic.researchTopicId', '=', 'Team.idResearchTopic')
                ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->where('Idc.idcId', $idcId)
                ->select('Research_Topic.themeName', 'Research_Topic.code', 'Subject.nameSubject', 'User.name', 'Cycle.cycle')
                ->first();

            $fileName = $topic->code.'-TSR.docx';
            $filePath = public_path('documents/' . $fileName);

            $topicSearchReport = TopicSearchReport::find($idTopicSearchReport);
            $topicSearchReport->code = $fileName;
            $topicSearchReport->creationDate = $fechaCarbon;
            $topicSearchReport->storagePath = 'documents/'.$fileName;
            $topicSearchReport->state = $REVISION_STATE;
            $topicSearchReport->save();

            // Cargamos la plantilla del primer informe
            $templatePath = public_path('documents/Primer_Informe_Plantilla.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            // Datos de la Portada
            $templateProcessor->setValue('nameTeacher', $topic->name);
            $templateProcessor->setValue('nameSubject', $topic->nameSubject);
            $templateProcessor->setValue('nameResearchTopic', $topic->themeName);
            $templateProcessor->setValue('cycle', $topic->cycle);
            // Estudiantes del equipo de investigación
            $students = User::whereHas('student.studentTeam.team.idc', function ($query) use ($idcId) {
                $query->where('idcId', $idcId);
            })->get(['name as student']);
            $collaborator = User::whereHas('student.studentTeam.team.idc', function ($query) use ($idcId) {
                $query->where('idcId', $idcId);
            })->get(['name as collaborator']);
            $datosStudents = json_decode($students, true);
            $datosCollaborators = json_decode($collaborator, true);
            $templateProcessor->cloneBlock('block_students', 0, true, false, $datosStudents);
            $templateProcessor->cloneBlock('block_collaborators', 0, true, false, $datosCollaborators);
            $templateProcessor->setValue('date', $fechaFormateada);
            $templateProcessor->setValue('PAGE_BREAK', '</w:t></w:r>'.' <w:r ><w:br w:type="página"/></w:r>' . '<w:r><w:t>');

            // 1. Método elegido para la orientación del equipo
            $templateProcessor->setValue('orientation', $data['orientation']);
            $templateProcessor->setValue('induction', $data['induction']);

            // 2. Plan de búsqueda de información
            $templateProcessor->setValue('searchPlan', $data['searchPlan']);
            if ($request->hasFile('Imagen-Diagrama')) {
                $imagen = $request->file('Imagen-Diagrama');
            
                if ($imagen->isValid() && strpos($imagen->getMimeType(), 'image/') === 0) {
                    $templateProcessor->setImageValue('imageDiagram', array('path' => $imagen->getPathname(), 'width' => 550, 'height' => 300, 'ratio' => false));
                }
            } 

            // 3. Tabla de volcado de del resultado de investigación inicial
            $sources = BibliographicSource::join('Source_Search', 'Bibliographic_Source.bibliographicSourceId', '=', 'Source_Search.idBibliographicSource')
                ->where('idTopicSearchReport', $idTopicSearchReport)
                ->select('Bibliographic_Source.source as sourceII', 'Bibliographic_Source.author as authorII', 'Bibliographic_Source.year as yearII',
                'Bibliographic_Source.averageType as averageTypeII', 'Bibliographic_Source.link as linkII', 'Bibliographic_Source.bibliographicSourceId as s')
                ->get();

            $datosSources = json_decode($sources, true);
            $templateProcessor->cloneRowAndSetValues('s', $datosSources);

            // 4. Resumen de reuniones y definición de objetivos
            $templateProcessor->setValue('meetings', $data['meetings']);
            $objetiveG = Objetive::join('Source_Objetive', 'Objetive.objetiveId', '=', 'Source_Objetive.idObjetive')
                ->where('Source_Objetive.idTopicSearchReport', $idTopicSearchReport)
                ->where('Objetive.type', 'General')
                ->where('Objetive.state', 'Aprobado')
                ->select('Objetive.objetive as generalObjetive')
                ->first();

            $templateProcessor->setValue('generalObjetive', $objetiveG->generalObjetive);

            $objetivesE = Objetive::join('Source_Objetive', 'Objetive.objetiveId', '=', 'Source_Objetive.idObjetive')
                ->where('Source_Objetive.idTopicSearchReport', $idTopicSearchReport)
                ->where('Objetive.type', 'Especifico')
                ->where('Objetive.state', 'Aprobado')
                ->select('Objetive.objetive as specific_objetive')
                ->get();

            $datosObjetiveE = json_decode($objetivesE, true);
            $templateProcessor->cloneBlock('block_specific_objetives', 0, true, false, $datosObjetiveE);

            // 5. Criterios de selección de la información
            $templateProcessor->setValue('criteria', $data['criteria']);
            $sourcesA = BibliographicSource::join('Source_Search', 'Bibliographic_Source.bibliographicSourceId', '=', 'Source_Search.idBibliographicSource')
                ->where('Source_Search.idTopicSearchReport', $idTopicSearchReport)
                ->where('Bibliographic_Source.state', 'Aprobado')
                ->select('Bibliographic_Source.theme as theme', 'Bibliographic_Source.year as year', 'Bibliographic_Source.averageType as averageType', 
                'Bibliographic_Source.link as link', 'Bibliographic_Source.bibliographicSourceId as d')
                ->get();

            $datosSourcesA = json_decode($sourcesA, true);
            $templateProcessor->cloneRowAndSetValues('d', $datosSourcesA);
            
            // 6. Valoración del catedrático sobre el equipo
            $templateProcessor->setValue('teamValoration', $data['teamValoration']);

            $jsonStudents = [];
            
            foreach ($data as $key => $value) {
                $parts = explode('-', $key, 3);
            
                if (count($parts) === 3 && $parts[0] === 'Criterio') {
                    $studentName = str_replace('_', ' ', $parts[1]);
                    $criterionNumber = $parts[2];
            
                    if (is_numeric($criterionNumber)) {
                        $calificationKey = 'calification' . $criterionNumber;
            
                        if (!isset($jsonStudents[$studentName])) {
                            $jsonStudents[$studentName] = [
                                'student' => $studentName,
                                'nameSubject' => $topic->nameSubject,
                            ];
                        }
            
                        $jsonStudents[$studentName][$calificationKey] = $value;
                    }
                }
            }
            
            // Convertir a JSON
            $jsonResult = json_encode(array_values($jsonStudents), JSON_PRETTY_PRINT);

            $studentsData = json_decode($jsonResult, true);
            $templateProcessor->cloneBlock('block_table', 0, true, false, $studentsData);
            
            // 7. Comentario final
            $templateProcessor->setValue('PAGE_BREAK2', '</w:t></w:r>'.' <w:r ><w:br w:type="página"/></w:r>' . '<w:r><w:t>');
            $templateProcessor->setValue('finalComment', $data['finalComment']);

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

            $coordinator = Idc::select('Idc.idUser')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($coordinator->idUser);
            $user->notify(new GenerateTSR($topicSearchReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new GenerateTSR($topicSearchReport, $idcId));
            }

            return redirect()->route('searchInformation', compact('idcId', 'idTopicSearchReport'));
        }
    }
?>