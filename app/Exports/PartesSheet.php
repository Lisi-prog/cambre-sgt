<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Cambre\Parte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings; 

class PartesSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $fcIni;
    protected $fcFin;

    public function __construct($fcIni, $fcFin)
    {
        $this->fcIni = $fcIni;
        $this->fcFin = $fcFin;
    }

    public function collection()
    {
        return Parte::whereBetween('fecha_carga', [$this->fcIni, $this->fcFin])
            ->select('id_parte',
                    'observaciones',
                    'fecha',
                    'fecha_limite',
                    'fecha_carga',
                    'horas',
                    'costo',
                    'id_orden',
                    'id_responsabilidad')
            ->get();
    }

    public function headings(): array
    {
        return ['id_parte', 'observaciones', 'fecha', 'fecha_limite', 'fecha_carga', 'horas', 'costo', 'id_orden', 'id_responsabilidad'];
    }

    public function title(): string
    {
        return 'Usuarios';
    }
}
