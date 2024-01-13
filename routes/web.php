<?php
    use App\Http\Controllers\AdministrationController;
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

    // Private Routes
    Route::middleware(['auth'])->group(function () {    
        Route::get('/perfil/{idUser}', [PerfilController::class, 'getInformation']);
        Route::get('/formularioPostulacion', [FormPostulationController::class, 'getCareers']);
        Route::get('/tablero', [TableroController::class, 'viewCourses']);
        Route::get('/stagesProcess/{researchTopicId}/{teamId}/{idcId}', [StagesProcessController::class, 'getResearchTopic'])->name('stagesProcess');
        Route::get('/processInfo/{researchTopicId}', [ProcessInfoController::class, 'getResearchTopic'])->name('processInfo');
        Route::get('/searchInformation/{idcId}/{idTopicSearchReport}', [SearchInformationController::class, 'getInformation'])->name('searchInformation');
        Route::get('/scientificArticle/{idcId}/{idScientificArticle}', [ScientificArticleController::class, 'getInformation'])->name('scientificArticle');
        Route::get('/endProcess/{idcId}/{idNextIdcTopicReport}', [EndProcessController::class, 'getInformation'])->name('endProcess');
        Route::get('/administration', [AdministrationController::class, 'getCareers'])->name('administration');
    });

    // Public Routes
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/history', function () {
        return view('layouts.history ');
    })->name('history');

    //GET
    Route::get('/login-google', [AuthGoogleLoginController::class, 'redirectToGoogle']);
    Route::get('/google-callback', [AuthGoogleLoginController::class, 'handleGoogleCallback']);
    Route::get('/google-logout', [AuthGoogleLoginController::class, 'logout']);
    Route::get('/getSubjects/{career}', [FormPostulationController::class, 'getSubjects']);
    Route::get('/researchTopics/{subjectId}', [ResearchTopicController::class, 'index'])->name('researchTopics');
    Route::get('/newResearchTopic/{subjectId}', [ResearchTopicController::class, 'getInformation'])->name('newResearchTopic');
    Route::get('/newTeam/{researchTopicId}', [TeamController::class, 'getInformation'])->name('newTeam');
    Route::get('/researchTopicInformation/{researchTopicId}/{subjectId}', [ResearchTopicInformationController::class, 'getResearchTopicInformation'])->name('researchTopicInformation');
    Route::get('/topicSearchReport/{idcId}/{idTopicSearchReport}', [TopicSearchReportController::class, 'getSources'])->name('topicSearchReport');
    Route::get('/scientificArticleReport/{idcId}/{idScientificArticle}', [ScientificArticleReportController::class, 'getSources'])->name('scientificArticleReport');
    Route::get('/nextIdcTopicReport/{idcId}/{idNextIdcTopicReport}', [NextIdcTopicReportController::class, 'getSources'])->name('nextIdcTopicReport');

    //POST
    Route::post('/addStudent', [FormPostulationController::class, 'addStudent'])->name('student.store');
    Route::post('/addPostulated', [ResearchTopicInformationController::class, 'store'])->name('studentSubject.store');
    Route::post('/addResearchTopic', [ResearchTopicController::class, 'create'])->name('researchTopic.create');
    Route::post('/addTeam', [TeamController::class, 'create'])->name('team.create');
    Route::post('/addBibliographicSource', [TopicSearchReportController::class, 'create'])->name('source.create');
    Route::post('/addObjetive', [TopicSearchReportController::class, 'createObjetive'])->name('objetive.create');
    Route::post('/generate-word', [DocumentController::class, 'generateWord'])->name('generate-word');
    Route::post('/generate-scientific-article', [ScientificArticleReportController::class, 'generateWord'])->name('generate-scientific-article');
    Route::post('/addUser', [AdministrationController::class, 'addUser'])->name('user.create');

    //PUT
    
    //DELETE
    Route::delete('/deleteUser/{userId}', [AdministrationController::class, 'deleteUser'])->name('deleteUser');
?>