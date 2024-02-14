<?php
    namespace App\Http\Controllers;
    use App\Models\Subject;
    use App\Models\Topic;

    class TopicController extends Controller
    {
        public function getTopics($subjectId) {
            $subject = Subject::join('Teacher', 'Subject.idTeacher', '=', 'Teacher.teacherId')
                ->join('User', 'Teacher.idUser', '=', 'User.userId')
                ->find($subjectId);

            $researchTopics = Topic::where('subject', $subject->nameSubject)
                ->where('state', 'Seleccionado')
                ->get();

            return view('layouts.topicsApproveIdc', compact('researchTopics', 'subject'));
        }

        public function approvedTopicIdc($topicId) {
            $APPROVE_STATE = 'Aprobado';
            $researchTopic = Topic::find($topicId);
            $researchTopic->state = $APPROVE_STATE;
            $researchTopic->save();

            return redirect()->route('approveResearchTopics');
        }
    }
?>