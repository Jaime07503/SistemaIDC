<?php

namespace App\Http\Controllers;

use App\Models\Teacher;

class TeacherController extends Controller
{
    public function viewCourses()
    {
        $idTeacher = 1;
        $teacher = Teacher::find($idTeacher);

        if (!$teacher) {
            // Manejo de error si el profesor no se encuentra
        }

        $courses = $teacher->subject()->get(); 

        return view('layouts.home', compact('courses'));
    }
}
