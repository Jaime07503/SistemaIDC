<?php
    namespace App\Http\Controllers;
    use App\Models\BibliographicSource;
    use App\Models\Objetive;
    use App\Models\Student;
    use DateTime;
    use App\Models\TopicSearchReport;
    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor as TemplateProcessor;
    use Carbon\Carbon;
    
    class DocumentController extends Controller
    {
        public function generateWord(Request $request)
        {
            // Obtenemos los datos del formulario
            $data = $request->all();
            $datos = json_decode($request->input('datos'), true);
            $datosOE = json_decode($request->input('objetivesOE'), true);
            $fileName = 'SRV-DB-E1-I24-TSR.docx';
            $filePath = public_path('documents/' . $fileName);
            $idcId = $data['idcId'];
            $idTopicSearchReport = $data['idTopicSearchReport'];

            $topicSearchReport = TopicSearchReport::find($idTopicSearchReport);
            $topicSearchReport->code = 'SRV-DB-E1-I24-TSR';
            $topicSearchReport->orientation = $fileName;
            $topicSearchReport->orientation = $data['orientation'];
            $topicSearchReport->induction = $data['induction'];
            $topicSearchReport->searchPlan = $data['searchPlan']; 
            $topicSearchReport->meetings = $data['meetings'];
            $topicSearchReport->teamValoration = $data['teamValoration'];
            $topicSearchReport->finalComment = $data['finalComment'];
            $topicSearchReport->storagePath = 'documents/'.$fileName;
            $topicSearchReport->state = 'Creado';
            $topicSearchReport->idIdc = $idcId;
            $topicSearchReport->save();

            // Creamos una variable para la fecha actual
            $fechaActual = new DateTime();
            $fechaCarbon = Carbon::parse($fechaActual);
            $fechaFormateada = $fechaCarbon->locale('es')->isoFormat('D [de] MMMM [de] YYYY');

            // Cargamos la plantilla del primer informe
            $templatePath = public_path('documents/Primer_Informe_Plantilla.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            // $students = Student::whereHas('student.studentTeam.team.idc', function ($query) use ($idcId) {
            //     $query->where('idcId', $idcId);
            // })->get(['userId', 'name as nameStudent']);

            // Datos de la Portada
            $templateProcessor->setValue('nameTeacher', 'Rafael Leonardo Jiménez Álvarez');
            $templateProcessor->setValue('nameSubject', 'Administración de Servidores');
            $templateProcessor->setValue('nameResearchTopic', 'Servidores de bases de datos');
            $templateProcessor->setValue('cycle', 'Ciclo I 2024');
            // $datosStudents = json_decode($students, true);
            // $templateProcessor->cloneRowAndSetValues('i', $datosStudents);
            $templateProcessor->setValue('date', $fechaFormateada);

            // 1. Método elegido para la orientación del equipo
            $templateProcessor->setValue('orientation', $data['orientation']);
            $templateProcessor->setValue('induction', $data['induction']);

            // 2. Plan de búsqueda de información
            $templateProcessor->setValue('searchPlan', $data['searchPlan']);
            if ($request->hasFile('imageDiagram')) {
                $imagen = $request->file('imageDiagram');
            
                if ($imagen->isValid() && strpos($imagen->getMimeType(), 'image/') === 0) {
                    $templateProcessor->setImageValue('imageDiagram', array('path' => $imagen->getPathname(), 'width' => 550, 'height' => 300, 'ratio' => false));
                } else {
                    echo "La imagen no es válida.";
                }
            } else {
                echo "No se ha proporcionado ninguna imagen.";
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
                ->select('Objetive.objetive as specificObjetive', 'Objetive.objetiveId as o')
                ->get();

            $datosObjetiveE = json_decode($objetivesE, true);
            $templateProcessor->cloneRowAndSetValues('o', $datosObjetiveE);

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
            $templateProcessor->setValue('calification', $data['calification']);
            $templateProcessor->setValue('calification2', $data['calification2']);
            $templateProcessor->setValue('calification3', $data['calification3']);
            $templateProcessor->setValue('calification4', $data['calification4']);
            $templateProcessor->setValue('calification5', $data['calification5']);
            $templateProcessor->setValue('calification6', $data['calification6']);
            $templateProcessor->setValue('calification7', $data['calification7']);
            $templateProcessor->setValue('calification8', $data['calification8']);
            $templateProcessor->setValue('calification9', $data['calification9']);
            $templateProcessor->setValue('teamComment', $data['teamComment']);

            // 7. Comentario final
            $templateProcessor->setValue('finalComment', $data['finalComment']);

            $templateProcessor->saveAs($filePath);

            return redirect()->route('searchInformation', compact('idcId', 'idTopicSearchReport'));
        }
    }
?>