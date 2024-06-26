<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('index');
});

Route::post('/paginas/forms', [FormController::class, 'submitForm'])->name('forms.submit');
// Rota para exibir a página de login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Rota para processar o login
Route::post('/login', [AuthController::class, 'login']);

Route::post('/admin/autenticar', [AuthController::class, 'authenticate'])->name('login.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::POST('/dashboard/backup', [DashboardController::class, 'performBackup'])->name('backup.perform');

Route::get('/gerar-csv', [DashboardController::class, 'gerarCsv'])->name('sugestao.csv');