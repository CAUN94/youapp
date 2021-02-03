<?php

namespace App\Exports;

use App\Action;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfessionalsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Action::professionalsCloseMonth());
    }

    public function headings(): array
    {
        return [
			'Fecha',
			'Profesional',
			'Nr Tratatamiento',
			'Prestación',
			'Abono',
			'Convenio',
			'Paciente',
			'Estado'
        ];
    }
}
