<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthGoogleLoginController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\ResearchTopicController;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\SubjectController;

    // Private Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/tablero', function(){
            return view('layouts.tablero');
        });

        Route::get('/perfil', function(){
            return view('layouts.perfil');
        });

        Route::get('/formularioPostulacion', function(){
            return view('layouts.formularioPostulacion');
        });

        Route::get('/investigaciones', function(){
            return view('layouts.investigaciones');
        });

        Route::get('/home', [HomeController::class, 'viewCourses']);
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
    Route::get('/getSubjects/{career}/{year}', [SubjectController::class, 'getSubjects']);
    Route::get('/temas/{subjectId}', [ResearchTopicController::class, 'index'])->name('temas');
    Route::get('/temasInformation/{researchTopicId}', [ResearchTopicController::class, 'getResearchTopicInformation'])->name('temasInformation');

    //POST
    Route::post('/storeStudent', [StudentController::class, 'store'])->name('student.store');
    Route::post('/generate-word', [DocumentController::class, 'generateWord']);

    //PUT
    //DELETE
?>
