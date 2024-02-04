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
            $unassignedSubjects = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Career', 'Subject.idCareer', '=', 'Career.careerId')
                ->where('Subject.approvedIdc', 'Por aprobar')
                ->where('Subject.idTeacher', null)
                ->select('Subject.subjectId', 'Subject.nameSubject', 'Subject.code', 'Subject.section', 'Subject.avatar','Cycle.cycleId','Cycle.cycle', 
                'Career.careerId','Career.nameCareer', 'Subject.state')
                ->get();

            $assignedSubjects = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Career', 'Subject.idCareer', '=', 'Career.careerId')
                ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->get();

            return view('layouts.subject', compact('facultys', 'careers', 'unassignedSubjects', 'assignedSubjects', 'cycles'));
        }

        public function getAssignSubject()
        {
            $facultys = Faculty::all();
            $careers = Career::get();
            $cycles = Cycle::all();
            $unassignedSubjects = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Career', 'Subject.idCareer', '=', 'Career.careerId')
                ->where('Subject.approvedIdc', 'Por aprobar')
                ->where('Subject.idTeacher', null)
                ->select('Subject.subjectId', 'Subject.nameSubject', 'Subject.code', 'Subject.section', 'Subject.avatar','Cycle.cycleId','Cycle.cycle', 
                'Career.careerId','Career.nameCareer', 'Subject.state', 'Subject.approvedIdc')
                ->get();

            $assignedSubjects = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Career', 'Subject.idCareer', '=', 'Career.careerId')
                ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->get();

            return view('layouts.assignSubject', compact('facultys', 'careers', 'unassignedSubjects', 'assignedSubjects', 'cycles'));
        }

        public function getTeachers($career) {
            $teachers = Teacher::join('User', 'Teacher.idUser', '=', 'User.userId')
                ->where('specialty', $career)
                ->get();

            return $teachers;
        }

        public function assignTeacher(Request $request) {
            $subjectId = $request->input('subjectId');

            $subject = Subject::find($subjectId);
            $subject->idTeacher = $request->input('idTeacher');
            $subject->save();

            return redirect()->route('assignSubject');
        }

        public function approvedSubject($subjectId) {
            try{
                $APPROVED_STATE = 'Aprobado';

                $subject = Subject::find($subjectId);
                $subject->approvedIdc = $APPROVED_STATE;
                $subject->save();

                return $subject->approvedIdc;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        public function addSubject(Request $request)
        {
            $TO_BE_APPROVED = 'Por aprobar';
            $avatar = $request->file('Avatar-Materia');
            $avatarName = null;

            if ($avatar) {
                $avatarName = uniqid('avatar_subject_') . '_' . time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('images'), $avatarName);
            }

            // Create new Subject
            $subject = new Subject();
            $subject->code = $request->input('code');
            $subject->nameSubject = $request->input('nameSubject');
            $subject->section = $request->input('section');
            $subject->approvedIdc = $TO_BE_APPROVED;
            if($avatarName !== null){
                $subject->avatar = asset('images/' . $avatarName);
            }
            $subject->state = $request->input('state');
            $subject->idCycle = $request->input('idCycle');
            $subject->idCareer = $request->input('idCareer');

            $subject->save();

            return redirect()->route('subject');
        }

        public function editSubject(Request $request)
        {
            $avatar = $request->file('Avatar-Materia');
            $avatarName = null;

            if ($avatar) {
                $avatarName = uniqid('avatar_subject_') . '_' . time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('images'), $avatarName);
            }

            $subjectId = $request ->input('subjectId');

            $subject = Subject::find($subjectId);
            $subject->code = $request->input('code');
            $subject->nameSubject = $request->input('nameSubject');
            $subject->section = $request->input('section');
            if($avatarName !== null){
                $subject->avatar = asset('images/' . $avatarName);
            }
            $subject->state = $request->input('state');
            $subject->idCycle = $request->input('idCycle');
            $subject->idCareer = $request->input('idCareer');

            $subject->save();

            return redirect()->route('subject');
        }

        public function deleteSubject(Request $request) {
            $subjectId = $request->input('subjectId');
            $subject = Subject::find($subjectId);

            $subject->delete();

            return redirect()->route('subject');
        }
    }
?>