<?php
    use App\Http\Controllers\AdministrationController;
    use App\Http\Controllers\FacultyController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthGoogleLoginController;
    use App\Http\Controllers\BibliographicSourceController;
    use App\Http\Controllers\DocumentController;
    use App\Http\Controllers\FormPostulationController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\ProcessInfoController;
    use App\Http\Controllers\ResearchTopicController;
    use App\Http\Controllers\ResearchTopicInformationController;
    use App\Http\Controllers\StagesProcessController;
    use App\Http\Controllers\TableroController;
    use App\Http\Controllers\TeamController;
    use App\Http\Controllers\TopicSearchReportController;
    use App\Http\Controllers\CareerController;
    use App\Http\Controllers\SubjectController;

    // Private Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/tablero', [TableroController::class, 'getResearchTopics']);

        Route::get('/perfil', function(){
            return view('layouts.perfil');
        });

        Route::get('/investigaciones', function(){
            return view('layouts.investigaciones');
        });

        Route::get('/formularioPostulacion', [FormPostulationController::class, 'getCareers']);
        Route::get('/home', [HomeController::class, 'viewCourses']);
        Route::get('/stagesProcess/{researchTopicId}', [StagesProcessController::class, 'getResearchTopic'])->name('stagesProcess');
        Route::get('/processInfo/{researchTopicId}', [ProcessInfoController::class, 'getResearchTopic'])->name('processInfo');

        Route::get('/searchInformation', function(){
            return view('layouts.searchInformation');
        });

        Route::get('/scientificArticle', function(){
            return view('layouts.scientificArticle');
        });

        Route::get('/endProcess', function(){
            return view('layouts.endProcess');
        });

        Route::get('/scientificArticleReport', function(){
            return view('layouts.scientificArticleReport');
        });

        Route::get('/administration', [AdministrationController::class, 'getCareers'])->name('administration');
        Route::get('/career', [CareerController::class, 'getCareers'])->name('career');
        //Route::get('/faculty', [FacultyController::class, 'getCareers'])->name('career');
        Route::get('/subject', [SubjectController::class, 'getSubject'])->name('subject');
    });

    // Public Routes
    Route::get('/', function () {
        return view('welcome');
    });

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
    Route::get('/career', [CareerController::class, 'getCareers'])->name('career');

    //POST
    Route::post('/addStudent', [FormPostulationController::class, 'addStudent'])->name('student.store');
    Route::post('/addPostulated', [ResearchTopicInformationController::class, 'store'])->name('studentSubject.store');
    Route::post('/addResearchTopic', [ResearchTopicController::class, 'create'])->name('researchTopic.create');
    Route::post('/addTeam', [TeamController::class, 'create'])->name('team.create');
    Route::post('/generate-word', [DocumentController::class, 'generateWord'])->name('generate-word');
    Route::post('/addBibliographicSource', [BibliographicSourceController::class, 'create'])->name('bibliographicSource.create');
    Route::post('/addUser', [AdministrationController::class, 'addUser'])->name('user.create');
    Route::post('/addCareer', [CareerController::class, 'addCareer'])->name('career.create');
    Route::post('/editCareer',[CareerController::class, 'editCareer'])->name('editcareer');
    //PUT


    //DELETE
    Route::delete('/deleteUser/{userId}', [AdministrationController::class, 'deleteUser'])->name('deleteUser');
    Route::delete('/deleteCareer/{careerId}', [CareerController::class, 'deleteCareer'])->name('deleteCareer');
?>
