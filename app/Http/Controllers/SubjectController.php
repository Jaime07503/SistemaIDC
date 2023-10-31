<?php
    namespace App\Http\Controllers;

    use App\Models\Subject;

    class SubjectController extends Controller
    {
        public function getSubjects($career, $year)
        {
            $subjects = Subject::where('career', $career)->where('subjectYear', $year)->get();
            return $subjects;
        }
    }
?>