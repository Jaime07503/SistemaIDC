<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
    use App\Models\StudentResearchTopic;
    use App\Models\StudentSubject;
    use App\Models\Subject;
    use App\Models\Team;
    use Illuminate\Http\Request;

    class ResearchTopicInformationController extends Controller
    {
        public function getResearchTopicInformation($researchTopicId, $subjectId)
        {
            $userId = auth()->user()->userId;
            $role = auth()->user()->role;

            $subject = Subject::where('subjectId', $subjectId)->first();
            if ($subject->idTeacher !== $userId) {
                $isStudentOfSubject = StudentSubject::where('idStudent', $userId)
                                                    ->where('idSubject', $subjectId)
                                                    ->exists();
                if (!$isStudentOfSubject) {
                    return redirect()->back();
                }
            }
            
            $studentId = session('studentId');
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

            if($role === 'Estudiante') {
                $teams = Team::where('idResearchTopic', $researchTopicId)
                    ->whereHas('studentTeam', function ($query) use ($studentId) {
                        $query->where('idStudent', $studentId);
                    })
                    ->with('studentTeam.student')
                    ->get();
            } else {
                $teams = Team::where('idResearchTopic', $researchTopicId)
                ->with('studentTeam.student') 
                ->get();
            }

            $result = [];

            foreach ($teams as $team) {
                $students = $team->studentTeam->pluck('student');
                $userDetails = $students->map(function ($student) {
                    return $student->user; 
                });

                $result[] = [
                    'team' => $team,
                    'students' => $students,
                    'user' => $userDetails,
                ];
            }
                        
            return view('layouts.researchTopicInformation', compact('researchTopic', 'subject', 'researchTopicId', 'studentResearch', 'postulatedSubject' , 'studentId', 'subjectId', 'result'));            
        }

        public function store(Request $request)
        {
            $idStudent = $request->input('idStudent');
            $subjectId = $request->input('idSubject');
            $researchTopicId = $request->input('researchTopicId');

            StudentSubject::where('idStudent', $idStudent)
                ->where('idSubject', $subjectId)
                ->increment('applicationCount');

            StudentResearchTopic::create([
                'idStudent' => $idStudent,
                'idResearchTopic' => $researchTopicId,
                'state' => 'Postulado',
            ]);

            return redirect()->route('researchTopicInformation', compact('researchTopicId', 'subjectId'));
        }
    }
?>