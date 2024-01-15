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
            $careers = Career::whereHas('Faculty', function ($query) {
                $query->where('nameFaculty', 'Ingeniería y Arquitectura');
            })->select('nameCareer')->get();

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
            // Create new Student
            $student = new Student;
            $student->carnet = $request->input('carnet');
            $student->career = $request->input('career');
            $student->state = 'Activo';
            $student->idUser = session('userId');
            $student->save();

            // Create new StudentHistory
            $studentHistory = new StudentHistory;
            $studentHistory->cum = $request->input('cum');
            $studentHistory->enrolledSubject = $request->input('selectedMaterias');
            $studentHistory->subjectApply = $request->input('subjectApply');
            $studentHistory->previousIdc = $request->input('previousIDC');
            $studentHistory->idStudent = $student->studentId;
            $studentHistory->save();

            // Add register in StudentSubject
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
                return redirect('/tablero')->with('success', 'El estudiante ha sido guardado con éxito');
            }
        }
    }
?>