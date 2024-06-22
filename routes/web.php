<?php

use App\Http\Controllers\DecisionAreaController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\AHPController;
use App\Http\Controllers\NodesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NumericalReportController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Login routes
Auth::routes();
Route::get('/auth/github/redirect', [AuthController::class, 'githubredirect'])->name('githublogin');
Route::get('/auth/github/callback', [AuthController::class, 'githubcallback']);
Route::get('/auth/google/redirect', [AuthController::class, 'googleredirect'])->name('googlelogin');
Route::get('/auth/google/callback', [AuthController::class, 'googlecallback']);

// SCA routes
    // project
        Route::get('/home', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/formCreateProject', [ProjectController::class, 'formCreateProject'])->name('project.formCreateProject');
        Route::post('/project', [ProjectController::class, 'createProject'])->name('project.createProject');
        Route::delete('/project/{id}/remove', [ProjectController::class, 'deleteProject'])->name('project.remove');

    // decision areas
        Route::get('/projects/{project_id}/SHAPE/das', [DecisionAreaController::class, 'formCreateDA'])->name('da.index');
        // Route::get('/projects/{project_id}/das/formCreate', [DecisionAreaController::class, 'formCreateDA'])->name('da.formCreate');
        Route::get('/projects/{project_id}/SHAPE/da{da}/formEdit', [DecisionAreaController::class, 'formEditDA'])->name('da.formEdit');
        Route::post('/projects/{project_id}/dacreate', [DecisionAreaController::class, 'createDA'])->name('da.create');
        Route::put('/projects/{project_id}/da{da}', [DecisionAreaController::class, 'editDA'])->name('da.edit');
        Route::delete('/projects/{project_id}/da{da}/delete', [DecisionAreaController::class, 'deleteDA'])->name('da.delete');
        // Route::get('/projects/{project_id}/das/formPreConnect', [DecisionAreaController::class, 'formPreConnectDA'])->name('da.formPreConnect');
        Route::get('/projects/{project_id}/SHAPE/da{da}/formConnect', [DecisionAreaController::class, 'formConnectDA'])->name('da.formConnect');
        Route::post('projects/das/connect', [DecisionAreaController::class, 'connect'])->name('da.connect');
        Route::get('/projects/{project_id}/SHAPE/das/connections', [DecisionAreaController::class, 'showConnections'])->name('da.viewConnections');

    // options
        Route::get('/options', [OptionsController::class, 'index'])->name('option.index');
        Route::get('/project_{project_id}/SHAPE/da_{decision_area_id}/options/createForm', [OptionsController::class, 'formCreateOption'])->name('option.formCreate');
        Route::get('/project_{project_id}/SHAPE/da_{decision_area_id}/options/editForm', [OptionsController::class, 'formEditOption'])->name('option.formEdit');
        Route::post('/options/create', [OptionsController::class, 'createOption'])->name('option.create');
        Route::put('/options/{option_id}/edit', [OptionsController::class, 'editOption'])->name('option.edit');
        Route::delete('/options/{option_id}/delete', [OptionsController::class, 'deleteOption'])->name('option.delete');
        Route::get('/project_{project_id}/SHAPE/options/matrix', [OptionsController::class, 'formCompatibilityMatrix'])->name('option.formMatrix');
        Route::post('/comparisons/save', [OptionsController::class, 'saveComparisons'])->name('comparisons.save');

// Route::get('/AHP', [AHPController::class, 'AHP']);

// AHP routes
Route::get('/nodes', [NodesController::class, 'index']);
Route::get('/nodes/{id}/criteria', [NodesController::class, 'criteria']);
Route::get('/nodes/{id}/alternatives', [NodesController::class, 'alternatives']);
Route::get('/comparisons/{up}/{id}', [NodesController::class, 'comparisons']);
Route::post('/UpdateScore/{proxy}', [NodesController::class, 'UpdateScore']);
Route::get('/nodes/{id}/report', [ReportController::class, 'report']);
Route::get('/nodes/{id}/NumericalReport', [NumericalReportController::class, 'report']);