<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('terms/conditions', function () {
    return view('terms');
});
//Socialite
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
//Home
Route::post('/informacion', 'UserController@informacion')->name('informacion');

Auth::routes();


Route::group(['middleware' =>['admin'],'prefix' => 'admin'], function() {
    Route::get('/', 'HomeController@admin')->name('admin');

    //Admistracion de usuarios
    Route::get('users/{activo?}', 'UserController@index')->name('users.index');
    Route::put('users/{id}', 'UserController@update')->name('users.update');
    Route::get('users/{id}/view', 'UserController@show')->name('users.show');
    Route::get('users/{id}/verify', 'UserController@verify')->name('users.verify');
    Route::post('users/approve', 'UserController@approve')->name('users.approve');
    Route::post('users/unapprove', 'UserController@unapprove')->name('users.unapprove');
    Route::delete('users/{role}', 'UserController@destroy')->name('users.destroy');
    Route::get('users/{role}/edit', 'UserController@edit')->name('users.edit');
    Route::post('/users/profile/p', 'UserController@profile')->name('admin.profile');//{id}
    Route::get('users/{role}/complete', 'UserController@complete')->name('admin.complete');
    Route::put('users/{id}/updateComplete', 'UserController@updateComplete')->name('admin.updateComplete');
    Route::get('/users/image/{file}', 'UserController@userPicture')->name('admin.image');
    Route::get('/users/pase/{file}', 'UserController@pase')->name('admin.pase');
    Route::get('/users/documento/{file}', 'UserController@documento')->name('admin.documento');

    // Cursos
    Route::get('/cursos', 'Cursos\CursoController@index')->name('admin.cursos.index');
    Route::get('/cursos/create', 'Cursos\CursoController@create')->name('cursos.create');
    Route::post('/cursos/store', 'Cursos\CursoController@store')->name('cursos.store');
    Route::get('cursos/{id}/view', 'Cursos\CursoController@show')->name('admin.cursos.show');//{id}
    Route::post('/cursos/edit', 'Cursos\CursoController@edit')->name('cursos.edit');//{id}
    Route::post('/cursos/update', 'Cursos\CursoController@update')->name('cursos.update');
    Route::post('/cursos/destroy', 'Cursos\CursoController@destroy')->name('cursos.destroy');//{id}
    Route::post('/cursos/activate', 'Cursos\CursoController@activate')->name('cursos.activate');//{id}
    Route::get('/cursos/getall/{active}', 'Cursos\CursoController@getAll')->name('admin.gcu');
    Route::get('/cursos/image/{file}', 'Cursos\CursoController@cursoPicture')->name('admin.cursos.image');


    // Lecciones
    Route::post('/cursos/modulos', 'Cursos\LeccionController@index')->name('admin.lecciones.index');//{curso_id}
    Route::post('/modulos/create', 'Cursos\LeccionController@create')->name('admin.lecciones.create');//{curso_id}
    Route::post('/modulos/store', 'Cursos\LeccionController@store')->name('admin.lecciones.store');
    Route::get('modulos/{id}/view', 'Cursos\LeccionController@show')->name('admin.lecciones.show');//{id}
    Route::post('/modulos/edit', 'Cursos\LeccionController@edit')->name('admin.lecciones.edit');//{id}
    Route::post('/modulos/update', 'Cursos\LeccionController@update')->name('admin.lecciones.update');
    Route::post('/modulos/destroy', 'Cursos\LeccionController@destroy')->name('admin.lecciones.destroy');//{id}
    Route::post('/modulos/activate', 'Cursos\LeccionController@activate')->name('admin.lecciones.activate');//{id}
    Route::get('/modulos/getall/{curso_id}/{leccion_id}/{active}', 'Cursos\LeccionController@getAll')->name('admin.gle');
    Route::get('/modulos/image/{file}', 'Cursos\LeccionController@cursoPicture')->name('admin.lecciones.image');

    // Pruebas
    Route::post('/cursos/modulos/pruebas', 'Cursos\PruebaController@index')->name('admin.pruebas.index');//{leccion_id}
    Route::post('/pruebas/create', 'Cursos\PruebaController@create')->name('admin.pruebas.create');//{leccion_id}
    Route::post('/pruebas/store', 'Cursos\PruebaController@store')->name('admin.pruebas.store');
    Route::get('pruebas/{id}/view', 'Cursos\PruebaController@show')->name('admin.pruebas.show');//{id}
    Route::post('/pruebas/edit', 'Cursos\PruebaController@edit')->name('admin.pruebas.edit');//{id}
    Route::post('/pruebas/update', 'Cursos\PruebaController@update')->name('admin.pruebas.update');
    Route::post('/pruebas/duplicate', 'Cursos\PruebaController@duplicate')->name('admin.pruebas.duplicate');
    Route::post('/pruebas/destroy', 'Cursos\PruebaController@destroy')->name('admin.pruebas.destroy');//{id}
    Route::post('/pruebas/activate', 'Cursos\PruebaController@activate')->name('admin.pruebas.activate');//{id}
    Route::get('/pruebas/getall/{leccion_id}/{active}', 'Cursos\PruebaController@getAll')->name('admin.gpru');

    // Preguntas
    Route::post('/cursos/modulos/pruebas/preguntas', 'Cursos\PreguntaController@index')->name('admin.preguntas.index');//{prueba_id}
    Route::post('/preguntas/create', 'Cursos\PreguntaController@create')->name('admin.preguntas.create');//{prueba_id}
    Route::post('/preguntas/store', 'Cursos\PreguntaController@store')->name('admin.preguntas.store');
    Route::get('preguntas/{id}/view', 'Cursos\PreguntaController@show')->name('admin.preguntas.show');//{id}
    Route::get('preguntas/{prueba_id}/form', 'Cursos\PreguntaController@showimportar')->name('admin.preguntas.form-importar');//{prueba_id}
    Route::post('preguntas/importar', 'Cursos\PreguntaController@importar')->name('admin.preguntas.importar');
    Route::post('/preguntas/edit', 'Cursos\PreguntaController@edit')->name('admin.preguntas.edit');//{id}
    Route::post('/preguntas/update', 'Cursos\PreguntaController@update')->name('admin.preguntas.update');
    Route::post('/preguntas/destroy', 'Cursos\PreguntaController@destroy')->name('admin.preguntas.destroy');//{id}
    Route::post('/preguntas/activate', 'Cursos\PreguntaController@activate')->name('admin.preguntas.activate');//{id}
    Route::get('/preguntas/getall/{prueba_id}/{active}', 'Cursos\PreguntaController@getAll')->name('admin.gpre');
    Route::get('/preguntas/image/{file}', 'Cursos\PreguntaController@cursoPicture')->name('admin.preguntas.image');

    // Respuestas
    Route::post('/cursos/modulos/pruebas/preguntas/respuestas', 'Cursos\RespuestaController@index')->name('admin.respuestas.index');//{pregunta_id}
    Route::post('/respuestas/create', 'Cursos\RespuestaController@create')->name('admin.respuestas.create');//{pregunta_id}
    Route::post('/respuestas/store', 'Cursos\RespuestaController@store')->name('admin.respuestas.store');
    Route::get('respuestas/{id}/view', 'Cursos\RespuestaController@show')->name('admin.respuestas.show');//{id}
    Route::post('/respuestas/edit', 'Cursos\RespuestaController@edit')->name('admin.respuestas.edit');//{id}
    Route::post('/respuestas/update', 'Cursos\RespuestaController@update')->name('admin.respuestas.update');
    Route::post('/respuestas/destroy', 'Cursos\RespuestaController@destroy')->name('admin.respuestas.destroy');//{id}
    Route::post('/respuestas/activate', 'Cursos\RespuestaController@activate')->name('admin.respuestas.activate');//{id}
    Route::get('/respuestas/getall/{prueba_id}/{active}', 'Cursos\RespuestaController@getAll')->name('admin.gres');
    Route::get('/respuestas/image/{file}', 'Cursos\RespuestaController@cursoPicture')->name('admin.respuestas.image');

    // Medias
    Route::post('/cursos/modulos/medias', 'Cursos\MediaController@index')->name('admin.medias.index');//{leccion_id}
    Route::post('/medias/create', 'Cursos\MediaController@create')->name('admin.medias.create');//{leccion_id}
    Route::post('/medias/store', 'Cursos\MediaController@store')->name('admin.medias.store');
    Route::get('medias/{id}/view', 'Cursos\MediaController@show')->name('admin.medias.show');//{id}
    Route::post('/medias/edit', 'Cursos\MediaController@edit')->name('admin.medias.edit');//{id}
    Route::post('/medias/update', 'Cursos\MediaController@update')->name('admin.medias.update');
    Route::post('/medias/destroy', 'Cursos\MediaController@destroy')->name('admin.medias.destroy');//{id}
    Route::post('/medias/activate', 'Cursos\MediaController@activate')->name('admin.medias.activate');//{id}
    Route::get('/medias/getall/{leccion_id}/{active}', 'Cursos\MediaController@getAll')->name('admin.gmed');
    Route::get('/medias/image/{file}', 'Cursos\MediaController@mediaPicture')->name('admin.medias.image');
    Route::get('/medias/stream/{filename}', 'Cursos\MediaController@stream')->name('admin.medias.stream2');
    Route::get('/medias/archivo/{file}', 'Cursos\MediaController@archivo')->name('admin.medias.archivo');

    //Registros
    Route::post('/registro/programacion', 'Registro\CursoProgramadoController@index')->name('schedule');//{curso_id}
    Route::get('/registro/getallschedule/{curso_id}/{active}', 'Registro\CursoProgramadoController@getAllSchedule')->name('schedule.getall');
    Route::post('/resgistro/create', 'Registro\CursoProgramadoController@create')->name('schedule.create');//{curso_id}
    Route::post('/resgistro/store', 'Registro\CursoProgramadoController@store')->name('schedule.store');//{curso_id}
    Route::post('/resgistro/edit', 'Registro\CursoProgramadoController@edit')->name('schedule.edit');//{curso_id}
    Route::post('/resgistro/update', 'Registro\CursoProgramadoController@update')->name('schedule.update');//{curso_id}
    Route::post('/resgistro/destroy', 'Registro\CursoProgramadoController@destroy')->name('schedule.destroy');//{id}

    Route::post('/registro/descuentos', 'Registro\DescuentoController@index')->name('descuento.index');//{curso_id}
    Route::get('/registro/getalldescuentos/{curso_id}', 'Registro\DescuentoController@getAllDescuentos')->name('descuento.getall');
    Route::post('/registro/descuentos/create', 'Registro\DescuentoController@create')->name('descuento.create');//{curso_id}
    Route::post('/registro/descuentos/store', 'Registro\DescuentoController@store')->name('descuento.store');//{curso_id}
    Route::post('/registro/descuentos/edit', 'Registro\DescuentoController@edit')->name('descuento.edit');//{curso_id}
    Route::post('/registro/descuentos/update', 'Registro\DescuentoController@update')->name('descuento.update');//{curso_id}

    Route::post('/registro/contenido', 'Registro\ContenidoProgramadoController@index')->name('contenido.index');//{curso_id}
    Route::post('/registro/contenido/store', 'Registro\ContenidoProgramadoController@store')->name('contenido.store');//{curso_id}

    Route::post('/curso', 'Registro\CursoProgramadoController@listaInscritos')->name('admin.cursos.lista-inscritos');
    Route::get('/curso/{curso_id}/{active?}', 'Registro\CursoProgramadoController@getInscritos')->name('admin.cursos.get-inscritos');
    Route::post('/curso/destroy', 'Registro\CursoProgramadoController@destroyInscritos')->name('curso.destroy');//{id}
    Route::post('/curso/activate', 'Registro\CursoProgramadoController@activateInscritos')->name('curso.activate');//{id}

    Route::get('/evaluacion/resultados/{inscripcion_id}', 'Evaluacion\ExamenController@listaResultados')->name('admin.curso.lista-resultados');//{id}
});

Route::group(['middleware' =>['instructor'],'prefix' => 'instructor'], function() {
    Route::get('/', 'HomeController@instructor')->name('instructor');
    Route::post('/users/profile/p', 'UserController@profile')->name('instructor.profile');//{id}
    Route::get('/users/pase/{file}', 'UserController@pase')->name('instructor.pase');
    Route::get('/users/documento/{file}', 'UserController@documento')->name('instructor.documento');
    Route::get('/users/image/{file}', 'UserController@userPicture')->name('instructor.image');
    Route::get('users/{role}/complete', 'UserController@complete')->name('instructor.complete');
    Route::put('users/{id}/updateComplete', 'UserController@updateComplete')->name('instructor.updateComplete');

    //Cursos
    Route::get('/cursos', 'Cursos\CursoController@index')->name('instructor.cursos.index');
    Route::get('/cursos/getall/{active}', 'Cursos\CursoController@getAllForInstructor')->name('instructor.gcu');
    Route::get('cursos/{id}/view', 'Cursos\CursoController@show')->name('instructor.cursos.show');//{id}
    Route::get('/cursos/image/{file}', 'Cursos\CursoController@cursoPicture')->name('instructor.cursos.image');

    // Lecciones
    Route::post('/cursos/modulos', 'Cursos\LeccionController@index')->name('instructor.lecciones.index');//{curso_id}
    Route::post('/modulos/create', 'Cursos\LeccionController@create')->name('instructor.lecciones.create');//{curso_id}
    Route::post('/modulos/store', 'Cursos\LeccionController@store')->name('instructor.lecciones.store');
    Route::get('modulos/{id}/view', 'Cursos\LeccionController@show')->name('instructor.lecciones.show');//{id}
    Route::post('/modulos/edit', 'Cursos\LeccionController@edit')->name('instructor.lecciones.edit');//{id}
    Route::post('/modulos/update', 'Cursos\LeccionController@update')->name('instructor.lecciones.update');
    Route::post('/modulos/destroy', 'Cursos\LeccionController@destroy')->name('instructor.lecciones.destroy');//{id}
    Route::post('/modulos/activate', 'Cursos\LeccionController@activate')->name('instructor.lecciones.activate');//{id}
    Route::get('/modulos/getall/{curso_id}/{leccion_id}/{active}', 'Cursos\LeccionController@getAll')->name('instructor.gle');
    Route::get('/modulos/image/{file}', 'Cursos\LeccionController@cursoPicture')->name('instructor.lecciones.image');

    // Pruebas
    Route::post('/cursos/modulos/pruebas', 'Cursos\PruebaController@index')->name('instructor.pruebas.index');//{leccion_id}
    Route::post('/pruebas/create', 'Cursos\PruebaController@create')->name('instructor.pruebas.create');//{leccion_id}
    Route::post('/pruebas/store', 'Cursos\PruebaController@store')->name('instructor.pruebas.store');
    Route::get('pruebas/{id}/view', 'Cursos\PruebaController@show')->name('instructor.pruebas.show');//{id}
    Route::post('/pruebas/edit', 'Cursos\PruebaController@edit')->name('instructor.pruebas.edit');//{id}
    Route::post('/pruebas/update', 'Cursos\PruebaController@update')->name('instructor.pruebas.update');
    Route::post('/pruebas/duplicate', 'Cursos\PruebaController@duplicate')->name('instructor.pruebas.duplicate');
    Route::post('/pruebas/destroy', 'Cursos\PruebaController@destroy')->name('instructor.pruebas.destroy');//{id}
    Route::post('/pruebas/activate', 'Cursos\PruebaController@activate')->name('instructor.pruebas.activate');//{id}
    Route::get('/pruebas/getall/{leccion_id}/{active}', 'Cursos\PruebaController@getAll')->name('instructor.gpru');

    // Preguntas
    Route::post('/cursos/modulos/pruebas/preguntas', 'Cursos\PreguntaController@index')->name('instructor.preguntas.index');//{prueba_id}
    Route::post('/preguntas/create', 'Cursos\PreguntaController@create')->name('instructor.preguntas.create');//{prueba_id}
    Route::post('/preguntas/store', 'Cursos\PreguntaController@store')->name('instructor.preguntas.store');
    Route::get('preguntas/{id}/view', 'Cursos\PreguntaController@show')->name('instructor.preguntas.show');//{id}
    Route::get('preguntas/{prueba_id}/form', 'Cursos\PreguntaController@showimportar')->name('instructor.preguntas.form-importar');//{prueba_id}
    Route::post('preguntas/importar', 'Cursos\PreguntaController@importar')->name('instructor.preguntas.importar');
    Route::post('/preguntas/edit', 'Cursos\PreguntaController@edit')->name('instructor.preguntas.edit');//{id}
    Route::post('/preguntas/update', 'Cursos\PreguntaController@update')->name('instructor.preguntas.update');
    Route::post('/preguntas/destroy', 'Cursos\PreguntaController@destroy')->name('instructor.preguntas.destroy');//{id}
    Route::post('/preguntas/activate', 'Cursos\PreguntaController@activate')->name('instructor.preguntas.activate');//{id}
    Route::get('/preguntas/getall/{prueba_id}/{active}', 'Cursos\PreguntaController@getAll')->name('instructor.gpre');
    Route::get('/preguntas/image/{file}', 'Cursos\PreguntaController@cursoPicture')->name('instructor.preguntas.image');

    // Respuestas
    Route::post('/cursos/modulos/pruebas/preguntas/respuestas', 'Cursos\RespuestaController@index')->name('instructor.respuestas.index');//{pregunta_id}
    Route::post('/respuestas/create', 'Cursos\RespuestaController@create')->name('instructor.respuestas.create');//{pregunta_id}
    Route::post('/respuestas/store', 'Cursos\RespuestaController@store')->name('instructor.respuestas.store');
    Route::get('respuestas/{id}/view', 'Cursos\RespuestaController@show')->name('instructor.respuestas.show');//{id}
    Route::post('/respuestas/edit', 'Cursos\RespuestaController@edit')->name('instructor.respuestas.edit');//{id}
    Route::post('/respuestas/update', 'Cursos\RespuestaController@update')->name('instructor.respuestas.update');
    Route::post('/respuestas/destroy', 'Cursos\RespuestaController@destroy')->name('instructor.respuestas.destroy');//{id}
    Route::post('/respuestas/activate', 'Cursos\RespuestaController@activate')->name('instructor.respuestas.activate');//{id}
    Route::get('/respuestas/getall/{prueba_id}/{active}', 'Cursos\RespuestaController@getAll')->name('instructor.gres');
    Route::get('/respuestas/image/{file}', 'Cursos\RespuestaController@cursoPicture')->name('instructor.respuestas.image');

    // Medias
    Route::post('/cursos/modulos/medias', 'Cursos\MediaController@index')->name('instructor.medias.index');//{leccion_id}
    Route::post('/medias/create', 'Cursos\MediaController@create')->name('instructor.medias.create');//{leccion_id}
    Route::post('/medias/store', 'Cursos\MediaController@store')->name('instructor.medias.store');
    Route::get('medias/{id}/view', 'Cursos\MediaController@show')->name('instructor.medias.show');//{id}
    Route::post('/medias/edit', 'Cursos\MediaController@edit')->name('instructor.medias.edit');//{id}
    Route::post('/medias/update', 'Cursos\MediaController@update')->name('instructor.medias.update');
    Route::post('/medias/destroy', 'Cursos\MediaController@destroy')->name('instructor.medias.destroy');//{id}
    Route::post('/medias/activate', 'Cursos\MediaController@activate')->name('instructor.medias.activate');//{id}
    Route::get('/medias/getall/{leccion_id}/{active}', 'Cursos\MediaController@getAll')->name('instructor.gmed');
    Route::get('/medias/image/{file}', 'Cursos\MediaController@mediaPicture')->name('instructor.medias.image');
    Route::get('/medias/stream/{filename}', 'Cursos\MediaController@stream')->name('instructor.medias.stream2');
    Route::get('/medias/archivo/{file}', 'Cursos\MediaController@archivo')->name('instructor.medias.archivo');

    //inscritos
    Route::post('/curso', 'Registro\CursoProgramadoController@listaInscritos')->name('instructor.cursos.lista-inscritos');
    Route::get('/curso/{curso_id}/{active?}', 'Registro\CursoProgramadoController@getInscritos')->name('instructor.cursos.get-inscritos');
    Route::get('/evaluacion/resultados/{inscripcion_id}', 'Evaluacion\ExamenController@listaResultados')->name('instructor.curso.lista-resultados');//{id}

    //Soporte
    Route::get('/soporte', 'UserController@soporte')->name('instructor.soporte');
    Route::post('/soporte', 'UserController@correoSoporte')->name('instructor.soporte-enviar');
});

Route::group(['middleware' =>['alumno'],'prefix' => 'alumno'], function() {
    Route::get('/', 'HomeController@index')->name('alumno');
    Route::post('/users/profile', 'UserController@profile')->name('alumno.profile');//{id}
    Route::get('/users/pase/{file}', 'UserController@pase')->name('alumno.pase');
    Route::get('/users/documento/{file}', 'UserController@documento')->name('alumno.documento');

    //Cursos
    Route::get('/cursos', 'HomeController@cursosDisponibles')->name('cursos.disponibles');
    Route::post('/curso', 'Registro\CursoProgramadoController@cursoDetallado')->name('cursos.detallado');
    Route::post('/modulo', 'Registro\CursoProgramadoController@leccionDetallada')->name('leccion.detallada');
    Route::get('/inscripcion/{curso_id}', 'Registro\InscripcionController@inscripcion')->name('inscripcion.form');
    Route::post('/inscripcion', 'Registro\InscripcionController@pago')->name('inscripcion.pago');
    Route::get('/cursos/video', 'Cursos\CursoController@video')->name('cursos.video');
    Route::get('/cursos/token', 'Cursos\CursoController@token')->name('cursos.token');
    Route::post('/cursos/payment', 'Cursos\CursoController@payment')->name('cursos.payment');
    Route::post('/cursos/paymentOxxo', 'Cursos\CursoController@paymentOxxo')->name('cursos.paymentOxxo');
    Route::get('/cursos/payment2', 'Cursos\CursoController@payment2')->name('cursos.payment2');
    Route::get('/cursos/image/{file}', 'Cursos\CursoController@cursoPicture')->name('alumno.cursos.image');

    //Evaluacion
    Route::get('/evaluacion/prueba/{prueba_id}/{inscripcion_id}', 'Evaluacion\ExamenController@previo')->name('examen.previo');
    Route::post('/evaluacion/prueba', 'Evaluacion\ExamenController@presentar')->name('examen.presentar');
    Route::get('/evaluacion/finalizar/{examen_id}', 'Evaluacion\ExamenController@formFinalizar')->name('examen.finalizar-form');
    Route::post('/evaluacion/finalizar-imprevisto', 'Evaluacion\ExamenController@formFinalizarImprevisto')->name('examen.finalizar-imprevisto');
    Route::post('/evaluacion/finalizar', 'Evaluacion\ExamenController@finalizar')->name('examen.finalizar');
    Route::post('/evaluacion/retroalimentacion', 'Evaluacion\ExamenController@feedback')->name('examen.feedback');
    Route::post('/evaluacion/retroalimentacion-finalizar', 'Evaluacion\ExamenController@feedbackFinalizar')->name('examen.feedback-finalizar');
    Route::post('/evaluacion/eventos', 'Evaluacion\ExamenController@eventos')->name('examen.eventos');

    //Lecciones
    Route::get('/modulos/image/{file}', 'Cursos\LeccionController@cursoPicture')->name('alumno.lecciones.image');
    Route::get('/tarea/{leccion_id}/{curso_programado_id}', 'Cursos\LeccionController@tarea')->name('alumno.lecciones.tarea');
    Route::post('/sendTarea', 'Cursos\LeccionController@sendTarea')->name('alumno.lecciones.sendTarea');

    //Medias
    Route::get('medias/{id}/view', 'Cursos\MediaController@show')->name('alumnos.medias.show');
    Route::get('/medias/image/{file}', 'Cursos\MediaController@mediaPicture')->name('alumno.medias.image');
    Route::get('medias/stream/{filename}', 'Cursos\MediaController@stream')->name('alumno.medias.stream');
    Route::get('/medias/archivo/{file}', 'Cursos\MediaController@archivo')->name('alumno.medias.archivo');

    //Usuarios
    Route::get('users/{role}/complete', 'UserController@complete')->name('alumno.complete');
    Route::put('users/{id}/updateComplete', 'UserController@updateComplete')->name('alumno.updateComplete');
    Route::get('/users/image/{file}', 'UserController@userPicture')->name('alumno.image');
    //Route::get('/users/pase/{file}', 'UserController@pase')->name('users.pase');
    //Route::get('/users/documento/{file}', 'UserController@documento')->name('users.documento');

    //Soporte
    Route::get('/soporte', 'UserController@soporte')->name('alumno.soporte');
    Route::post('/soporte', 'UserController@correoSoporte')->name('alumno.soporte-enviar');

    //Calendario
    Route::get('/calendario', 'UserController@calendario')->name('alumno.calendario');

    //Descuentos
    Route::post('descuentos/check', 'Registro\DescuentoController@check')->name('descuentos.check');
});
