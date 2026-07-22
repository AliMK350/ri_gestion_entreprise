<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AbsenceController as AdminAbsenceController;
use App\Http\Controllers\Admin\AttestationController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\JourFerieController;
use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Admin\PersonnelController as AdminPersonnelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employe\AbsenceController as EmployeAbsenceController;
use App\Http\Controllers\Employe\DashboardController as EmployeDashboardController;
use App\Http\Controllers\Employe\LeaveController as EmployeLeaveController;
use App\Http\Controllers\Employe\PersonnelController as EmployePersonnelController;
use App\Http\Controllers\Employe\ProfileController;
use App\Http\Controllers\Gerant\ClientController as GerantClientController;
use App\Http\Controllers\Gerant\DashboardController as GerantDashboardController;
use App\Http\Controllers\Gerant\DevisController as GerantDevisController;
use App\Http\Controllers\Gerant\FactureController as GerantFactureController;
use App\Http\Controllers\Secretaire\ClientController as SecretaireClientController;
use App\Http\Controllers\Secretaire\DashboardController as SecretaireDashboardController;
use App\Http\Controllers\Secretaire\DevisController;
use App\Http\Controllers\Secretaire\FactureController;
use App\Http\Controllers\Secretaire\RecuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/forgot-password', [AuthController::class, 'postForgotPassword']);
Route::get('/reset/{token}', [AuthController::class, 'reset']);
Route::post('/reset/{token}', [AuthController::class, 'postResetPassword']);

// Admin
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/list', [AdminController::class, 'list']);
        Route::get('/add', [AdminController::class, 'add']);
        Route::post('/add', [AdminController::class, 'insert']);
        Route::get('/edit/{id}', [AdminController::class, 'edit']);
        Route::post('/edit/{id}', [AdminController::class, 'update']);
        Route::get('/delete/{id}', [AdminController::class, 'delete']);
    });

    Route::group(['prefix' => 'employees'], function () {
        Route::get('/list', [EmployeeController::class, 'list']);
        Route::get('/add', [EmployeeController::class, 'add']);
        Route::post('/add', [EmployeeController::class, 'insert']);
        Route::get('/edit/{id}', [EmployeeController::class, 'edit']);
        Route::post('/edit/{id}', [EmployeeController::class, 'update']);
        Route::get('/delete/{id}', [EmployeeController::class, 'delete']);
        Route::get('/show/{id}', [EmployeeController::class, 'show']);
    });

    Route::group(['prefix' => 'interns'], function () {
        Route::get('/list', [InternController::class, 'list']);
        Route::get('/add', [InternController::class, 'add']);
        Route::post('/add', [InternController::class, 'insert']);
        Route::get('/edit/{id}', [InternController::class, 'edit']);
        Route::post('/edit/{id}', [InternController::class, 'update']);
        Route::get('/delete/{id}', [InternController::class, 'delete']);
        Route::get('/download-cv/{id}', [InternController::class, 'downloadCv']);
    });

    Route::group(['prefix' => 'attestations'], function () {
        Route::get('/stage/{id}', [AttestationController::class, 'stage']);
        Route::get('/travail/{id}', [AttestationController::class, 'travail']);
    });

    Route::group(['prefix' => 'jours-feries'], function () {
        Route::get('/list', [JourFerieController::class, 'list']);
        Route::get('/add', [JourFerieController::class, 'add']);
        Route::post('/add', [JourFerieController::class, 'insert']);
        Route::get('/edit/{id}', [JourFerieController::class, 'edit']);
        Route::post('/edit/{id}', [JourFerieController::class, 'update']);
        Route::get('/delete/{id}', [JourFerieController::class, 'delete']);
    });

    Route::group(['prefix' => 'absences'], function () {
        Route::get('/list', [AdminAbsenceController::class, 'list']);
        Route::get('/add', [AdminAbsenceController::class, 'add']);
        Route::post('/add', [AdminAbsenceController::class, 'insert']);
        Route::get('/delete/{id}', [AdminAbsenceController::class, 'delete']);
    });

    Route::group(['prefix' => 'leaves'], function () {
        Route::get('/list', [AdminLeaveController::class, 'list']);
        Route::post('/status/{id}', [AdminLeaveController::class, 'updateStatus']);
        Route::get('/delete/{id}', [AdminLeaveController::class, 'delete']);
    });

    Route::get('/personnel', [AdminPersonnelController::class, 'index']);

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/list', [AdminClientController::class, 'list']);
        Route::get('/add', [AdminClientController::class, 'add']);
        Route::post('/add', [AdminClientController::class, 'insert']);
        Route::get('/edit/{id}', [AdminClientController::class, 'edit']);
        Route::post('/edit/{id}', [AdminClientController::class, 'update']);
        Route::get('/delete/{id}', [AdminClientController::class, 'delete']);
    });
});

// Secrétaire
Route::group(['middleware' => 'secretaire', 'prefix' => 'secretaire'], function () {
    Route::get('/dashboard', [SecretaireDashboardController::class, 'dashboard']);

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/list', [SecretaireClientController::class, 'list']);
        Route::get('/add', [SecretaireClientController::class, 'add']);
        Route::post('/add', [SecretaireClientController::class, 'insert']);
        Route::get('/edit/{id}', [SecretaireClientController::class, 'edit']);
        Route::post('/edit/{id}', [SecretaireClientController::class, 'update']);
        Route::get('/show/{id}', [SecretaireClientController::class, 'show']);
    });

    Route::group(['prefix' => 'devis'], function () {
        Route::get('/list', [DevisController::class, 'list']);
        Route::get('/add', [DevisController::class, 'add']);
        Route::post('/add', [DevisController::class, 'insert']);
        Route::get('/edit/{id}', [DevisController::class, 'edit']);
        Route::post('/edit/{id}', [DevisController::class, 'update']);
        Route::get('/delete/{id}', [DevisController::class, 'delete']);
        Route::get('/pdf/{id}', [DevisController::class, 'pdf']);
    });

    Route::group(['prefix' => 'factures'], function () {
        Route::get('/list', [FactureController::class, 'list']);
        Route::get('/add', [FactureController::class, 'add']);
        Route::post('/add', [FactureController::class, 'insert']);
        Route::get('/edit/{id}', [FactureController::class, 'edit']);
        Route::post('/edit/{id}', [FactureController::class, 'update']);
        Route::get('/delete/{id}', [FactureController::class, 'delete']);
        Route::get('/pdf/{id}', [FactureController::class, 'pdf']);
    });

    Route::group(['prefix' => 'recus'], function () {
        Route::get('/list', [RecuController::class, 'list']);
        Route::get('/add', [RecuController::class, 'add']);
        Route::post('/add', [RecuController::class, 'insert']);
        Route::get('/delete/{id}', [RecuController::class, 'delete']);
        Route::get('/pdf/{id}', [RecuController::class, 'pdf']);
    });

    Route::get('/absences', [EmployeAbsenceController::class, 'index'])->name('secretaire.absences.index');
    Route::get('/absences/create', [EmployeAbsenceController::class, 'create'])->name('secretaire.absences.create');
    Route::post('/absences', [EmployeAbsenceController::class, 'store'])->name('secretaire.absences.store');
    Route::get('/absences/{id}/edit', [EmployeAbsenceController::class, 'edit'])->name('secretaire.absences.edit');
    Route::post('/absences/{id}/edit', [EmployeAbsenceController::class, 'update'])->name('secretaire.absences.update');
    Route::get('/leaves/create', [EmployeLeaveController::class, 'create'])->name('secretaire.leaves.create');
    Route::post('/leaves', [EmployeLeaveController::class, 'store'])->name('secretaire.leaves.store');
});

// Employé
Route::group(['middleware' => 'employe', 'prefix' => 'employe'], function () {
    Route::get('/dashboard', [EmployeDashboardController::class, 'dashboard']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/personnel', [EmployePersonnelController::class, 'index']);

    Route::get('/absences', [EmployeAbsenceController::class, 'index'])->name('employe.absences.index');
    Route::get('/absences/create', [EmployeAbsenceController::class, 'create'])->name('employe.absences.create');
    Route::post('/absences', [EmployeAbsenceController::class, 'store'])->name('employe.absences.store');
    Route::get('/absences/{id}/edit', [EmployeAbsenceController::class, 'edit'])->name('employe.absences.edit');
    Route::post('/absences/{id}/edit', [EmployeAbsenceController::class, 'update'])->name('employe.absences.update');

    Route::get('/leaves/create', [EmployeLeaveController::class, 'create'])->name('employe.leaves.create');
    Route::post('/leaves', [EmployeLeaveController::class, 'store'])->name('employe.leaves.store');
});

// Gérant
Route::group(['middleware' => 'gerant', 'prefix' => 'gerant'], function () {
    Route::get('/dashboard', [GerantDashboardController::class, 'dashboard']);

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/list', [GerantClientController::class, 'list']);
        Route::get('/add', [GerantClientController::class, 'add']);
        Route::post('/add', [GerantClientController::class, 'insert']);
        Route::get('/edit/{id}', [GerantClientController::class, 'edit']);
        Route::post('/edit/{id}', [GerantClientController::class, 'update']);
        Route::get('/delete/{id}', [GerantClientController::class, 'delete']);
        Route::get('/history/{id}', [GerantClientController::class, 'history']);
    });

    Route::group(['prefix' => 'devis'], function () {
        Route::get('/list', [GerantDevisController::class, 'list']);
        Route::post('/validate/{id}', [GerantDevisController::class, 'validateQuote']);
        Route::get('/delete/{id}', [GerantDevisController::class, 'delete']);
    });

    Route::group(['prefix' => 'factures'], function () {
        Route::get('/list', [GerantFactureController::class, 'list']);
        Route::post('/validate/{id}', [GerantFactureController::class, 'validateInvoice']);
        Route::get('/delete/{id}', [GerantFactureController::class, 'delete']);
    });

    Route::get('/absences', [EmployeAbsenceController::class, 'index'])->name('gerant.absences.index');
    Route::get('/absences/create', [EmployeAbsenceController::class, 'create'])->name('gerant.absences.create');
    Route::post('/absences', [EmployeAbsenceController::class, 'store'])->name('gerant.absences.store');
    Route::get('/absences/{id}/edit', [EmployeAbsenceController::class, 'edit'])->name('gerant.absences.edit');
    Route::post('/absences/{id}/edit', [EmployeAbsenceController::class, 'update'])->name('gerant.absences.update');
    Route::get('/leaves/create', [EmployeLeaveController::class, 'create'])->name('gerant.leaves.create');
    Route::post('/leaves', [EmployeLeaveController::class, 'store'])->name('gerant.leaves.store');
});
