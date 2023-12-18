<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthGoogleLoginController;
use App\Http\Controllers\BibliographicSourceController;
use App\Http\Controllers\DocumentController;
    use App\Http\Controllers\FormPostulationController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\ResearchTopicController;
    use App\Http\Controllers\ResearchTopicInformationController;
    use App\Http\Controllers\StagesProcessController;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\SubjectController;
    use App\Http\Controllers\TableroController;
    use App\Http\Controllers\TeamController;
use App\Http\Controllers\TopicSearchReportController;
use App\Models\BibliographicSource;

    // Private Routes
    Route::middleware(['auth'])->group(function () {    
        Route::get('/tablero', [TableroController::class, 'getResearchTopics']);

        Route::get('/perfil', function(){
            return view('layouts.perfil');
        });

        Route::get('/investigaciones', function(){
            return view('layouts.investigaciones');
        });

        // Route::get('/topicSearchReport', function(){
        //     $role = session('role');
        //     return view('layouts.topicSearchReport', compact('role'));
        // });

        Route::get('/processInfo', function(){
            return view('layouts.processInfo');
        });

        Route::get('/formularioPostulacion', [FormPostulationController::class, 'getCareers']);
        Route::get('/home', [HomeController::class, 'viewCourses']);
        Route::get('/stagesProcess/{researchTopicId}', [StagesProcessController::class, 'getResearchTopic'])->name('stagesProcess');

        Route::get('/searchInformation', function(){
            return view('layouts.searchInformation');
        });
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

    //POST
    Route::post('/addStudent', [FormPostulationController::class, 'addStudent'])->name('student.store');
    Route::post('/addPostulated', [ResearchTopicInformationController::class, 'store'])->name('studentSubject.store');
    Route::post('/addResearchTopic', [ResearchTopicController::class, 'create'])->name('researchTopic.create');
    Route::post('/addTeam', [TeamController::class, 'create'])->name('team.create');
    Route::post('/generate-word', [DocumentController::class, 'generateWord'])->name('generate-word');
    Route::post('/addBibliographicSource', [BibliographicSourceController::class, 'create'])->name('bibliographicSource.create');

    //PUT
    //DELETE
?>