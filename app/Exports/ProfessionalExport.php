<?php

namespace App\Exports;

use App\Action;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfessionalExport implements FromCollection, WithHeadings
{
	protected $name;

	 function __construct($name) {
	        $this->name = $name;
	 }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Action::professionalCloseMonth($this->name));
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
