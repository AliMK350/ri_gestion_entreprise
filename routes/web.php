<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Secretaire\DashboardController as SecretaireDashboardController;
use App\Http\Controllers\Employe\DashboardController as EmployeDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/forgot-password', [AuthController::class, 'postForgotPassword']);
Route::get('/reset/{token}', [AuthController::class, 'reset']);
Route::post('/reset/{token}', [AuthController::class, 'postResetPassword']);


// Admin Routes 
Route::group(['middleware' => 'admin'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard']);
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/list', [AdminController::class, 'list']);
            Route::get('/add', [AdminController::class, 'add']);
            Route::post('/add', [AdminController::class, 'insert']);
            Route::get('/edit/{id}', [AdminController::class, 'edit']);
            Route::post('/edit/{id}', [AdminController::class, 'update']);
            Route::get('/delete/{id}', [AdminController::class, 'delete']);
        });
        Route::group(['prefix' => 'class'], function () {
            Route::get('/list', [ClassController::class, 'list']);
            Route::get('/add', [ClassController::class, 'add']);
            Route::post('/add', [ClassController::class, 'insert']);
            Route::get('/edit/{id}', [ClassController::class, 'edit']);
            Route::post('/edit/{id}', [ClassController::class, 'update']);
            Route::get('/delete/{id}', [ClassController::class, 'delete']);
        });
        Route::group(['prefix' => 'subject'], function () {
            Route::get('/list', [SubjectController::class, 'list']);
            Route::get('/add', [SubjectController::class, 'add']);
            Route::post('/add', [SubjectController::class, 'insert']);
            Route::get('/edit/{id}', [SubjectController::class, 'edit']);
            Route::post('/edit/{id}', [SubjectController::class, 'update']);
            Route::get('/delete/{id}', [SubjectController::class, 'delete']);
        });

        // Demandes Administratives
        Route::get('/demandes/list', [\App\Http\Controllers\Admin\DemandeAdministrativeController::class, 'index']);
        Route::post('/demandes/update/{id}', [\App\Http\Controllers\Admin\DemandeAdministrativeController::class, 'update']);

        // Absences
        Route::get('/absences/list', [\App\Http\Controllers\Admin\AbsenceController::class, 'index']);
        Route::get('/absences/delete/{id}', [\App\Http\Controllers\Admin\AbsenceController::class, 'delete']);

        // Notes
        Route::get('/notes/list', [\App\Http\Controllers\Admin\NoteController::class, 'index']);
        Route::get('/notes/delete/{id}', [\App\Http\Controllers\Admin\NoteController::class, 'delete']);

        // Annonces
        Route::group(['prefix' => 'annonces'], function () {
            Route::get('/list', [\App\Http\Controllers\Admin\AnnonceController::class, 'index']);
            Route::get('/add', [\App\Http\Controllers\Admin\AnnonceController::class, 'create']);
            Route::post('/add', [\App\Http\Controllers\Admin\AnnonceController::class, 'store']);
            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AnnonceController::class, 'edit']);
            Route::post('/edit/{id}', [\App\Http\Controllers\Admin\AnnonceController::class, 'update']);
            Route::get('/delete/{id}', [\App\Http\Controllers\Admin\AnnonceController::class, 'delete']);
        });

        // Emploi Du Temps
        Route::group(['prefix' => 'emploi-du-temps'], function () {
            Route::get('/list', [\App\Http\Controllers\Admin\EmploiDuTempsController::class, 'index']);
            Route::get('/add', [\App\Http\Controllers\Admin\EmploiDuTempsController::class, 'create']);
            Route::post('/add', [\App\Http\Controllers\Admin\EmploiDuTempsController::class, 'store']);
            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\EmploiDuTempsController::class, 'edit']);
            Route::post('/edit/{id}', [\App\Http\Controllers\Admin\EmploiDuTempsController::class, 'update']);
            Route::get('/delete/{id}', [\App\Http\Controllers\Admin\EmploiDuTempsController::class, 'delete']);
        });

        // Reservations Salles
        Route::get('/reservations/list', [\App\Http\Controllers\Admin\ReservationSalleController::class, 'index']);
        Route::post('/reservations/update/{id}', [\App\Http\Controllers\Admin\ReservationSalleController::class, 'update']);
        Route::get('/reservations/delete/{id}', [\App\Http\Controllers\Admin\ReservationSalleController::class, 'delete']);

        // Clients
        Route::group(['prefix' => 'clients'], function () {
            Route::get('/list', [\App\Http\Controllers\Admin\ClientController::class, 'list']);
            Route::get('/add', [\App\Http\Controllers\Admin\ClientController::class, 'add']);
            Route::post('/add', [\App\Http\Controllers\Admin\ClientController::class, 'insert']);
            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'edit']);
            Route::post('/edit/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'update']);
            Route::get('/delete/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'delete']);
        });
    });
});

//Secretaire Routes
Route::group(['middleware' => 'secretaire'], function () {
    Route::group(['prefix' => 'secretaire'], function () {
        Route::get('/dashboard', [SecretaireDashboardController::class, 'dashboard']);

        Route::get('/notes', [\App\Http\Controllers\Secretaire\NoteController::class, 'index'])->name('secretaire.notes.index');
        Route::get('/notes/create', [\App\Http\Controllers\Secretaire\NoteController::class, 'create'])->name('secretaire.notes.create');
        Route::post('/notes', [\App\Http\Controllers\Secretaire\NoteController::class, 'store'])->name('secretaire.notes.store');
        Route::get('/notes/edit/{id}', [\App\Http\Controllers\Secretaire\NoteController::class, 'edit'])->name('secretaire.notes.edit');
        Route::post('/notes/edit/{id}', [\App\Http\Controllers\Secretaire\NoteController::class, 'update'])->name('secretaire.notes.update');

        Route::get('/absences', [\App\Http\Controllers\Secretaire\AbsenceController::class, 'index'])->name('secretaire.absences.index');
        Route::get('/absences/create', [\App\Http\Controllers\Secretaire\AbsenceController::class, 'create'])->name('secretaire.absences.create');
        Route::post('/absences', [\App\Http\Controllers\Secretaire\AbsenceController::class, 'store'])->name('secretaire.absences.store');
        Route::get('/absences/edit/{id}', [\App\Http\Controllers\Secretaire\AbsenceController::class, 'edit'])->name('secretaire.absences.edit');
        Route::post('/absences/edit/{id}', [\App\Http\Controllers\Secretaire\AbsenceController::class, 'update'])->name('secretaire.absences.update');

        Route::get('/cahier-texte', [\App\Http\Controllers\Secretaire\CahierTexteController::class, 'index'])->name('secretaire.cahier-texte.index');
        Route::get('/cahier-texte/create', [\App\Http\Controllers\Secretaire\CahierTexteController::class, 'create'])->name('secretaire.cahier-texte.create');
        Route::post('/cahier-texte', [\App\Http\Controllers\Secretaire\CahierTexteController::class, 'store'])->name('secretaire.cahier-texte.store');
        Route::get('/cahier-texte/edit/{id}', [\App\Http\Controllers\Secretaire\CahierTexteController::class, 'edit'])->name('secretaire.cahier-texte.edit');
        Route::post('/cahier-texte/edit/{id}', [\App\Http\Controllers\Secretaire\CahierTexteController::class, 'update'])->name('secretaire.cahier-texte.update');

        Route::get('/supports-cours', [\App\Http\Controllers\Secretaire\SupportCoursController::class, 'index'])->name('secretaire.supports.index');
        Route::get('/supports-cours/create', [\App\Http\Controllers\Secretaire\SupportCoursController::class, 'create'])->name('secretaire.supports.create');
        Route::post('/supports-cours', [\App\Http\Controllers\Secretaire\SupportCoursController::class, 'store'])->name('secretaire.supports.store');

        Route::get('/annonces', [\App\Http\Controllers\Secretaire\AnnonceController::class, 'index'])->name('secretaire.annonces.index');
        Route::get('/annonces/create', [\App\Http\Controllers\Secretaire\AnnonceController::class, 'create'])->name('secretaire.annonces.create');
        Route::post('/annonces', [\App\Http\Controllers\Secretaire\AnnonceController::class, 'store'])->name('secretaire.annonces.store');

        Route::get('/emploi-du-temps', [\App\Http\Controllers\Secretaire\EmploiDuTempsController::class, 'index'])->name('secretaire.emploi-du-temps.index');

        Route::get('/reservations', [\App\Http\Controllers\Secretaire\ReservationSalleController::class, 'index'])->name('secretaire.reservations.index');
        Route::get('/reservations/create', [\App\Http\Controllers\Secretaire\ReservationSalleController::class, 'create'])->name('secretaire.reservations.create');
        Route::post('/reservations', [\App\Http\Controllers\Secretaire\ReservationSalleController::class, 'store'])->name('secretaire.reservations.store');
        Route::get('/reservations/delete/{id}', [\App\Http\Controllers\Secretaire\ReservationSalleController::class, 'delete'])->name('secretaire.reservations.delete');

        Route::get('/demandes', [\App\Http\Controllers\Secretaire\DemandeAdministrativeController::class, 'index'])->name('secretaire.demandes.index');
        Route::get('/demandes/create', [\App\Http\Controllers\Secretaire\DemandeAdministrativeController::class, 'create'])->name('secretaire.demandes.create');
        Route::post('/demandes', [\App\Http\Controllers\Secretaire\DemandeAdministrativeController::class, 'store'])->name('secretaire.demandes.store');
    });
});

// Employe Routes 
Route::group(['middleware' => 'employe'], function () {
    Route::group(['prefix' => 'employe'], function () {
        Route::get('/dashboard', [EmployeDashboardController::class, 'dashboard']);

        // Notes
        Route::get('/notes', [\App\Http\Controllers\Employe\NoteController::class, 'index'])->name('employe.notes.index');

        // Supports de cours
        Route::get('/supports-cours', [\App\Http\Controllers\Employe\SupportCoursController::class, 'index'])->name('employe.supports.index');

        // Classroom annonces / commentaires
        Route::get('/classroom', [\App\Http\Controllers\Employe\ClassroomController::class, 'index'])->name('employe.classroom.index');
        Route::post('/classroom', [\App\Http\Controllers\Employe\ClassroomController::class, 'store'])->name('employe.classroom.store');

        // Emploi du temps
        Route::get('/emploi-du-temps', [\App\Http\Controllers\Employe\EmploiDuTempsController::class, 'index'])->name('employe.emploi-du-temps.index');

        // Absences cumulées
        Route::get('/absences', [\App\Http\Controllers\Employe\AbsenceController::class, 'index'])->name('employe.absences.index');

        // Justificatifs d'absence
        Route::get('/justificatifs', [\App\Http\Controllers\Employe\JustificatifController::class, 'index'])->name('employe.justificatifs.index');
        Route::get('/justificatifs/create', [\App\Http\Controllers\Employe\JustificatifController::class, 'create'])->name('employe.justificatifs.create');
        Route::post('/justificatifs', [\App\Http\Controllers\Employe\JustificatifController::class, 'store'])->name('employe.justificatifs.store');

        // Demandes administratives
        Route::get('/demandes', [\App\Http\Controllers\Employe\DemandeAdministrativeController::class, 'index'])->name('employe.demandes.index');
        Route::get('/demandes/create', [\App\Http\Controllers\Employe\DemandeAdministrativeController::class, 'create'])->name('employe.demandes.create');
        Route::post('/demandes', [\App\Http\Controllers\Employe\DemandeAdministrativeController::class, 'store'])->name('employe.demandes.store');

        // PDF export for Emploi du Temps
        Route::get('/emploi-du-temps/pdf', [\App\Http\Controllers\Employe\EmploiDuTempsController::class, 'pdf'])->name('employe.emploi-du-temps.pdf');
        // Show detailed Demande
        Route::get('/demandes/{id}', [\App\Http\Controllers\Employe\DemandeAdministrativeController::class, 'show'])->name('employe.demandes.show');
    });
});

// Parent Route 
Route::group(['middleware' => 'gerant'], function () {
    Route::group(['prefix' => 'gerant'], function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    });
});
