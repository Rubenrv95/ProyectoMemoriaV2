<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\AprendizajeController;
use App\Http\Controllers\SaberController;

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
    Route::get('/carreras/{id}/{plan}', [PlanController::class, 'show']);
    Route::post('/carreras/{id}/{plan}/modulo', [ModuloController::class, 'create']);
    Route::post('/carreras/{id}/{plan}/copiar', [PlanController::class, 'copy']);
    Route::get('/planes', [PlanController::class, 'index']);
    
    Route::resource('/usuarios', 'App\Http\Controllers\UserController');

    Route::get('/carreras/{id}/{plan}/perfil_de_egreso', [CompetenciaController::class, 'index']);
    Route::post('/carreras/{id}/{plan}/perfil_de_egreso', [CompetenciaController::class, 'create']);
    Route::put('/carreras/{id}/{plan}/perfil_de_egreso/{competencia}', [CompetenciaController::class, 'update']);
    Route::delete('/carreras/{id}/{plan}/perfil_de_egreso/{competencia}', [CompetenciaController::class, 'destroy']);

    Route::post('/carreras/{id}/{plan}/perfil_de_egreso/aprendizajes', [AprendizajeController::class, 'create']);
    Route::put('/carreras/{id}/{plan}/perfil_de_egreso/aprendizajes/{aprend}', [AprendizajeController::class, 'update']);
    Route::delete('/carreras/{id}/{plan}/perfil_de_egreso/aprendizajes/{aprend}', [AprendizajeController::class, 'destroy']);

    Route::post('/carreras/{id}/{plan}/perfil_de_egreso/saberes', [SaberController::class, 'create']);
    Route::put('/carreras/{id}/{plan}/perfil_de_egreso/saberes/{saber}', [SaberController::class, 'update']);
    Route::delete('/carreras/{id}/{plan}/perfil_de_egreso/saberes/{saber}', [SaberController::class, 'destroy']);

    Auth::routes();
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/login', [LoginController::class, 'login']);





/*

Route::group(['middleware' => ['auth']], function () {
    
}); */ 




