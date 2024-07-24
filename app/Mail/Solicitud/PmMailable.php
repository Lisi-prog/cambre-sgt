<?php

namespace App\Mail\Solicitud;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PmMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $name;
    public $codigo;
    public $opcion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $codigo, $opcion)
    {
        $this->name = $name;
        $this->codigo = $codigo;
        $this->opcion = $opcion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->opcion) {
            case 1:
                return $this->subject('Propuesta de mejora #'.$this->codigo)
                    ->view('Ingenieria.Solicitud.PM.mail.crearPm');
                break;
            case 2:
                return $this->subject('Cambio de estado PM #'.$this->codigo)
                    ->view('Ingenieria.Solicitud.PM.mail.aceptarPm');
                break;
            case 3:
                return $this->subject('Cambio de estado PM #'.$this->codigo)
                        ->view('Ingenieria.Solicitud.PM.mail.rechazarPm');
                break;
        }
    }
}
