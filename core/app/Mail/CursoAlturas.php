<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CursoAlturas extends Mailable
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
        
        $this->empleados = $empleados;
        $this->fecha = $fecha;
        Mailable::subject('Proximos vencimientos del curso de altura');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.EnviarCA');
    }
}
