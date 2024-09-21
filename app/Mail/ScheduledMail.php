<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduledMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $opcion;

    public function __construct($data, $opcion)
    {
        $this->data = $data;
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
                return $this->view('emails.scheduled')
                    ->subject('Resumen semanal')
                    ->with('data', $this->data);
                break;
            case 2:
                return $this->view('emails.noAvances')
                    ->subject('Resumen semanal')
                    ->with('data', $this->data);
                break;
            default:
                # code...
                break;
        }
        
    }
}
