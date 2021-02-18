<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
	protected $fillable = [
		'number',
		'date',
		'benefit',
		'payment',
		'bank',
		'method',
		'boucher_nr',
		'referenc',
		'type',
		'duration',
		'health_record',
		'patient_id',
		'status_id',
		'sucursal_id',
		'professional_category_id'
	];


    public static function noRepeats()
    {
        return Treatment::groupBy('Ficha','Atencion','Nombre','Apellidos')->get();
    }

    public static function last_register()
    {
        return Treatment::max('updated_at');
    }

    public function benefits()
    {
        return $this->belongsToMany(Benefit::class,'benefits_treatments');
    }
}
