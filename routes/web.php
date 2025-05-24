<?php

use App\Http\Controllers\BacController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\DirecteurController;
use App\Http\Controllers\FilierController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login'])->name("login.post");

Route::get('/directeur', [DirecteurController::class, 'index'])->middleware(['auth','checkType:directeur'])->name('directeur.index');
//Route::get('/directeur', [DirecteurController::class, 'index'])->name('directeur.index');

Route::get('/gestionnaire', [GestionnaireController::class, 'index'])->middleware(['auth','checkType:gestionnaire'])->name('gestionnaire.index');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Reset Password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');

Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 

Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');

Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//Manage Diplomas:
Route::get('/diplomas', [DiplomaController::class, 'index'])->name('diplomas.index');
Route::get('/diplomas/statistics', [DiplomaController::class, 'statistics'])->name('diplomas.statistic');
Route::get('/diplomas/{stagiaireId}', [DiplomaController::class, 'show'])->name('diplomas.show');
Route::post('/diplomas/deliver/{id}', [DiplomaController::class, 'deliver'])->name('diplomas.deliver');
Route::get('/diplomas/{id}/download', [DiplomaController::class, 'download'])->name('diplomas.download');

//Manage Bacs:'bacs.statistic'
Route::get('/bacs', [BacController::class, 'index'])->name('bacs.index');
Route::get('/bacs/statistics', [BacController::class, 'statistics'])->name('bacs.statistic');
Route::get('/bacs/{stagiaireId}', [BacController::class, 'show'])->name('bacs.show');
Route::post('/bacs/deliver/{id}', [BacController::class, 'deliver'])->name('bacs.deliver');
Route::post('/bacs/return/{id}', [BacController::class, 'return'])->name('bacs.return');
Route::get('/bacs/{id}/download', [BacController::class, 'download'])->name('bacs.download');

//profile :
Route::middleware(['auth','checkType:all'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/password/change', [ProfileController::class, 'changePassword'])->name('password.change');
 });

//secteur 
Route::get('/secteur/{id}/filiers', [SecteurController::class, 'selectBranches']);

//filier 
Route::get('/filier/{id}/groups', [FilierController::class, 'selectGroups']);

//Statistic:filtrageBacs
Route::get('/statistic/staigiare/{cef?}', [StatisticController::class, 'searchByCef']);
Route::get('/statistic/bac/staigiare/{cef?}', [StatisticController::class, 'searchByCefBac']);
Route::post('/statistic', [StatisticController::class, 'filtrage']);
Route::get('/statistic', [StatisticController::class, 'filtrage']);
Route::get('/statistic/bac', [StatisticController::class, 'filtrageBacs']);
Route::post('/statistic/bac', [StatisticController::class, 'filtrageBacs']);

