<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DossierRecusController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PresController;
use App\Http\Controllers\Export\ExporterController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['activated', 'auth', 'not.admin'])->group(function(){
    Route::get('/', [AccueilController::class, 'index'])->name('etudiant');
    Route::get('/preselection', [PresController::class, 'index'])->name('pres');
    Route::get('/inscription', [InscriptionController::class, 'index'])->name('inscription');
    Route::get('/note', [NoteController::class, 'index'])->name('note');
    Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate');
    Route::get('/dossier', [DossierRecusController::class, 'index'])->name('dossier');

//  export Excel
    Route::get('/export', [ExporterController::class, 'index'])->name('exporter');
    Route::post('/export.candidat/{niveau?}', [ExporterController::class, 'exportCandidat'])->name('export-candidat');
    Route::post('/export.etudiant/{niveau?}', [ExporterController::class, 'exportEtudiant'])->name('export-etudiant');
    Route::post('/export.note/{niveau?}', [ExporterController::class, 'exportNote'])->name('export-note');
    Route::post('/export.model/{niveau?}', [ExporterController::class, 'exportModel'])->name('export-model');

//  Export pdf
    Route::post('/export.attestation/{numero?}', [ExporterController::class, 'exportAttestation'])->name('export-attestation');
    Route::post('/export.releve/{lastReleve}', [ExporterController::class, 'exportRelever'])->name('export-relever');
    Route::post('/export.bordereau/{niveau?}', [ExporterController::class, 'exportBordereau'])->name('export-bordereau');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'store'])->name('user.profile.store');
});


Route::prefix("admin")->group(function() {
    Route::get('/login', function () {
        return view('auth.login-admin');
    })->name('login.admin');
    Route::middleware(['activated', 'auth.admin', 'admin'])->group(function(){
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::post('/registerUser', [AdminController::class, 'create'])->name('registerUser');
        Route::post('/admin/{id}', [AdminController::class, 'changeStatus'])->name('changeStatus');
    });
});
