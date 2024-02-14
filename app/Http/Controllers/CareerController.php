<?php
    namespace App\Http\Controllers;
    use App\Models\Career;
    use Illuminate\Http\Request;
    use App\Models\Faculty;

    class CareerController extends Controller
    {
        public function getCareers()
        {
            $facultys = Faculty::select('facultyId', 'nameFaculty')
                ->get();

            $careers = Career::join('Faculty', 'Career.idFaculty', '=', 'Faculty.facultyId')
                ->select('careerId', 'nameCareer', 'idFaculty', 'facultyId', 'nameFaculty')
                ->get();

            if ($careers->isEmpty()) {
                return view('layouts.career', compact('facultys'))->with('noCareers', true);
            }

            return view('layouts.career', compact('careers', 'facultys'));
        }

        public function addCareer(Request $request)
        {
            $career = new Career();
            $career->nameCareer = $request->input('nameCareer');
            $career->idFaculty = $request->input('idFaculty');
            $career->save();

            return redirect()->route('career');
        }

        public function editCareer(Request $request)
        {
            $careerId = $request->input('careerId');
            $career = Career::find($careerId);
            $career->nameCareer = $request->input('nameCareerInput');
            $career->idFaculty = $request->input('idFaculty');
            $career->save();

            return redirect()->route('career');
        }

        public function deleteCareer(Request $request) {
            $careerId = $request->input('careerId');
            $career = Career::find($careerId);
            $career->delete();

            return redirect()->route('career');
        }
    }
?>