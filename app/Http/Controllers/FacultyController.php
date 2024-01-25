<?php
    namespace App\Http\Controllers;
    use App\Models\Faculty;
    use Illuminate\Http\Request;

    class FacultyController extends Controller
    {
        public function getCareers()
        {
            $facultys = Faculty::all();

            return view('layouts.faculty', compact('facultys'));
        }
        
        public function addFaculty(Request $request)
        {
            $faculty = new Faculty();
            $faculty->nameFaculty = $request->input('nameFaculty');

            $faculty->save();

            return redirect()->route('faculty');
        }

        public function editFaculty(Request $request)
        {
            $facultyId = $request ->input('facultyId');

            $faculty = Faculty::find($facultyId);
            $faculty->nameFaculty = $request->input('nameFaculty');

            $faculty->save();

            return redirect()->route('faculty');
        }

        public function deleteFaculty(Request $request) {
            $facultyId = $request->input('facultyId');

            $faculty = Faculty::find($facultyId);

            $faculty->delete();
            
            return redirect()->route('faculty');
        }
    }
?>
