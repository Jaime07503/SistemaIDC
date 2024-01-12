<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    // ... (métodos index, create, store, show, edit, update, destroy)

    public function getCareers()
    {
        $careers = Career::all();

        return view('careers.index', compact('careers'));
    }

    public function addCareer(Request $request)
    {
        // Create new Career
        $career = new Career();
        $career->nameCareer = $request->input('nameCareer');
        $career->nameFaculty = $request->input('nameFaculty');
        $career->save();

        return redirect()->route('careers.index');
    }

    public function editCareer(Request $request)
    {
        // Edit career by careerId
        $careerId = $request ->input('careerId');

        $career = Career::find($careerId);

        if (!$career) {
            return response()->json(['message' => 'Carrera no encontrada'], 404);
        }

        if ($request->isMethod('post')) {
            $career->nameCareer = $request->input('nameCareer');
            $career->nameFaculty = $request->input('nameFaculty');

            $career->save();

            return redirect()->route('careers.index')->with('success', 'Carrera actualizada');
        }
    }
}
