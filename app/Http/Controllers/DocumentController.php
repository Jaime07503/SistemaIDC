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

            // Método elegido para la orientación del equipo
            $templateProcessor->setValue('orientation', $data['orientation']);
            $templateProcessor->setValue('induction', $data['induction']);
            $templateProcessor->setValue('teamBehavior', $data['teamBehavior']);

            // Plan de búsqueda de información
            $templateProcessor->setValue('searchPlan', $data['searchPlan']);
            if ($request->hasFile('imageDiagram')) {
                $image = $request->file('imageDiagram');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/documents', $imageName);
                $imagePath = 'storage/images/' . $imageName;
        
                // Ahora puedes utilizar $imagePath en tu plantilla de Word
                $templateProcessor->setImageValue('imageDiagram', $imagePath);
            }

            // Tabla de volcado de información
            if (!is_null($datos)) {
                $templateProcessor->cloneRowAndSetValues('sourceId', $datos);
            }

            // Resumen de reuniones y definicion de Objetivos
            $templateProcessor->setValue('meetings', $data['meetings']);
            $templateProcessor->setValue('valorationTeam', $data['teamComment']);

            // Criterios de seleccion de la informacion

            // Comentario final
            $templateProcessor->setValue('finalComment', $data['finalComment']);

            $fileName = 'SRVDBCI2024';
            $templateProcessor->saveAs($fileName.'.docx');
            return response()->download($fileName.'.docx')->deleteFileAfterSend(true);
        }
    }
?>