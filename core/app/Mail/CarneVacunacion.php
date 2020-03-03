<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CarneVacunacion extends Mailable
{
    public $empleados;
    public $fecha;
    public $fecha2;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($empleados, $fecha, $fecha2)
    {
        $this->fecha = $fecha;
        $this->fecha2 = $fecha2;
        $this->empleados = $empleados;
        Mailable::subject('Proximos vencimientos del carné de vacunacion');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Mail.enviarCarneVacunacion');
    }
}