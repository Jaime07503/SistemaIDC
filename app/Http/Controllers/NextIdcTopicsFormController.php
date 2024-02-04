<?php
    namespace App\Http\Controllers;
    use App\Models\Idc;
    use App\Models\NextIdcTopicReport;
    use App\Models\ResearchTopic;
    use App\Models\StudentTeam;
    use App\Models\Team;
    use App\Models\Topic;
    use App\Models\User;
    use App\Notifications\GenerateNTR;
    use Carbon\Carbon;
    use DateTime;
    use Illuminate\Http\Request;
    use PhpOffice\PhpWord\TemplateProcessor as TemplateProcessor;

    class NextIdcTopicsFormController extends Controller
    {
        public function generateWord(Request $request) {
            // Obtenemos los datos del formulario
            $CREATE_STATE = 'En revisión';
            $data = $request->all();
            $idcId = $data['idcId'];
            $idNextIdcTopicReport = $data['idNextIdcTopicReport'];

            // Creamos una variable para la fecha actual
            $fechaActual = new DateTime();
            $fechaCarbon = Carbon::parse($fechaActual);
            $fechaFormateada = $fechaCarbon->locale('es')->isoFormat('D [de] MMMM [de] YYYY');

            $topic = ResearchTopic::join('Team', 'Research_Topic.researchTopicId', '=', 'Team.idResearchTopic')
                ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                ->join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->join('Cycle', 'Subject.idCycle', '=', 'Cycle.cycleId')
                ->join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->where('Idc.idcId', $idcId)
                ->select('Research_Topic.themeName', 'Research_Topic.code', 'Subject.nameSubject', 'User.name', 'Cycle.cycle')
                ->first();

            $fileName = $topic->code.'-NTR.docx';
            $filePath = public_path('documents/' . $fileName);

            $nextIdcTopicReport = NextIdcTopicReport::find($idNextIdcTopicReport);
            $nextIdcTopicReport->code = $fileName;
            $nextIdcTopicReport->creationDate = $fechaCarbon;
            $nextIdcTopicReport->storagePath = 'documents/'.$fileName;
            $nextIdcTopicReport->state = $CREATE_STATE;
            $nextIdcTopicReport->save();

            // Cargamos la plantilla del primer informe
            $templatePath = public_path('documents/Tercer_Informe_Plantilla.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            $students = User::whereHas('student.studentTeam.team.idc', function ($query) use ($idcId) {
                $query->where('idcId', $idcId);
            })->get(['name as student']);

            // Datos de la Portada
            $templateProcessor->setValue('nameTeacher', $topic->name);
            $templateProcessor->setValue('nameSubject', $topic->nameSubject);
            $templateProcessor->setValue('nameResearchTopic', $topic->themeName);
            $templateProcessor->setValue('cycle', $topic->cycle);
            $datosStudents = json_decode($students, true);
            $templateProcessor->cloneBlock('block_students', 0, true, false, $datosStudents);
            $templateProcessor->setValue('date', $fechaFormateada);
            $templateProcessor->setValue('PAGE_BREAK', '</w:t></w:r>'.' <w:r ><w:br w:type="página"/></w:r>' . '<w:r><w:t>');

            // 1. Introducción
            $templateProcessor->setValue('introduction', $data['introduction']);
            $templateProcessor->setValue('continueTopic', $data['continueTopic']);
            $templateProcessor->setValue('proposeTopics', $data['proposeTopics']);
            $aprovedTopics = Topic::join('Report_Topic', 'Topic.topicId', '=', 'Report_Topic.idTopic')
                ->where('idNextIdcTopicReport', $idNextIdcTopicReport)
                ->where('Topic.state', 'Aprobado')
                ->select('Topic.nameTopic as topic')
                ->get();
            
            $datosTopic = json_decode($aprovedTopics, true);
            $templateProcessor->cloneBlock('block_topics', 0, true, false, $datosTopic);

            // 2. Temas de investigación propuestos
            $topics = Topic::join('Report_Topic', 'Topic.topicId', '=', 'Report_Topic.idTopic')
                ->where('idNextIdcTopicReport', $idNextIdcTopicReport)
                ->where('Topic.state', 'Aprobado')
                ->select('Topic.topicId as t', 'Topic.nameTopic', 'Topic.subjectRelevance', 'Topic.globalRelevance', 
                'Topic.globalUpdateImg', 'Topic.updatedInformation', 'Topic.localRelevance', 'Topic.localUpdateImg')
                ->get();

            $datosTopics = json_decode($topics, true);

            // a. Primer tema
            $templateProcessor->setValue('topicOne', $datosTopics[0]['nameTopic']);
            $templateProcessor->setValue('subjectRelevance', $datosTopics[0]['subjectRelevance']);
            $templateProcessor->setImageValue('globalUpdateImg', array('path' => $datosTopics[0]['globalUpdateImg'], 'width' => 575, 'height' => 290, 'ratio' => false));
            $templateProcessor->setImageValue('localUpdateImg', array('path' => $datosTopics[0]['localUpdateImg'], 'width' => 575, 'height' => 290, 'ratio' => false));
            $templateProcessor->setValue('updatedInformation', $datosTopics[0]['updatedInformation']);
            $templateProcessor->setValue('localRelevance', $datosTopics[0]['localRelevance']);
            $templateProcessor->setValue('globalRelevance', $datosTopics[0]['globalRelevance']);

            // b. Segundo tema
            $templateProcessor->setValue('topicTwo', $datosTopics[1]['nameTopic']);
            $templateProcessor->setValue('subjectRelevance2', $datosTopics[1]['subjectRelevance']);
            $templateProcessor->setImageValue('globalUpdateImg2', array('path' => $datosTopics[1]['globalUpdateImg'], 'width' => 575, 'height' => 290, 'ratio' => false));
            $templateProcessor->setImageValue('localUpdateImg2', array('path' => $datosTopics[1]['localUpdateImg'], 'width' => 575, 'height' => 290, 'ratio' => false));
            $templateProcessor->setValue('updatedInformation2', $datosTopics[1]['updatedInformation']);
            $templateProcessor->setValue('localRelevance2', $datosTopics[1]['localRelevance']);
            $templateProcessor->setValue('globalRelevance2', $datosTopics[1]['globalRelevance']);

            // c. Tercer tema
            $templateProcessor->setValue('topicThree', $datosTopics[2]['nameTopic']);
            $templateProcessor->setValue('subjectRelevance3', $datosTopics[2]['subjectRelevance']);
            $templateProcessor->setImageValue('globalUpdateImg3', array('path' => $datosTopics[2]['globalUpdateImg'], 'width' => 575, 'height' => 290, 'ratio' => false));
            $templateProcessor->setImageValue('localUpdateImg3', array('path' => $datosTopics[2]['localUpdateImg'], 'width' => 575, 'height' => 290, 'ratio' => false));
            $templateProcessor->setValue('updatedInformation3', $datosTopics[2]['updatedInformation']);
            $templateProcessor->setValue('localRelevance3', $datosTopics[2]['localRelevance']);
            $templateProcessor->setValue('globalRelevance3', $datosTopics[2]['globalRelevance']);

            // 3. Conclusión
            $templateProcessor->setValue('PAGE_BREAK2', '</w:t></w:r>'.' <w:r ><w:br w:type="página"/></w:r>' . '<w:r><w:t>');
            $templateProcessor->setValue('conclusion', $data['conclusion']);

            $templateProcessor->saveAs($filePath);

            $researchTopicId = Idc::join('Team', 'Idc.idTeam', '=', 'Team.teamId')
                ->where('Idc.idcId', $idcId)
                ->select('Team.idResearchTopic')->first();

            $teams = Team::where('idResearchTopic', $researchTopicId->idResearchTopic)
                ->with('studentTeam.student')
                ->get();

            foreach ($teams as $team) {
                $studentTeamIds = StudentTeam::where('idTeam', $team->teamId)->pluck('idStudent')->toArray();
            
                $students = $team->studentTeam->pluck('student');
            }

            $coordinator = Idc::select('Idc.idUser')
                ->where('Idc.idcId', $idcId)
                ->first();
                
            $user = User::find($coordinator->idUser);
            $user->notify(new GenerateNTR($nextIdcTopicReport, $idcId));

            foreach ($students as $student) {
                $user = User::find($student->idUser);
                $user->notify(new GenerateNTR($nextIdcTopicReport, $idcId));
            }

            return redirect()->route('endProcess', compact('idcId', 'idNextIdcTopicReport'));
        }
    }
?>