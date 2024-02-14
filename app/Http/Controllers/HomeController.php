<?php
    namespace App\Http\Controllers;
    use App\Models\Career;
    use App\Models\Faculty;
    use Illuminate\Http\Request;

    class HomeController extends Controller
    {
        public function getFacultys(){
            // $facultys = Faculty::with('career.subject.cycle.researchTopics.team.idc')
            //     ->whereHas('career.subject.cycle', function ($query) {
            //         $query->where('state', 'Activo');
            //     })
            //     ->get();

            $facultys = Faculty::join('Career', 'Faculty.facultyId', '=', 'Career.idFaculty')
                ->join('Subject', 'Career.careerId', '=', 'Subject.idCareer')
                ->join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Research_Topic', 'Subject.subjectId', '=', 'Research_Topic.idSubject')
                ->join('Team', 'Research_Topic.researchTopicId', '=', 'Team.idResearchTopic')
                ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                ->select('Faculty.*', 'Career.*', 'Subject.*', 'Cycle.*', 'Research_Topic.*', 'Team.*', 'Idc.*')
                ->get();

            $facultyData = [];

            foreach ($facultys as $faculty) {
                $facultyData[$faculty->facultyId]['nameFaculty'] = $faculty->nameFaculty;
                $facultyData[$faculty->facultyId]['careers'][$faculty->careerId]['nameCareer'] = $faculty->nameCareer;
                $facultyData[$faculty->facultyId]['careers'][$faculty->careerId]['subjects'][$faculty->subjectId]['nameSubject'] = $faculty->nameSubject;
                $facultyData[$faculty->facultyId]['careers'][$faculty->careerId]['subjects'][$faculty->subjectId]['researchTopics'][$faculty->researchTopicId]['themeName'] = $faculty->themeName;
            }
                
            return view('layouts.home', compact('facultyData'));
        }
    }
?>