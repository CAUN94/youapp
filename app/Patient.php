<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \DB;

class Patient extends Model
{
    protected $fillable = ['prevision','rut','genre','email','phone','type','name','lastnames'];

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public static function rutSearch($rut)
    {
    	return Patient::where('rut',$rut)->first();
    }

    public static function tomorrow()
    {
    	$tomorrow = Carbon::tomorrow()->format('Y-m-d');
    	$sql = "select patients.name, patients.lastnames,status.name status,phone,patients.email,hour,benefit,professional_id ";
    	$sql .= "from patients join treatments  join  professionals join status ";
    	$sql .= "on treatments.patient_id = patients.id and treatments.professional_id = professionals.id and status_id = status.id ";
    	$sql .= "where date = '".$tomorrow."' ";
    	$sql .= "and status.name in ('No Confirmado','Agenda Online') ";
    	$sql .= "order by hour asc;";
        return DB::select(DB::raw($sql));
    }

}
