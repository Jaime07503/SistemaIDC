<?php
    namespace App\Http\Controllers;

    use App\Models\Subject;

    class SubjectController extends Controller
    {
        public function getSubjects($career, $year)
        {
            $subjects = Subject::join('teacher as t', 't.teacherId', '=', 'subject.idTeacher')
            ->join('user as u', 'u.userId', '=', 't.idUser')
            ->where('career', $career)->where('subjectYear', $year)
            ->select('subject.*', 'u.name')
            ->get();
            
            return $subjects;
        }        
    }
?>