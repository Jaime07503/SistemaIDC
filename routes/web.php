<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthGoogleLoginController;
    use App\Http\Controllers\ResearchTopic;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\SubjectController;
    use App\Http\Controllers\TeacherController;

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

        Route::get('/home', [TeacherController::class, 'viewCourses']);
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
    Route::get('/temas/{subjectId}', [ResearchTopic::class, 'index'])->name('temas');

    //POST
    Route::post('/storeStudent', [StudentController::class, 'store'])->name('student.store');

    //PUT
    //DELETE
?>