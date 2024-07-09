<?php

namespace App\Mail\Solicitud;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AceptarSolicitud extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $codigo;
    public $asunto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $codigo, $asunto)
    {
        $this->name = $name;
        $this->codigo = $codigo;
        $this->asunto = $asunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->asunto)
                    ->view('emails.Solicitud.aceptarSolicitud');

        // return $this->view('emails.contactanos');
    }
}
