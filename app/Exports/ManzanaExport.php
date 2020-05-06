<?php

namespace App\Exports;

use App\Manzana;
use App\Sector;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ManzanaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Manzana::select('sectors.descripcion','manzanas.descripcion as manzana','manzanas.comentario','manzanas.condicion')
        ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')
        ->get()
        ->map(function ($Manzana) {
            if($Manzana->condicion == '1')
            $Manzana->condicion = str_replace('1', 'activo', $Manzana->condicion);
            if($Manzana->condicion == '0')
            $Manzana->condicion = str_replace('0', 'inactivo', $Manzana->condicion);
    
            return $Manzana;
        });
    }
    public function headings(): array
    {
        return [
            'SECTOR',
            'MANZANA',
            'COMENTARIO',
            'CONDICION'
            
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:D1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:D1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('A4E8F3');
            },
        ];
    }
}
