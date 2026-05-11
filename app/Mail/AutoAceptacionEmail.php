<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutoAceptacionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscripcion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inscripcion)
    {
        $this->inscripcion = $inscripcion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('emails.auto_aceptacion')
                    ->subject('Bienvenido a tu curso - Aceptación Automática');

        $filePath = public_path('docs/instrucciones_acceso.pdf');
        
        if (file_exists($filePath)) {
            $mail->attach($filePath, [
                'as' => 'Instrucciones_de_Acceso.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
