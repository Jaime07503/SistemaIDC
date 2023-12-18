<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor as TemplateProcessor;

    class DocumentController extends Controller
    {
        public function generateWord(Request $request)
        {
            // Obtiene los datos del formulario
            $data = $request->all();
            $datos = json_decode($request->input('datos'), true);

            // Carga la plantilla del informe
            $templatePath = public_path('documents/template.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            // Datos de la Portada
            $templateProcessor->setValue('nameTeacher', 'Ma. Rafael Leonardo Jiménez Álvarez');
            $templateProcessor->setValue('nameSubject', 'Administración de Servidores');
            $templateProcessor->setValue('nameResearchTopic', 'Servidores de bases de datos');
            $templateProcessor->setValue('date', '24 de febrero de 2024');

            // Datos de la tabla de volcado de información
            if (!is_null($datos)) {
                $templateProcessor->cloneRowAndSetValues('sourceId', $datos);
                $fileName = 'SRVDBCI2024';
                $templateProcessor->saveAs($fileName.'.docx');
                return response()->download($fileName.'.docx')->deleteFileAfterSend(true);
            }

            // Manejar el caso en que $datos sea null (puedes devolver un mensaje de error, por ejemplo)
            return response()->json(['error' => 'No se recibieron datos válidos.']);

            // $outputPath = public_path('documents/output.docx');
            // $phpWord->save($outputPath);
            // return response()->download($outputPath);

            // $templateProcessor->setValue('resumen_espanol', $data['orientation']);
            // $templateProcessor->setValue('resumen_ingles', $data['searchPlan']);
            // $templateProcessor->setValue('introduccion', $data['meetings']);
            // $templateProcessor->setValue('metodologia', $data['generalObjetive']);
            // $templateProcessor->setValue('desarrollo', $data['desarrollo']);
            // $templateProcessor->setValue('conclusiones', $data['conclusiones']);
            // $templateProcessor->setValue('referencias', $data['referencias']);

            // $fileName = 'documento.docx';
            // $templateProcessor->saveAs($fileName);

            // return response()->download($fileName);
        }
    }
?>