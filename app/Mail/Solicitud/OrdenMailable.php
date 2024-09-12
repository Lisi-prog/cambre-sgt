<?php

namespace App\Mail\Solicitud;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrdenMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $name;
    public $codigo;
    public $tipo;
    public $responsable;
    public $proyecto;
    public $estado;
    public $opcion;
    public $codigo_pr;
    public $etapa;
    public $orden;
    public $tipo_ord;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $codigo, $tipo, $responsable, $proyecto, $estado, $codigo_pr, $etapa, $orden, $tipo_ord, $opcion)
    {
        $this->name = $name;
        $this->codigo = $codigo;
        $this->tipo = $tipo;
        $this->responsable = $responsable;
        $this->proyecto = $proyecto;
        $this->estado = $estado;
        $this->codigo_pr = $codigo_pr;
        $this->etapa = $etapa;
        $this->orden = $orden;
        $this->tipo_ord = $tipo_ord;
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
                return $this->subject('Nueva orden de '.$this->tipo.' para el proyecto '.$this->proyecto)
                    ->view('Ingenieria.Servicios.Ordenes.mail.nuevaOrden');
                break;
        }
    }
}
