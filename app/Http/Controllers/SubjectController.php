<?php
    namespace App\Http\Controllers;
    use App\Models\Subject;
    use App\Models\Career;
    use App\Models\Cycle;
    use App\Models\Teacher;
    use Illuminate\Http\Request;

    class SubjectController extends Controller
    {
        public function getSubjects()
        {
            $careers = Career::select('careerId', 'nameCareer')
                ->get();

            $cycles = Cycle::select('cycleId', 'cycle')
                ->get();

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
                ->select('Subject.subjectId', 'Subject.nameSubject', 'Subject.code', 'Subject.section', 'Subject.avatar','Cycle.cycleId', 'Cycle.cycle', 
                'Career.careerId','Career.nameCareer', 'Subject.state', 'Subject.approvedIdc', 'User.name')
                ->get();

            if ($unassignedSubjects->isEmpty() && $assignedSubjects->isEmpty()) {
                return view('layouts.subject', compact('careers', 'cycles'))->with('noContent', true);
            }

            if ($unassignedSubjects->isEmpty()) {
                return view('layouts.subject', compact('careers', 'assignedSubjects', 'cycles'))->with('noUnassignedSubjects', true);
            }

            if ($assignedSubjects->isEmpty()) {
                return view('layouts.subject', compact('careers', 'unassignedSubjects', 'cycles'))->with('noAssignedSubjects', true);
            }

            return view('layouts.subject', compact('careers', 'unassignedSubjects', 'assignedSubjects', 'cycles'));
        }

        public function getAssignSubject()
        {
            $careers = Career::select('nameCareer')
                ->get();

            $cycle = Cycle::where('state', 'Activo')->first();

            $unassignedSubjects = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Career', 'Subject.idCareer', '=', 'Career.careerId')
                ->where('Subject.idCycle', $cycle->cycleId)
                ->where('Subject.approvedIdc', 'Por aprobar')
                ->where('Subject.idTeacher', null)
                ->where('Subject.state', 'Activo')
                ->select('Subject.subjectId', 'Subject.nameSubject', 'Subject.code', 'Subject.section', 'Subject.avatar','Cycle.cycleId','Cycle.cycle', 
                'Career.careerId','Career.nameCareer', 'Subject.state', 'Subject.approvedIdc')
                ->get();

            $assignedSubjects = Subject::join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Career', 'Subject.idCareer', '=', 'Career.careerId')
                ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->select('Subject.subjectId', 'Subject.nameSubject', 'Subject.code', 'Subject.section', 'Subject.avatar','Cycle.cycleId', 'Cycle.cycle', 
                'Career.careerId','Career.nameCareer', 'Subject.state', 'Subject.approvedIdc', 'User.name')
                ->get();

            if ($unassignedSubjects->isEmpty() && $assignedSubjects->isEmpty()) {
                return view('layouts.assignSubject', compact('careers'))->with('noContent', true);
            }

            if ($unassignedSubjects->isEmpty()) {
                return view('layouts.assignSubject', compact('careers', 'assignedSubjects'))->with('noUnassignedSubjects', true);
            }

            if ($assignedSubjects->isEmpty()) {
                return view('layouts.assignSubject', compact('careers', 'unassignedSubjects'))->with('noAssignedSubjects', true);
            }
    
            return view('layouts.assignSubject', compact('careers', 'unassignedSubjects', 'assignedSubjects'));
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

            $existingSubject = Subject::where('nameSubject', $request->input('nameSubject'))
                ->where('section', $request->input('section'))
                ->where('idCycle', $request->input('idCycle'))
                ->first();

            $cycle = Cycle::find($request->input('idCycle'));

            if ($existingSubject) {
                return redirect()->back();
            }

            $themeName = $request->input('nameSubject');
    
            $themeWords = explode(' ', $themeName);
            $themeInitials = '';
            foreach ($themeWords as $word) {
                $themeInitials .= strtoupper(substr($word, 0, 1));
            }
            $themeInitials = substr($themeInitials, 0, 3);

            $words = explode(' ', $request->input('nameSubject'));
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }

            if (preg_match('/\bI\b/', $cycle->cycle)) {
                $cycleType = 'I';
            } elseif (preg_match('/\bII\b/', $cycle->cycle)) {
                $cycleType = 'II';
            }

            $year = substr($cycle->cycle, -4);

            $code = $initials . '-' . $request->input('section') . '-' . $cycleType . substr($year, -2). '-' . $themeInitials;


            $subject = new Subject();
            $subject->code = $code;
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