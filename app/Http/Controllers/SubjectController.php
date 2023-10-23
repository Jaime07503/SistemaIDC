<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Subject;

    class SubjectController extends Controller
    {
        public function obtenerMaterias(Request $request)
        {
            $career = $request->input('career');
            $year = $request->input('year');

            // Realiza la consulta a la base de datos para obtener las materias según la carrera y el año
            $materias = Subject::where('career', $career)
                ->where('subjectYear', $year)
                ->get();

            return response()->json($materias);
        }
    }
?>