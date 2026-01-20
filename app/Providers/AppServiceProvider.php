<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts.adminmart.menu-top', function ($view) {
            if (\Auth::check() && \Auth::user()->rol[0]->slug == 'alumno') {
                $activeExam = \App\Models\Evaluacion\Examen::with(['Prueba.Leccion.Curso', 'Inscripcion.CursoProgramado'])
                    ->whereHas('Inscripcion', function ($q) {
                        $q->where('user_id', \Auth::id());
                    })
                    ->where('finalizado', 'no')
                    ->latest()
                    ->first();
                $view->with('globalActiveExam', $activeExam);
            }
        });
    }
}
