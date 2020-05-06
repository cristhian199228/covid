<?php

namespace App\Exports;

use App\Vecino;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class VecinoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Vecino::select('dni','nombres','apellido_paterno','apellido_materno','condicion')
        ->get()
        ->map(function ($Vecino) {
            if($Vecino->condicion == '1')
            $Vecino->condicion = str_replace('1', 'activo', $Vecino->condicion);
            if($Vecino->condicion == '0')
            $Vecino->condicion = str_replace('0', 'inactivo', $Vecino->condicion);
    
            return $Vecino;
        });
    }
    public function headings(): array
    {
        return [
            'DNI',
            'NOMBRES',
            'APELLIDO PATERNO',
            'APELLIDO MATERNO',
            'CONDICION'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:E1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:E1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('A4E8F3');
            },
        ];
    }
}
