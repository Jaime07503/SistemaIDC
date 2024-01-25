<?php
    namespace App\Http\Controllers;
    use App\Models\Subject;
    use App\Models\Career;
    use App\Models\Cycle;
    use App\Models\Faculty;
    use App\Models\Teacher;
    use Illuminate\Http\Request;

    class SubjectController extends Controller
    {
        public function getSubject()
        {
            $facultys = Faculty::all();
            $careers = Career::get();
            $cycles = Cycle::all();
            $subjects = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Career', 'Subject.idCareer', '=', 'Career.careerId')
                ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->get();

            return view('layouts.subject', compact('facultys', 'careers', 'subjects', 'cycles'));
        }

        public function addSubject(Request $request)
        {
            $INITIAL_STATE = 'Activo';
            // Create new Subject
            $subject = new Subject();
            $subject->code = $request->input('code');
            $subject->nameSubject = $request->input('nameSubject');
            $subject->section = $request->input('section');
            // $subject->avatar = $request->input('Avatar');
            $subject->state = $INITIAL_STATE;
            $subject->idCycle = $request->input('idCycle');
            $subject->idCareer = $request->input('idCareer');

            $subject->save();

            return redirect()->route('subject');
        }

        public function editSubject(Request $request)
        {
            // Edit subject by subjectId
            $subjectId = $request ->input('subjectId');

            $subject = Subject::find($subjectId);

            if (!$subject) {
                return response()->json(['message' => 'Materia no encontrada'], 404);
            }

            if ($request->isMethod('post')) {
                $subject->code = $request->input('code');
                // ... (actualizar los demás campos)

                if ($request->input('role') === 'Docente') {
                    // Actualizar Teacher si existe o crear uno nuevo
                    // ...
                }

                $subject->save();

                return redirect()->route('subjects.index')->with('success', 'Materia actualizada');
            }
        }
    }
?>