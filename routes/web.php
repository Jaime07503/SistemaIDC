<?php
    use App\Http\Controllers\AdministrationController;
    use App\Http\Controllers\FacultyController;
    use App\Notifications\DocEntregado;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthGoogleLoginController;
    use App\Http\Controllers\BibliographicSourceController;
    use App\Http\Controllers\DocumentController;
    use App\Http\Controllers\EndProcessController;
    use App\Http\Controllers\FormPostulationController;
    use App\Http\Controllers\NextIdcTopicReportController;
    use App\Http\Controllers\PerfilController;
    use App\Http\Controllers\ProcessInfoController;
    use App\Http\Controllers\ResearchTopicController;
    use App\Http\Controllers\ResearchTopicInformationController;
    use App\Http\Controllers\ScientificArticleController;
    use App\Http\Controllers\ScientificArticleReportController;
    use App\Http\Controllers\SearchInformationController;
    use App\Http\Controllers\StagesProcessController;
    use App\Http\Controllers\TableroController;
    use App\Http\Controllers\TeamController;
    use App\Http\Controllers\TopicSearchReportController;
    use App\Http\Controllers\CareerController;
    use App\Http\Controllers\HistoryController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\NextIdcTopicsFormController;
    use App\Http\Controllers\SubjectController;

    // Private Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/tablero', [TableroController::class, 'getResearchTopics']);

        Route::get('/perfil', function(){
            return view('layouts.perfil');
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/perfil/{idUser}', [PerfilController::class, 'getInformation'])->name('perfil');
        Route::get('/formularioPostulacion', [FormPostulationController::class, 'getCareers']);
        Route::get('/tablero', [TableroController::class, 'viewCourses']);
        Route::get('/home', [HomeController::class, 'getFacultys'])->name('home');
        Route::get('/history/{idUser}', [HistoryController::class, 'getIdcs'])->name('history');
        Route::get('/stagesProcess/{researchTopicId}/{teamId}/{idcId}', [StagesProcessController::class, 'getResearchTopic'])->name('stagesProcess');
        Route::get('/processInfo/{researchTopicId}', [ProcessInfoController::class, 'getResearchTopic'])->name('processInfo');
        Route::get('/searchInformation/{idcId}/{idTopicSearchReport}', [SearchInformationController::class, 'getInformation'])->name('searchInformation');
        Route::get('/scientificArticle/{idcId}/{idScientificArticleReport}', [ScientificArticleController::class, 'getInformation'])->name('scientificArticle');
        Route::get('/endProcess/{idcId}/{idNextIdcTopicReport}', [EndProcessController::class, 'getInformation'])->name('endProcess');
    });

    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/administration', [AdministrationController::class, 'getCareers'])->name('administration');
        Route::get('/career', [CareerController::class, 'getCareers'])->name('career');
        Route::get('/faculty', [FacultyController::class, 'getCareers'])->name('faculty');
        Route::get('/subject', [SubjectController::class, 'getSubject'])->name('subject');
     });

    // Public Routes
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    //GET
    Route::get('/login-google', [AuthGoogleLoginController::class, 'redirectToGoogle']);
    Route::get('/google-callback', [AuthGoogleLoginController::class, 'handleGoogleCallback']);
    Route::get('/google-logout', [AuthGoogleLoginController::class, 'logout']);
    Route::get('/getSubjects/{career}', [FormPostulationController::class, 'getSubjects']);
    Route::get('/researchTopics/{subjectId}', [ResearchTopicController::class, 'index'])->name('researchTopics');
    Route::get('/newResearchTopic/{subjectId}', [ResearchTopicController::class, 'getInformation'])->name('newResearchTopic');
    Route::get('/newTeam/{researchTopicId}', [TeamController::class, 'getInformation'])->name('newTeam');
    Route::get('/researchTopicInformation/{researchTopicId}/{subjectId}', [ResearchTopicInformationController::class, 'getResearchTopicInformation'])->name('researchTopicInformation');
    Route::get('/topicSearchReport', [TopicSearchReportController::class, 'getSources'])->name('topicSearchReport');
    Route::get('/topicSearchReport/{idcId}/{idTopicSearchReport}', [TopicSearchReportController::class, 'getSources'])->name('topicSearchReport');
    Route::get('/scientificArticleReport/{idcId}/{idScientificArticleReport}', [ScientificArticleReportController::class, 'getSources'])->name('scientificArticleReport');
    Route::get('/nextIdcTopicReport/{idcId}/{idNextIdcTopicReport}', [NextIdcTopicReportController::class, 'getTopics'])->name('nextIdcTopicReport');

    use App\User;
    Route::get('/notificacion', function (){
        $user = User::find(1);
        $user->notify(new DocEntregado);

        return "Notificacion Enviada";
    });
    //POST
    Route::post('/addStudent', [FormPostulationController::class, 'addStudent'])->name('student.store');
    Route::post('/addPostulated', [ResearchTopicInformationController::class, 'store'])->name('studentSubject.store');
    Route::post('/addResearchTopic', [ResearchTopicController::class, 'create'])->name('researchTopic.create');
    Route::post('/addTeam', [TeamController::class, 'create'])->name('team.create');
    Route::post('/addBibliographicSource', [TopicSearchReportController::class, 'create'])->name('source.create');
    Route::post('/addTopic', [NextIdcTopicReportController::class, 'create'])->name('topic.create');
    Route::post('/addObjetive', [TopicSearchReportController::class, 'createObjetive'])->name('objetive.create');
    Route::post('/addDevelopment', [ScientificArticleReportController::class, 'createDevelopment'])->name('development.create');
    Route::post('/addConclusion', [ScientificArticleReportController::class, 'createConclusion'])->name('conclusion.create');
    Route::post('/addReference', [ScientificArticleReportController::class, 'createReference'])->name('reference.create');
    Route::post('/generate-word', [DocumentController::class, 'generateWord'])->name('generate-word');
    Route::post('/generate-scientific-article', [ScientificArticleReportController::class, 'generateWord'])->name('generate-scientific-article');
    Route::post('/generate-nextIdcReport', [NextIdcTopicsFormController::class, 'generateWord'])->name('generate-nextIdcReport');
    Route::post('/addUser', [AdministrationController::class, 'addUser'])->name('user.create');
    Route::post('/updateAvatar/{idUser}', [PerfilController::class, 'updateAvatar'])->name('userAvatar.update');
    Route::post('/addFaculty', [FacultyController::class, 'addFaculty'])->name('faculty.create');
    Route::post('/addSubject', [SubjectController::class, 'addSubject'])->name('subject.create');

    // UPDATE
    Route::get('/source/{idSource}', [TopicSearchReportController::class, 'updateSource'])->name('source.update');
    Route::get('/updateObjetiveG/{idObjetive}', [TopicSearchReportController::class, 'updateObjetiveG'])->name('objetiveG.update');
    Route::get('/updateObjetiveE/{idObjetive}', [TopicSearchReportController::class, 'updateObjetiveE'])->name('objetiveE.update');
    Route::get('/updateDevelopment/{idDevelopment}', [ScientificArticleReportController::class, 'updateDevelopment'])->name('development.update');
    Route::get('/updateConclusion/{idConclusion}', [ScientificArticleReportController::class, 'updateConclusion'])->name('conclusion.update');
    Route::get('/updateReference/{idReference}', [ScientificArticleReportController::class, 'updateReference'])->name('reference.update');
    Route::get('/updateTopic/{idTopic}', [NextIdcTopicReportController::class, 'updateTopic'])->name('topic.update');

    Route::post('/addCareer', [CareerController::class, 'addCareer'])->name('career.create');
    Route::post('/editCareer',[CareerController::class, 'editCareer'])->name('editcareer');
    Route::post('/editUser',[AdministrationController::class, 'editUser'])->name('editUser');
    Route::post('/editSource', [TopicSearchReportController::class, 'editSource'])->name('source.edit');
    Route::post('/editObjetive', [TopicSearchReportController::class, 'editObjetive'])->name('objetive.edit');
    Route::post('/editTopic', [NextIdcTopicReportController::class, 'editTopic'])->name('topic.edit');
    Route::post('/editDevelopment', [ScientificArticleReportController::class, 'editDevelopment'])->name('development.edit');
    Route::post('/editConclusion', [ScientificArticleReportController::class, 'editConclusion'])->name('conclusion.edit');
    Route::post('/editReference', [ScientificArticleReportController::class, 'editReference'])->name('reference.edit');
    Route::post('/editSubject', [SubjectController::class, 'editSubject'])->name('editSubject');
    Route::post('/editFaculty', [FacultyController::class, 'editFaculty'])->name('editFaculty');

    Route::post('/approveTopicSearchReport/{idcId}/{idTopicSearchReport}', [SearchInformationController::class, 'approveTopicSearchReport'])->name('topicSearchReport.approve');
    Route::post('/aprovedCorrectedTopicSearchReport/{idcId}/{idTopicSearchReport}', [SearchInformationController::class, 'approveCorrectedTopicSearchReport'])->name('topicSearchReport.approveCorrected');
    Route::post('/correctTopicSearchReport/{idcId}/{idTopicSearchReport}', [SearchInformationController::class, 'correctTopicSearchReport'])->name('topicSearchReport.correct');
    Route::post('/correctedTopicSearchReport/{idcId}/{idTopicSearchReport}', [SearchInformationController::class, 'correctedTopicSearchReport'])->name('topicSearchReport.corrected');
    Route::post('/declineTopicSearchReport/{idcId}/{idTopicSearchReport}', [SearchInformationController::class, 'declineTopicSearchReport'])->name('topicSearchReport.decline');

    Route::post('/approveScientificArticleReport/{idcId}/{idScientificArticleReport}', [ScientificArticleController::class, 'approveScientificArticleReport'])->name('scientificArticleReport.approve');
    Route::post('/aprovedCorrectedScientificArticleReport/{idcId}/{idScientificArticleReport}', [ScientificArticleController::class, 'approveCorrectedScientificArticleReport'])->name('scientificArticleReport.approveCorrected');
    Route::post('/correctScientificArticleReport/{idcId}/{idScientificArticleReport}', [ScientificArticleController::class, 'correctScientificArticleReport'])->name('scientificArticleReport.correct');
    Route::post('/docImageScientificArticleReport/{idcId}/{idScientificArticleReport}', [ScientificArticleController::class, 'docImageScientificArticleReport'])->name('scientificArticleReport.docImage');
    Route::post('/correctedScientificArticleReport/{idcId}/{idScientificArticleReport}', [ScientificArticleController::class, 'correctedScientificArticleReport'])->name('scientificArticleReport.corrected');
    Route::post('/declineScientificArticleReport/{idcId}/{idScientificArticleReport}', [ScientificArticleController::class, 'declineScientificArticleReport'])->name('scientificArticleReport.decline');

    Route::post('/approveNextIdcTopicReport/{idcId}/{idNextIdcTopicReport}', [EndProcessController::class, 'approveNextIdcTopicReport'])->name('nextIdcTopicReport.approve');
    Route::post('/aprovedCorrectedNextIdcTopicReport/{idcId}/{idNextIdcTopicReport}', [EndProcessController::class, 'approveCorrectedNextIdcTopicReport'])->name('nextIdcTopicReport.approveCorrected');
    Route::post('/correctNextIdcTopicReport/{idcId}/{idNextIdcTopicReport}', [EndProcessController::class, 'correctNextIdcTopicReport'])->name('nextIdcTopicReport.correct');
    Route::post('/correctedNextIdcTopicReport/{idcId}/{idNextIdcTopicReport}', [EndProcessController::class, 'correctedNextIdcTopicReport'])->name('nextIdcTopicReport.corrected');
    Route::post('/declineNextIdcTopicReport/{idcId}/{idNextIdcTopicReport}', [EndProcessController::class, 'declineNextIdcTopicReport'])->name('nextIdcTopicReport.decline');

    //DELETE
    Route::delete('/deleteUser', [AdministrationController::class, 'deleteUser'])->name('deleteUser');
    Route::delete('/deleteCareer', [CareerController::class, 'deleteCareer'])->name('deleteCareer');
    Route::delete('/deleteSource', [TopicSearchReportController::class, 'deleteSource'])->name('source.delete');
    Route::delete('/deleteObjetive', [TopicSearchReportController::class, 'deleteObjetive'])->name('objetive.delete');
    Route::delete('/deleteTopic', [NextIdcTopicReportController::class, 'deleteTopic'])->name('topic.delete');
    Route::delete('/deleteDevelopment', [ScientificArticleReportController::class, 'deleteDevelopment'])->name('development.delete');
    Route::delete('/deleteConclusion', [ScientificArticleReportController::class, 'deleteConclusion'])->name('conclusion.delete');
    Route::delete('/deleteReference', [ScientificArticleReportController::class, 'deleteReference'])->name('reference.delete');
    Route::delete('/deleteSubject', [SubjectController::class, 'deleteSubject'])->name('deleteSubject');
    Route::delete('/deleteFaculty', [FacultyController::class, 'deleteFaculty'])->name('deleteFaculty');
?>
