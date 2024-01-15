<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
    use App\Models\StudentResearchTopic;
    use App\Models\StudentSubject;
    use App\Models\Subject;
    use App\Models\Team;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class ResearchTopicInformationController extends Controller
    {
        public function store(Request $request)
        {
            $idStudent = $request->input('idStudent');
            $idSubject = $request->input('idSubject');
            $researchTopicId = $request->input('researchTopicId');

            StudentSubject::where('idStudent', $idStudent)
                ->where('idSubject', $idSubject)
                ->increment('applicationCount');

            StudentResearchTopic::create([
                'idStudent' => $idStudent,
                'idResearchTopic' => $researchTopicId,
                'state' => 'Postulado',
            ]);

            return Redirect::route('researchTopics', ['subjectId' => $idSubject]);
        }

        public function getResearchTopicInformation($researchTopicId, $subjectId)
        {
            $studentId = session('studentId');
            $subject = Subject::where('subjectId', $subjectId)->first();
            $researchTopic = ResearchTopic::where('researchTopicId', $researchTopicId)->first();

            $studentResearch = Subject::join('Student_Subject', function ($join) use ($subjectId, $studentId) {
                $join->on('Subject.subjectId', '=', 'Student_Subject.idSubject')
                    ->where('Student_Subject.idStudent', '=', $studentId);
            })
            ->where('Subject.subjectId', $subjectId)
            ->select('Subject.*', 'Student_Subject.applicationCount')
            ->first();

            $postulatedSubject = ResearchTopic::join('Student_Research_Topic', function ($join) use ($researchTopicId, $studentId) {
                $join->on('Research_Topic.researchTopicId', '=', 'Student_Research_Topic.idResearchTopic')
                    ->where('Student_Research_Topic.idStudent', '=', $studentId)
                    ->where('Student_Research_Topic.idResearchTopic', '=', $researchTopicId);
            })
            ->where('Research_Topic.researchTopicId', $researchTopicId)
            ->select('Research_Topic.*', 'Student_Research_Topic.state')
            ->first();

            // Obtener todos los equipos (teams) asociados al $researchTopicId
            $teams = Team::where('idResearchTopic', $researchTopicId)
                ->with('studentTeam.student') // Cargar la relación studentTeam y, a través de ella, cargar la relación student
                ->get();

            // Inicializar un array para almacenar los resultados finales
            $result = [];

            // Recorrer cada equipo para obtener los estudiantes asociados
            foreach ($teams as $team) {
                // Obtener los estudiantes directamente de la relación cargada
                $students = $team->studentTeam->pluck('student');
                $userDetails = $students->map(function ($student) {
                    return $student->user; // asumiendo que hay una relación user en el modelo Student
                });

                // Agregar el equipo y los estudiantes al array de resultados
                $result[] = [
                    'team' => $team,
                    'students' => $students,
                    'user' => $userDetails,
                ];
            }
                        
            return view('layouts.researchTopicInformation', compact('researchTopic', 'subject','researchTopicId', 'studentResearch', 'postulatedSubject' , 'studentId', 'subjectId', 'result'));            
        }
    }
?>