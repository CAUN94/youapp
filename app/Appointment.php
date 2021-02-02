<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    public static function last_register()
    {
        return Appointment::orderBy('updated_at','desc')->get()->first()->updated_at;
    }

    public static function tomorrow_appoiments()
    {
    	$tomorrow = Carbon::tomorrow();
        return DB::select( DB::raw("select * from appointments as a where  id in (SELECT max(id) FROM appointments where Fecha = '".$tomorrow."'  group by Tratamiento_Nr) and Estado in ('No Confirmado','Agenda Online') order by Hora_inicio asc") );
    }
}
