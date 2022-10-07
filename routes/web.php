<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\DimensionController;
use App\Http\Controllers\AprendizajeController;
use App\Http\Controllers\SaberController;
use App\Http\Controllers\ModuloController;

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

    if(Auth::check()) {
        return redirect('/home');
    }
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/inicio', function() {
    
});

    Route::post('crearCarrera', [CarreraController::class, 'create']);
    Route::resource('/carreras', 'App\Http\Controllers\CarreraController');

    Route::post('changepassword', [ChangePasswordController::class, 'store'])->name('change.password');
    Route::get('/carreras/{id}/descargar_reporte', [CarreraController::class, 'createPDF']);
    Route::post('/carreras/{id}/{}/modulo', [ModuloController::class, 'create']);
    Route::post('/carreras/{id}/copiar', [CarreraController::class, 'copy']);


    Route::resource('/usuarios', 'App\Http\Controllers\UserController');

    Route::get('/carreras/{id}/competencias', [CompetenciaController::class, 'index']);
    Route::get('/carreras/{id}/tempo_competencias', [CompetenciaController::class, 'show']);
    Route::post('/carreras/{id}/competencias', [CompetenciaController::class, 'create']);
    Route::put('/carreras/{id}/competencias/{competencia}', [CompetenciaController::class, 'update']);
    Route::delete('/carreras/{id}/competencias/{competencia}', [CompetenciaController::class, 'destroy']);

    Route::get('/carreras/{id}/dimensiones', [DimensionController::class, 'index']);
    Route::post('/carreras/{id}/dimensiones', [DimensionController::class, 'create']);
    Route::put('/carreras/{id}/dimensiones/{dimension}', [DimensionController::class, 'update']);
    Route::delete('/carreras/{id}/dimensiones/{dimension}', [DimensionController::class, 'destroy']);

    Route::get('/carreras/{id}/aprendizajes', [AprendizajeController::class, 'index']);
    Route::get('/carreras/{id}/aprendizajes/{comp}', [AprendizajeController::class, 'show']);
    Route::post('/carreras/{id}/aprendizajes', [AprendizajeController::class, 'create']);
    Route::put('/carreras/{id}/aprendizajes/{aprend}', [AprendizajeController::class, 'update']);
    Route::delete('/carreras/{id}/aprendizajes/{aprend}', [AprendizajeController::class, 'destroy']);
    Route::get('/carreras/{id}/tempo_aprendizajes', [AprendizajeController::class, 'show_Tempo']);

    Route::get('/carreras/{id}/saberes', [SaberController::class, 'index']);
    Route::post('/carreras/{id}/saberes', [SaberController::class, 'create']);
    Route::put('/carreras/{id}/saberes/{saber}', [SaberController::class, 'update']);
    Route::delete('/carreras/{id}/saberes/{saber}', [SaberController::class, 'destroy']);
    Route::get('/carreras/{id}/ver_saberes/', [SaberController::class, 'show']);

    Route::get('/carreras/{id}/modulos', [ModuloController::class, 'index']);
    Route::post('/carreras/{id}/modulos', [ModuloController::class, 'create']);
    Route::put('/carreras/{id}/modulos/{modulo}', [ModuloController::class, 'update']);
    Route::delete('/carreras/{id}/modulos/{modulo}', [ModuloController::class, 'destroy']);



    Auth::routes();
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/login', [LoginController::class, 'login']);





/*

Route::group(['middleware' => ['auth']], function () {
    
}); */ 




