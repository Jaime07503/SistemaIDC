<?php
    namespace App\Http\Controllers;

    use App\Models\ResearchTopic;
    use App\Models\StudentResearchTopic;
    use App\Models\StudentSubject;
    use App\Models\StudentTeam;
    use App\Models\Subject;
    use App\Models\Team;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class ResearchTopicInformationController extends Controller
    {
        public function store(Request $request)
        {
            $idStudent = $request->input('idStudent');
            $idSubject = $request->input('idSubject');
            $researchTopicId = $request->input('researchTopicId');
            
            $researchTopics = ResearchTopic::where('idSubject', $idSubject)->get();
            $subject = Subject::find($idSubject);

            StudentSubject::where('idStudent', $idStudent)
                ->where('idSubject', $idSubject)
                ->increment('applicationCount');

            StudentResearchTopic::create([
                'idStudent' => $idStudent,
                'idResearchTopic' => $researchTopicId,
                'state' => 'Postulado',
            ]);

            return Redirect::route('researchTopics', ['researchTopicId' => $researchTopicId, 'subjectId' => $idSubject]);
        }

        public function getResearchTopicInformation($researchTopicId, $subjectId)
        {
            $studentId = session('studentId');
            $researchTopic = ResearchTopic::where('researchTopicId', $researchTopicId)->first();

            $studentResearch = Subject::join('student_subject', function ($join) use ($subjectId, $studentId) {
                $join->on('subject.subjectId', '=', 'student_subject.idSubject')
                    ->where('student_subject.idStudent', '=', $studentId);
            })
            ->where('subject.subjectId', $subjectId)
            ->select('subject.*', 'student_subject.applicationCount')
            ->first();

            $postulatedSubject = ResearchTopic::join('student_research_topic', function ($join) use ($researchTopicId, $studentId) {
                $join->on('research_topic.researchTopicId', '=', 'student_research_topic.idResearchTopic')
                    ->where('student_research_topic.idStudent', '=', $studentId)
                    ->where('student_research_topic.idResearchTopic', '=', $researchTopicId);
            })
            ->where('research_topic.researchTopicId', $researchTopicId)
            ->select('research_topic.*', 'student_research_topic.state')
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
                        
            return view('layouts.researchTopicInformation', compact('researchTopic', 'researchTopicId', 'studentResearch', 'postulatedSubject' , 'studentId', 'subjectId', 'result'));            
        }
    }
?>