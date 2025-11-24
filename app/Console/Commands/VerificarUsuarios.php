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
        // Usuarios que NO cumplen requisitos
        $usuarios = User::where(function ($q) {
            $q->whereNull('documento_identificacion')
            ->orWhereNull('pase_ingreso');
        })->get();

        foreach ($usuarios as $user) {
            Mail::to($user->email)->queue(new RecordatorioDatos($user));
        }

        $this->info("Correos enviados correctamente.");
    }
}