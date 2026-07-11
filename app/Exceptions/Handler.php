<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            $referer = $request->header('referer');
            $type = 'normal';
            if ($request->is('*examen*') || $request->is('*prueba*') || ($referer && (str_contains($referer, 'examen') || str_contains($referer, 'prueba')))) {
                $type = 'exam';
            }

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Sesión expirada.',
                    'redirect' => route('login', ['expired' => 1, 'type' => $type])
                ], 419);
            }

            return redirect()->route('login', ['expired' => 1, 'type' => $type]);
        }

        return parent::render($request, $exception);
    }
}
