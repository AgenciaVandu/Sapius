<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueLessonsReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $overdueLessons;
    public $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($overdueLessons, $student)
    {
        $this->overdueLessons = $overdueLessons;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.overdue_lessons')
                    ->subject('Te has atrasado en tu contenido - Sapius');
    }
}
