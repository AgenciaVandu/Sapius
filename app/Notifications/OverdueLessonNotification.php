<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OverdueLessonNotification extends Notification
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'modulo' => $this->data['modulo'],
            'titulo' => $this->data['titulo'],
            'fecha_final' => $this->data['fecha_final'],
            'leccion_id' => $this->data['leccion_id'] ?? null,
            'curso_programado_id' => $this->data['curso_programado_id'] ?? null,
            'inscripcion_id' => $this->data['inscripcion_id'] ?? null,
        ];
    }
}
