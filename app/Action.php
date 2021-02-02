<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = [
    	'Sucursal',
		'Nombre',
		'Apellido',
		'Categoria_Nr',
		'Categoria_Nombre',
		'Tratamiento_Nr',
		'Profesional',
		'Estado',
		'Convenio',
		'Prestacion_Nr',
		'Prestacion_Nombre',
		'Pieza_Tratada',
		'Fecha_Realizacion',
		'Precio_Prestacion',
		'Abonoo',
		'Total'
    ];

    public static function last_register()
    {
        return Action::orderBy('updated_at','desc')->get()->first()->updated_at;
    }


}
