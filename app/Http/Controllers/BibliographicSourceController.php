<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\BibliographicSource;

    class BibliographicSourceController extends Controller
    {
        public function create(Request $request)
        {
            $data = json_decode($request->input('datos'), true);

            if(!is_null($data))
            {
                foreach ($data as $bSource)
                {
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