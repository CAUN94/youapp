<?php

namespace App\Imports;

use App\Action;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ActionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Action([
            'Sucursal' => $row[0],
            'Nombre' => $row[1],
            'Apellido' => $row[2],
            'Categoria_Nr' => $row[3],
            'Categoria_Nombre' => $row[4],
            'Tratamiento_Nr' => $row[5],
            'Profesional' => $row[6],
            'Estado' => $row[7],
            'Convenio' => $row[8],
            'Prestacion_Nr' => $row[9],
            'Prestacion_Nombre' => $row[10],
            'Pieza_Tratada' => $row[11],
            'Fecha_Realizacion' => $row[12],
            'Precio_Prestacion' => $row[13],
            'Abonoo' => $row[14],
            'Total' => $row[15]
        ]);
    }

}
