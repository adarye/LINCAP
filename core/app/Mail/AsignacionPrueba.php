<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AsignacionPrueba extends Mailable
{
    public $user;
    public $prueba;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos, $prueba)
    {
        $this->user = $datos;
        $this->prueba = $prueba;
        $mensaje= "";
        if($prueba->cz3_categoria == 1){
         $mensaje = "Nueva Encuesta";
        }
        else{
            $mensaje = "Nueva Evaluación";
        }
        Mailable::subject($mensaje);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.AsignacionPrueba');
    }
}
