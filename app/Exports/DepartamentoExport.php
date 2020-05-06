<?php

namespace App\Exports;

use App\Departamento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DepartamentoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Departamento::select('sectors.descripcion as desc_sec','manzanas.descripcion as desc_man','lotes.descripcion as desc_lote','departamentos.descripcion as desc_dep','departamentos.comentario',
        'departamentos.condicion')
            ->join('lotes', 'lotes.id', '=', 'departamentos.idlote')
            ->join('manzanas', 'manzanas.id', '=', 'lotes.idmanzana')                
            ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')    
            ->get()
            ->map(function ($Departamento) {
                if($Departamento->condicion == '1')
                $Departamento->condicion = str_replace('1', 'activo', $Departamento->condicion);
                if($Departamento->condicion == '0')
                $Departamento->condicion = str_replace('0', 'inactivo', $Departamento->condicion);
        
                return $Departamento;
            });
    }

    public function headings(): array
    {
        return [
            'SECTOR',
            'MANZANA',
            'LOTE',
            'DEPARTAMENTO',
            'COMENTARIO',
            'CONDICION'
            
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:F1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('A4E8F3');
            },
        ];
    }
}
