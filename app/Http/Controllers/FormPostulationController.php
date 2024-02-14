<?php
    namespace App\Http\Controllers;
    use App\Models\Career;
    use App\Models\Student;
    use App\Models\StudentHistory;
    use App\Models\StudentSubject;
    use App\Models\Subject;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class FormPostulationController extends Controller
    {
        public function getCareers()
        {
            $careers = Career::select('nameCareer')->get();

            return view('layouts.formularioPostulacion', compact('careers'));
        }

        public function getSubjects($career)
        {
            $subjects = Subject::join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->join('Career', 'Subject.idCareer', '=', 'Career.careerId')
                ->select('Subject.subjectId', 'Subject.nameSubject', 'Subject.section', 'User.name')
                ->where('Subject.approvedIdc', 'Aprobado')
                ->where('Career.nameCareer', $career)
                ->get();
            
            return $subjects;
        }  
        
        public function addStudent(Request $request)
        {            
            $student = new Student;
            $student->carnet = $request->input('carnet');
            $student->career = $request->input('career');
            if($request->input('previousIDC') !== null) {
                $student->idcQuantity = 1;
            } else {
                $student->idcQuantity = 0;
            }
            $student->state = 'Activo';
            $student->idUser = auth()->user()->userId;
            $student->save();

            $studentHistory = new StudentHistory;
            $studentHistory->cum = $request->input('cum');
            $studentHistory->enrolledSubject = $request->input('selectedMaterias');
            $studentHistory->subjectApply = $request->input('subjectApply');
            $studentHistory->previousIdc = $request->input('previousIDC');
            $studentHistory->idStudent = $student->studentId;
            $studentHistory->save();

            $selectedMaterias = $request->input('selectedMaterias');
            $idStudent = $student->studentId;

            if(!empty($selectedMaterias))
            {
                $materiasArray = explode(',', $selectedMaterias);
                $materiasArray = array_slice($materiasArray, 0, 5);

                foreach ($materiasArray as $idSubject) 
                {
                    StudentSubject::create([
                        'applicationCount' => 0,
                        'idStudent' => $idStudent,
                        'idSubject' => $idSubject,
                    ]);
                }
            }

            $user = User::find($student->idUser);
            if($user) 
            {
                $user->name = $request->input('name'); 
                $user->firstLoginPresentCycle = Carbon::now();
                if ($user->firstLogin === null) 
                {
                    $user->firstLogin = Carbon::now();
                }
                $result = $user->save();
            }

            if($result) 
            {
                return redirect('/tablero');
            }
        }
    }
?>