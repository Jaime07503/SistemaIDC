<?php

    namespace App\Http\Controllers;

    use App\Models\Career;
    use Illuminate\Http\Request;
    use App\Models\Faculty;

    class CareerController extends Controller
    {
        // ... (métodos index, create, store, show, edit, update, destroy)

        public function getCareers()
        {
            $careers = Career::join('Faculty', 'Career.idFaculty', '=',
        'Faculty.facultyId')->get();

            $facultys = Faculty::all();

            return view('layouts.career', compact('careers', 'facultys'));
        }



        public function addCareer(Request $request)
        {
            // Create new Career
            $career = new Career();
            $career->nameCareer = $request->input('nameCareer');
            $career->idFaculty = $request->input('idFaculty');
            $career->save();

            return redirect()->route('career');
        }

        public function editCareer(Request $request)
        {
            //dd($request->all());
            //Edit career by careerId
            $careerId = $request->input('careerId');

            $career = Career::find($careerId);
            $career->nameCareer = $request->input('nameCareerInput');
            $career->idFaculty = $request->input('idFaculty');
            $career->save();

            return redirect()->route('career')->with('success', 'Carrera actualizada');
        }

        public function deleteCareer(Request $request) {
            // Buscar el usuario por ID
            $careerId = $request->input('careerId');
            $career = Career::find($careerId);
            // Eliminar la carrera
            $career->delete();
            return redirect()->route('career');
        }
    }
?>
