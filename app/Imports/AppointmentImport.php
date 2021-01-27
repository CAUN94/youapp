<?php

namespace App\Imports;

use App\Appointment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AppointmentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Appointment([
            'Estado' => $row[1],
            'Fecha' => $row[2],
            'Hora_inicio' => $row[3],
            'Hora_termino' => $row[4],
            'Fecha_Generación' => $row[5],
            'Tratamiento_Nr' => $row[6],
            'Profesional' => $row[7],
            'Rut_Paciente' => $row[8],
            'Nombre_paciente' => $row[9],
            'Apellidos_paciente' => $row[10],
            'Mail' => $row[11],
            'Telefono' => $row[12],
            'Celular' => $row[13],
            'Convenio' => $row[14],
            'Convenio_Secundario' => $row[15],
            'Generación_Presupuesto' => $row[16],
            'Sucursal' => $row[17]
        ]);
    }
}
