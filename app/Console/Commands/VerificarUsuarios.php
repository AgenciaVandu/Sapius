<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioDatos;

class VerificarUsuarios extends Command
{
    protected $signature = 'usuarios:verificar';
    protected $description = 'Verifica usuarios sin documentos y envía recordatorios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){
        // Usuarios inscritos a partir del año actual que NO cumplen requisitos
        // (no tienen documento_identificacion o no tienen pase_ingreso)
        $usuarios = User::whereYear('created_at', '>=', date('Y'))
            ->where(function ($q) {
                $q->whereNull('documento_identificacion')
                  ->orWhere('documento_identificacion', '')
                  ->orWhereNull('pase_ingreso')
                  ->orWhere('pase_ingreso', '');
            })->get();

        foreach ($usuarios as $user) {
            Mail::to($user->email)->queue(new RecordatorioDatos($user));
        }

        $this->info("Correos enviados correctamente.");
    }
}