<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    public static function last_register()
    {
        return Appointment::max('updated_at');
    }

    public static function tomorrow_appoiments()
    {
    	$tomorrow = Carbon::tomorrow();
        return DB::select( DB::raw("select a.Profesional , Estado,Nombre_paciente,Apellidos_paciente,Celular,Hora_inicio,TotalAtencion,Mail from appointments as a join treatments
        on a.Tratamiento_Nr = treatments.Atencion where  a.id in (SELECT max(id) FROM appointments where Fecha = '".$tomorrow."' and Estado not like 'Cambio de Fecha' group by Tratamiento_Nr) and Estado in ('No Confirmado','Agenda Online') order by Hora_inicio asc") );
    }

    public static function noRepeat()
    {
    	return Appointment::groupBy('Estado','Fecha','Hora_inicio','Hora_termino','Fecha_Generación','Tratamiento_Nr','Profesional','Rut_Paciente','Nombre_paciente','Apellidos_paciente','Mail','Telefono','Celular','Convenio','Convenio_Secundario','Generación_Presupuesto','Sucursal')->get();
    }

    public static function canceled()
    {
        $firsday = Carbon::create(null,null,null,null,null,null)->startOfWeek()->subDays(7);
        $lastday = Carbon::create(null,null,null,23,55,55);
        return DB::select( DB::raw("select Nombre_paciente,Apellidos_paciente,Max(Fecha),Estado,Celular,Mail,Profesional from appointments where fecha <= '".$lastday."' and fecha >= '".$firsday."' and Estado in ('Anulado','No asiste') group by Rut_Paciente;") );
    }
}
