<?php
    namespace App\Http\Controllers;
    use App\Models\ScientificArticleReport;
    use DateTime;
    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor as TemplateProcessor;

    class ScientificArticleReportController extends Controller
    {
        public function getSources($idcId, $idScientificArticleReport) {
            $role = session('role');

            return view('layouts.scientificArticleReport', compact('role', 'idcId', 'idScientificArticleReport'));
        }

        public function generateWord(Request $request) {
            // Obtenemos datos del formulario
            $data = $request->all();
            $fileName = 'SRV-DB-E1-I24-SAR.docx';
            $filePath = public_path('documents/'.$fileName);
            $idcId = $data['idcId'];
            $idScientificArticleReport = $data['idScientificArticleReport'];

            $scientificArticle = ScientificArticleReport::find($idScientificArticleReport);
            $scientificArticle->code = 'SRV-DB-E1-I24-SAR';
            $scientificArticle->spanishSummary = $data['spanishSummary'];
            $scientificArticle->englishSummary = $data['englishSummary'];
            $scientificArticle->keywords = $data['keywords'];
            $scientificArticle->introduction = $data['introduction'];
            $scientificArticle->development = $data['introduction'];
            $scientificArticle->methodology = $data['methodology'];
            $scientificArticle->conclusion = $data['conclusion'];
            $scientificArticle->bibliographicReferences = $data['bibliographicReferences'];
            $scientificArticle->numberOfWords = 300;
            $scientificArticle->storagePath = 'documents/'.$fileName;
            $scientificArticle->state = 'Creado';
            $scientificArticle->idIdc = $data['idcId'];   
            $scientificArticle->save();

            // Creamos una variable para la fecha actual
            $fechaActual = new DateTime();
            // Formateamos la fecha en D/M/A
            $fechaFormateada = $fechaActual->format('d \d\e F \d\e Y');

            // Cargamos la plantilla del primer informe
            $templatePath = public_path('documents/Segundo_Informe_Plantilla.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            // Datos de la Portada
            $templateProcessor->setValue('nameTeacher', 'Rafael Leonardo Jiménez Álvarez');
            $templateProcessor->setValue('nameSubject', 'Administración de Servidores');
            $templateProcessor->setValue('nameResearchTopic', 'Servidores de bases de datos');
            $templateProcessor->setValue('date', $fechaFormateada);

            // Datos del Artículo Cientifíco
            $templateProcessor->setValue('spanishSummary', $data['spanishSummary']);
            $templateProcessor->setValue('englishSummary', $data['englishSummary']);
            $templateProcessor->setValue('keywords', $data['keywords']);
            $templateProcessor->setValue('introduction', $data['introduction']);
            $templateProcessor->setValue('methodology', $data['methodology']);
            $templateProcessor->setValue('conclusion', $data['conclusion']);
            $templateProcessor->setValue('bibliographicReferences', $data['bibliographicReferences']);

            $templateProcessor->saveAs($filePath);

            return redirect()->route('scientificArticle', compact('idcId', 'idScientificArticleReport'));
        }
    }
?>