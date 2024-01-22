<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function getFacultys()
    {
        $faculty = Faculty::all();

        return view('layouts.faculty', compact('faculty'));
    }

    public function addFaculty(Request $request)
    {
        // Create new Faculty
        $faculty = new Faculty();
        $faculty->idFaculty = $request->input('idFaculty');
        $faculty->nameFaculty = $request->input('nameFaculty');


        // ... (asignar los demás campos)
        $faculty->save();

        return redirect()->route('faculty');
    }

    public function editFaculty(Request $request)
    {
        // Edit faculty by facultyId
        $facultyId = $request ->input('facultyId');

        $faculty = Faculty::find($facultyId);
        $faculty->nameFaculty= $request->input('nameFaculty');

        return redirect()->route('faculty');
    }

    public function deleteFaculty(Request $request) {
        // Buscar el usuario por ID
        $facultyId = $request->input('facultyId');
        $faculty = Faculty::find($facultyId);
        // Eliminar la carrera
        $faculty->delete();
        return redirect()->route('faculty');
    }
}
