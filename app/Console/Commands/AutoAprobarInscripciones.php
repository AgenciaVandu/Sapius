<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoAprobarInscripciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inscripciones:auto-aprobar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aprueba automáticamente las inscripciones que no han sido aceptadas por un admin en 2 horas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Iniciando proceso de auto-aprobación de inscripciones...');

        $dosHorasAtras = now()->subHours(2);
        $inicioDeAnio = now()->startOfYear(); // 2026-01-01

        $inscripciones = \App\Models\Registro\Inscripcion::where('aceptado', 'no')
            ->where('created_at', '>=', $inicioDeAnio) // Solo inscripciones de este año
            ->where('created_at', '<=', $dosHorasAtras)
            ->whereHas('CursoProgramado', function($query) {
                $query->where('fecha_fin', '>=', now()); // Solo cursos que no han finalizado
            })
            ->with(['User', 'CursoProgramado.category'])
            ->get();

        $count = $inscripciones->count();
        $this->info("Se encontraron {$count} inscripciones pendientes que cumplen los criterios.");

        foreach ($inscripciones as $inscripcion) {
            $this->info("Procesando inscripción ID: {$inscripcion->id} - Usuario: {$inscripcion->User->email}");

            // Aprobar la inscripción
            $inscripcion->aceptado = 'si';
            $inscripcion->save();

            // Enviar correo
            try {
                \Illuminate\Support\Facades\Mail::to($inscripcion->User->email)
                    ->send(new \App\Mail\AutoAceptacionEmail($inscripcion));
                
                $this->info("Correo enviado a {$inscripcion->User->email}");
            } catch (\Exception $e) {
                $this->error("Error al enviar correo a {$inscripcion->User->email}: " . $e->getMessage());
            }
        }

        $this->info('Proceso finalizado correctamente.');
        return 0;
    }
}
