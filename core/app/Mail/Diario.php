<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Diario extends Mailable
{
    public $empleados;
    public $date_principio;
    public $date_final;
    use Queueable, SerializesModels;
 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($empleados, $date_principio, $date_final)
    {
        $this->empleados = $empleados;
        $this->date_principio = $date_principio;
        $this->date_final = $date_final;
        Mailable::subject('Contratos próximos a finalizar ');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.ContratoFinaliza');
    }
}
