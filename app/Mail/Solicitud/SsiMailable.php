<?php

namespace App\Mail\Solicitud;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SsiMailable extends Mailable implements ShouldQueue
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
                return $this->subject('Solicitud de servicio de ingenieria #'.$this->codigo)
                    ->view('emails.Solicitud.crearSsi');
                break;
            case 2:
                return $this->subject('Cambio de estado SSI #'.$this->codigo)
                    ->view('emails.Solicitud.aceptarSsi');
                break;
            case 3:
                return $this->subject('Cambio de estado SSI #'.$this->codigo)
                        ->view('emails.Solicitud.rechazarSsi');
                break;
            case 4:
                return $this->subject('Nuevo SSI #'.$this->codigo)
                        ->view('emails.Solicitud.avisoSsi');
                break;
            case 5:
                return $this->subject('Cambio de estado SSI #'.$this->codigo)
                            ->view('emails.Solicitud.completoSsi');
                break;
        }
    }
}
