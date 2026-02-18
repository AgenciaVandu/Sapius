<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class RecordatorioDatos extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $usuario;

    public function __construct(User $usuario){
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user-notification-verify')->subject('Recordatorio: Completa tus datos de acceso');
    }
}
