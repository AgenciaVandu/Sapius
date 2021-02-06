<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Evaluacion\Examen;

class ExamenFinalizado extends Mailable
{
    use Queueable, SerializesModels;
    public $examen;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Examen $examen)
    {
        $this->examen = $examen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.examen-finalizado')->subject('Examen Finalizado');
    }
}
