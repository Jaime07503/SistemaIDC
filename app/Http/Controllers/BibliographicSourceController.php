<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\BibliographicSource;

    class BibliographicSourceController extends Controller
    {
        public function create(Request $request)
        {
            // Obtenemos los datos envíados desde el formulario
            $data = json_decode($request->input('datos'), true);

            // Recorremos los datos para agregarlos a la DB
            if(!is_null($data))
            {
                foreach ($data as $bSource)
                {
                    // Creamos una nueva instancia del Modelo BibliographicSource 
                    $bibliographicSource = new BibliographicSource;
                    $bibliographicSource->bibliographicSourceType = $bSource['bibliographicSourceType'];
                    $bibliographicSource->author = $bSource['author'];
                    $bibliographicSource->year = $bSource['year'];
                    $bibliographicSource->averageType = $bSource['averageType'];
                    $bibliographicSource->link = $bSource['link'];
                    $bibliographicSource->save();
                }

                return response()->json(['error' => 'Datos agregados correctamente']);
            }

            return response()->json(['error' => 'No se recibieron datos válidos.']);
        }
    }
?>