<?php

namespace App\Exports;

use App\Lote;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LoteExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lote::select('sectors.descripcion as sectors_desc','manzanas.descripcion as manzana_desc','lotes.descripcion','lotes.comentario','lotes.condicion'e)
        ->join('manzanas', 'manzanas.id', '=', 'lotes.idmanzana')
        ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')
        ->orderBy('sectors.descripcion','asc','manzanas.descripcion', 'asc')    
        ->get()
        ->map(function ($Lote) {
            if($Lote->condicion == '1')
            $Lote->condicion = str_replace('1', 'activo', $Lote->condicion);
            if($Lote->condicion == '0')
            $Lote->condicion = str_replace('0', 'inactivo', $Lote->condicion);
    
            return $Lote;
        });
    }
    public function headings(): array
    {
        return [
            'SECTOR',
            'MANZANA',
            'LOTE',
            'COMENTARIO',
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
