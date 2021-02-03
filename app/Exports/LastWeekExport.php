<?php

namespace App\Exports;

use App\Action;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LastWeekExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Action::last_week());
    }

    public function headings(): array
    {
        return [
            'Profesional',
            'Atenciones Totales',
            'Con Convenio',
            'Sin Convenio',
            'Embajador',
            'Prestación',
            'Abono'
        ];
    }
}
