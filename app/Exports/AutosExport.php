<?php

namespace App\Exports;

use App\Auto;
use App\FichasPasadas;
use App\FichaPaciente;
use App\Estacion;
use App\DatosClinicos;
use App\AntecedentesEp;
use App\PruebaSerologica;
use App\Temperatura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;




class AutosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents 
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
   
   
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function collection()
    {
        return $this->data;
    }
    
    public function headings(): array
    {
        return [
            
            'ID',
            'FECHA',
            'NOMBRES',
            'TIPO DE DOCUMENTO',
            'DNI',
            'NUMERO DE REGISTRO',
            'EMPRESA',
            'PUESTO',
            'DATOS CLINICOS',
            'ANT. EPIDEMIOLOGICOS',
            'TEMPERATURA',
            'PRUEBA SEROLOGICA'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:L1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:L1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
              


            },
        ];
    }

   




}
