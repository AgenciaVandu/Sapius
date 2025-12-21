<?php

use Illuminate\Http\Request;
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