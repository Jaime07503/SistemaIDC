<?php
    namespace App\Http\Controllers;

    use DateTime;
    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor as TemplateProcessor;

    class DocumentController extends Controller
    {
        public function generateWord(Request $request)
        {
            // Obtiene los datos del formulario
            $data = $request->all();
            $datos = json_decode($request->input('datos'), true);
            $fechaActual = new DateTime();

            // Formatea la fecha en D/M/A
            $fechaFormateada = $fechaActual->format('d \d\e F \d\e Y');

            // Carga la plantilla del informe
            $templatePath = public_path('documents/Primer_Informe_Plantilla.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            // Datos de la Portada
            $templateProcessor->setValue('nameTeacher', 'Ma. Rafael Leonardo Jiménez Álvarez');
            $templateProcessor->setValue('nameSubject', 'Administración de Servidores');
            $templateProcessor->setValue('nameResearchTopic', 'Servidores de bases de datos');
            $templateProcessor->setValue('date', $fechaFormateada);

            // Datos del contenido del informe
            // Método elegido para la orientación del equipo
            $templateProcessor->setValue('orientation', $data['orientation']);
            $templateProcessor->setValue('induction', $data['induction']);
            $templateProcessor->setValue('teamBehavior', $data['teamBehavior']);

            // Plan de búsqueda de información
            $templateProcessor->setValue('searchPlan', $data['searchPlan']);
            // Falta agregar la imagen

            // Tabla de volcado de información
            if (!is_null($datos)) {
                $templateProcessor->cloneRowAndSetValues('sourceId', $datos);
            }

            // Resumen de reuniones y definicion de Objetivos
            // Criterios de seleccion de la informacion

            // Comentario final
            $templateProcessor->setValue('finalComment', $data['finalComment']);

            $fileName = 'SRVDBCI2024';
            $templateProcessor->saveAs($fileName.'.docx');
            return response()->download($fileName.'.docx')->deleteFileAfterSend(true);

            // Manejar el caso en que $datos sea null (puedes devolver un mensaje de error, por ejemplo)
            //return response()->json(['error' => 'No se recibieron datos válidos.']);

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