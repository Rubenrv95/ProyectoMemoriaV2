<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\AprendizajeController;
use App\Http\Controllers\Saber_conocerController;
use App\Http\Controllers\Saber_hacerController;
use App\Http\Controllers\Saber_serController;

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
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/inicio', function() {
    
});

    Route::post('crearCarrera', [CarreraController::class, 'create']);
    Route::resource('/carreras', 'App\Http\Controllers\CarreraController');
    Route::get('/carreras/{id}', [CarreraController::class, 'show']);

    Route::post('changepassword', [ChangePasswordController::class, 'store'])->name('change.password');

    Route::post('/carreras/{id}/crearPlan', [PlanController::class, 'create']);
    Route::delete('/carreras/{id}/{plan}', [PlanController::class, 'destroy']);
    Route::put('/carreras/{id}/{plan}', [PlanController::class, 'update']);
    Route::get('/carreras/{id}/{plan}/malla', [PlanController::class, 'show']);
    Route::get('/carreras/{id}/{plan}/descargar_reporte', [PlanController::class, 'createPDF']);
    Route::post('/carreras/{id}/{plan}/modulo', [ModuloController::class, 'create']);
    Route::post('/carreras/{id}/{plan}/copiar', [PlanController::class, 'copy']);
    Route::get('/planes', [PlanController::class, 'index']);


    Route::resource('/usuarios', 'App\Http\Controllers\UserController');

    Route::get('/carreras/{id}/{plan}/competencias', [CompetenciaController::class, 'index']);
    Route::get('/carreras/{id}/{plan}/tempo_competencias', [CompetenciaController::class, 'show']);
    Route::post('/carreras/{id}/{plan}/competencias', [CompetenciaController::class, 'create']);
    Route::put('/carreras/{id}/{plan}/competencias/{competencia}', [CompetenciaController::class, 'update']);
    Route::delete('/carreras/{id}/{plan}/competencias/{competencia}', [CompetenciaController::class, 'destroy']);

    Route::get('/carreras/{id}/{plan}/aprendizajes', [AprendizajeController::class, 'index']);
    Route::get('/carreras/{id}/{plan}/tempo_aprendizajes', [AprendizajeController::class, 'show']);
    Route::post('/carreras/{id}/{plan}/aprendizajes', [AprendizajeController::class, 'create']);
    Route::put('/carreras/{id}/{plan}/aprendizajes/{aprend}', [AprendizajeController::class, 'update']);
    Route::delete('/carreras/{id}/{plan}/aprendizajes/{aprend}', [AprendizajeController::class, 'destroy']);

    Route::get('/carreras/{id}/{plan}/saber_conocer', [Saber_conocerController::class, 'index']);
    Route::post('/carreras/{id}/{plan}/saber_conocer', [Saber_conocerController::class, 'create']);
    Route::put('/carreras/{id}/{plan}/saber_conocer/{saber}', [Saber_conocerController::class, 'update']);
    Route::delete('/carreras/{id}/{plan}/saber_conocer/{saber}', [Saber_conocerController::class, 'destroy']);

    Route::get('/carreras/{id}/{plan}/saber_hacer', [Saber_hacerController::class, 'index']);
    Route::post('/carreras/{id}/{plan}/saber_hacer', [Saber_hacerController::class, 'create']);
    Route::put('/carreras/{id}/{plan}/saber_hacer/{saber}', [Saber_hacerController::class, 'update']);
    Route::delete('/carreras/{id}/{plan}/saber_hacer/{saber}', [Saber_hacerController::class, 'destroy']);

    Route::get('/carreras/{id}/{plan}/saber_ser', [Saber_serController::class, 'index']);
    Route::post('/carreras/{id}/{plan}/saber_ser', [Saber_serController::class, 'create']);
    Route::put('/carreras/{id}/{plan}/saber_ser/{saber}', [Saber_serController::class, 'update']);
    Route::delete('/carreras/{id}/{plan}/saber_ser/{saber}', [Saber_serController::class, 'destroy']);

    Auth::routes();
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/login', [LoginController::class, 'login']);





/*

Route::group(['middleware' => ['auth']], function () {
    
}); */ 




