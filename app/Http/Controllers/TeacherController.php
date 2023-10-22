<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;

class TeacherController extends Controller
{
    public function viewCourses()
    {
        $idTeacher = 1;
        $teacher = Teacher::find($idTeacher);

        if (!$teacher) {
            // Manejo de error si el profesor no se encuentra
        }

        $courses = Subject::with(['teacher.user'])
        ->whereHas('teacher.user', function ($query) use ($idTeacher) {
            $query->where('id', $idTeacher);
        })
        ->get();

        return view('layouts.home', compact('courses'));
    }
}
