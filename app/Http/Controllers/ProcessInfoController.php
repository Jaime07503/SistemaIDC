<?php
    namespace App\Http\Controllers;
    use App\Models\ResearchTopic;
    use App\Models\TrainingDocument;
    use Illuminate\Http\Request;

    class ProcessInfoController extends Controller
    {
        public function getResearchTopic($researchTopicId) 
        {
            $researchTopic = ResearchTopic::join('Subject', 'Research_Topic.idSubject', '=', 'Subject.subjectId')
                ->join('Team', 'Research_Topic.researchTopicId', '=', 'Team.idResearchTopic')
                ->join('Idc', 'Team.teamId', '=', 'Idc.idTeam')
                ->where('Research_Topic.researchTopicId', $researchTopicId)
                ->select('Research_Topic.researchTopicId', 'Research_Topic.themeName', 'Research_Topic.code',
                'Subject.subjectId', 'Team.teamId', 'Idc.idcId')
                ->first();

            $documents = TrainingDocument::join('Idc', 'Training_Document.idIdc', '=', 'Idc.idcId')
                ->where('Idc.idcId', $researchTopic->idcId)
                ->get();

            if($documents->isEmpty()) {
                return view('layouts.processInfo', compact('researchTopic'))->with('noDocuments', true);
            }

            return view('layouts.processInfo', compact('researchTopic', 'documents'));
        }

        public function addDocument($idcId, Request $request) {
            $researchTopicId = $request->input('researchTopicId');
            $ACTIVE_STATE = 'Activo';
    
            $trainingDocument = new TrainingDocument();

            if($request->hasFile('documento')) {
                $file = $request->file('documento');

                $fileName = $file->getClientOriginalName();
                $fileExtension = $file->getClientOriginalExtension();

                $trainingDocument->nameDocument = $fileName;
                $trainingDocument->storagePath = 'documents/'.$fileName;

                if (in_array($fileExtension, ['doc', 'docx'])) {
                    $documentType = 'Word';
                } elseif (in_array($fileExtension, ['pdf'])) {
                    $documentType = 'PDF';
                } elseif (in_array($fileExtension, ['ppt', 'pptx'])) {
                    $documentType = 'PowerPoint';
                }
        
                $trainingDocument->documentType = $documentType;
        
                $file->move(public_path('documents'), $fileName);
            }

            $trainingDocument->state = $ACTIVE_STATE;
            $trainingDocument->idIdc = $idcId;
            $trainingDocument->save();

            return redirect()->route('processInfo', compact('researchTopicId'));
        }

        public function deleteDocument($documentId, Request $request) {
            $researchTopicId = $request->input('researchTopicId');
            $trainingDocument = TrainingDocument::find($documentId);

            $trainingDocument->delete();

            return redirect()->route('processInfo', compact('researchTopicId'));
        }
    }
?>