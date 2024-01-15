<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Career;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // ... (métodos index, create, store, show, edit, update, destroy)

    public function getSubject()
    {
        $subjects = Subject::whereHas('Faculty', function ($query) {
            $query->where('nameFaculty', 'Ingeniería y Arquitectura');
        })->select('nameSubject')->get();

        $subjects = Subject::get();

        return view('layouts.subject', compact('careers', 'subjects'));
    }

    public function addSubject(Request $request)
    {
        // Create new Subject
        $subject = new Subject();
        $subject->code = $request->input('code');
        // ... (asignar los demás campos)
        $subject->save();

        if ($request->input('role') === 'Docente') {
            // Create new Teacher (si la materia será asignada a un docente)
            // ...
        }

        return redirect()->route('subjects.index');
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
