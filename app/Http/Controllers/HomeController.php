<?php
    namespace App\Http\Controllers;
    use App\Models\Career;
    use App\Models\Faculty;
    use Illuminate\Http\Request;

    class HomeController extends Controller
    {
        public function getFacultys(){
            $facultys = Faculty::with('career.subject.cycle.researchTopics.team.idc')
                ->whereHas('career.subject.cycle', function ($query) {
                    $query->where('state', 'Activo');
                })
                ->get();
                
            return view('layouts.home', compact('facultys'));
        }
    }
?>