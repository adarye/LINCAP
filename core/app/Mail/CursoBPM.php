<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CursoBPM extends Mailable
{
    public $empleados;
    public $fecha;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($empleados, $fecha)
    {
        $this->fecha = $fecha;
        $this->empleados = $empleados;
        Mailable::subject('BPM');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.EnviarBPM');
    }
}
