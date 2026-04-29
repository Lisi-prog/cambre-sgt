<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteExport implements WithMultipleSheets
{
    protected $fcIni;
    protected $fcFin;

    public function __construct($fcIni, $fcFin)
    {
        $this->fcIni = $fcIni;
        $this->fcFin = $fcFin;
    }

    public function sheets(): array
    {
        return [
            new PartesSheet($this->fcIni, $this->fcFin),
            // new ProductosSheet(),
        ];
    }
}
