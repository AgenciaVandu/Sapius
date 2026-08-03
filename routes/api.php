<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('sort/teachers','Api\SortController@teachers')->name('api.sort.teachers');
Route::post('sort/prides','Api\SortController@prides')->name('api.sort.prides');
Route::post('sort/slides','Api\SortController@slides')->name('api.sort.slides');
Route::post('sort/simuladores-medicina','Api\SortController@manageableSimulatorMedicine')->name('api.sort.simuladores.medicina');
Route::post('sort/simuladores-nutricion','Api\SortController@manageableSimulatorNutrition')->name('api.sort.simuladores.nutricion');
Route::post('sort/guias-medicina','Api\SortController@manageableGuiasMedicine')->name('api.sort.guias.medicines');
Route::post('sort/guias-nutricion','Api\SortController@manageableGuiasNutrition')->name('api.sort.guias.nutricion');

// routes/web.php o api.php
Route::get('/test-n8n', 'Api\N8nTestController@send')->name('test.n8n');

// Electron MAC Detector Routes
Route::post('/login', 'Api\AuthController@login');
Route::middleware('auth:api')->post('/validate-mac', 'Api\AuthController@validateMac');

// Electron Application Panel Endpoints
Route::middleware('auth:api')->group(function () {
    Route::post('/register-strike', 'Api\AuthController@registerStrike');
    Route::get('/user/locked-details', 'Api\AuthController@getLockedDetails');
    Route::get('/electron/dashboard', 'Api\ElectronPanelController@dashboard');
    Route::get('/electron/course/{id}', 'Api\ElectronPanelController@courseDetails');
    Route::get('/electron/lesson/{leccion_id}/{curso_programado_id}', 'Api\ElectronPanelController@lessonDetails');
    Route::post('/electron/lecciones/toggle-completion', 'Api\ElectronPanelController@toggleLessonCompletion');
    Route::get('/electron/homework-tracking/{curso_programado_id}', 'Api\ElectronPanelController@homeworkTracking');
    Route::post('/electron/send-homework', 'Api\ElectronPanelController@sendHomework');
    Route::get('/electron/calendar/{curso_programado_id}', 'Api\ElectronPanelController@getCalendar');
    Route::get('/electron/grades/{inscripcion_id}', 'Api\ElectronPanelController@getGrades');
    
    // Exams / Pruebas
    Route::get('/electron/exam/previo/{prueba_id}/{inscripcion_id}', 'Api\ElectronPanelController@examPrevio');
    Route::post('/electron/exam/presentar', 'Api\ElectronPanelController@examPresentar');
    Route::post('/electron/exam/finalizar', 'Api\ElectronPanelController@examFinalizar');
    Route::get('/electron/exam/feedback/{examen_id}', 'Api\ElectronPanelController@examFeedback');
    Route::post('/electron/exam/eventos', 'Api\ElectronPanelController@examEventos');
    
    // Secure Delivery
    Route::get('/electron/pdf/{leccion_id}', 'Api\ElectronPanelController@securePdf');
    
    // Imágenes de preguntas (ruta privada, no pública)
    Route::get('/electron/pregunta-imagen/{filename}', 'Api\ElectronPanelController@preguntaImagen');

    // Perfil del alumno (Fase 1)
    Route::get('/electron/profile', 'Api\ElectronPanelController@getProfile');
    Route::post('/electron/profile/update', 'Api\ElectronPanelController@updateProfile');
    Route::get('/electron/profile/foto/{file}', 'Api\ElectronPanelController@profileFoto');
    Route::get('/electron/profile/documento/{file}', 'Api\ElectronPanelController@profileDocumento');
    Route::get('/electron/profile/pase/{file}', 'Api\ElectronPanelController@profilePase');
    Route::post('/electron/request-mac-auth', 'Api\AuthController@requestMacAuth');

    // Notificaciones (Fase 2)
    Route::get('/electron/notifications', 'Api\ElectronPanelController@getNotifications');
    Route::post('/electron/notifications/{id}/read', 'Api\ElectronPanelController@markNotificationRead');
    Route::post('/electron/notifications/clear-all', 'Api\ElectronPanelController@clearAllNotifications');

    // Opiniones (Fase 3)
    Route::get('/electron/opinion/check/{curso_programado_id}', 'Api\ElectronPanelController@checkOpinionPending');
    Route::post('/electron/opinion/submit', 'Api\ElectronPanelController@submitOpinion');
});