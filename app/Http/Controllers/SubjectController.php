<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Subject;
use App\Models\Career;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // ... (métodos index, create, store, show, edit, update, destroy)

    public function getSubject()
    {
        $subjects = Subject::join('Career', 'Subject.idCareer', '=',
        'Career.careerId')->join('Cycle','Subject.idCycle', '=', 'Cycle.cycleId')
        ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
        ->join('User', 'Teacher.idUser', '=', 'User.userId')->get();


        $cycles = Cycle::all();

        $careers = Career::all();
        return view('layouts.subject', compact('subjects', 'cycles', 'careers'));
    }

    public function addSubject(Request $request)
    {
        // Create new Subject
        $subject = new Subject();
        $subject->code = $request->input('code');
        $subject->nameSubject = $request->input('nameSubject');
        $subject->section = $request->input('section');
        $subject->approvedIdc = $request->input('approvedIdc');
        $subject->state = $request->input('state');
        $subject->avatar = $request->input('avatar');
        $subject->idCycle = $request->input('idCycle');
        $subject->idCareer = $request->input('idCareer');
        $subject->idTeacher = $request->input('idTeacher');

        // ... (asignar los demás campos)
        $subject->save();

        return redirect()->route('subject');
    }

    public function editSubject(Request $request)
    {
        // Edit subject by subjectId
        $subjectId = $request ->input('subjectId');

        $subject = Subject::find($subjectId);
        $subject->code = $request->input('code');
        $subject->nameSubject = $request->input('name');
        $subject->section = $request->input('section');
        $subject->approvedIdc = $request->input('approvedIdc');
        $subject->state = $request->input('state');
        $subject->avatar = $request->input('avatar');
        $subject->save();

        return redirect()->route('subject');
    }

    public function deleteSubject(Request $request) {
        // Buscar el usuario por ID
        $subjectId = $request->input('subjectId');
        $subject = Subject::find($subjectId);
        // Eliminar la carrera
        $subject->delete();
        return redirect()->route('subject');
    }
}
