<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpWord\TemplateProcessor;

class DocumentController extends Controller
{
    public function generateWord(Request $request)
    {
        $data = $request->all();

        $templateProcessor = new TemplateProcessor('template.docx');

        $templateProcessor->setValue('resumen_espanol', $data['resumen_espanol']);
        $templateProcessor->setValue('resumen_ingles', $data['resumen_ingles']);
        $templateProcessor->setValue('introduccion', $data['introduccion']);
        $templateProcessor->setValue('metodologia', $data['metodologia']);
        $templateProcessor->setValue('desarrollo', $data['desarrollo']);
        $templateProcessor->setValue('conclusiones', $data['conclusiones']);
        $templateProcessor->setValue('referencias', $data['referencias']);

        $fileName = 'documento.docx';
        $templateProcessor->saveAs($fileName);

        return response()->download($fileName);
    }
}
