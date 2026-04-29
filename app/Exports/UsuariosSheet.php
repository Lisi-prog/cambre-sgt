<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Parte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings; 

class PartesSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $nombre;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }

    public function collection()
    {
        return User::when($this->nombre, function ($query) {
                $query->where('name', 'like', '%' . $this->nombre . '%');
            })
            ->select('id', 'name', 'email')
            ->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Email'];
    }

    public function title(): string
    {
        return 'Usuarios';
    }
}
