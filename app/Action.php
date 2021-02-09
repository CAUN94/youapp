<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return Action::max('updated_at');
    }

    public static function occupation_summary($firstday,$lastday)
    {
        return "select  Query.Pro as Profesional,count(Query.T) as Atenciones,count(CASE when C <> 'Sin Convenio' and C <> 'Embajador' and C <> 'Pro Bono' THEN 1 END) as Convenio, count(CASE when C = 'Sin Convenio' THEN 1 END) as Sin_Convenio, count(CASE when C = 'Embajador' or C = 'Pro Bono' THEN 1 END) as Embajador, sum(PP) as Prestación, sum(A) as Abono from (select Profesional as Pro,Tratamiento_Nr as T, sum(Precio_Prestacion) as PP, sum(Abonoo) as A, Convenio as C, concat(Nombre,' ',Apellido) as P, Estado as E from actions where Fecha_Realizacion <= '".$lastday."' and Fecha_Realizacion >= '".$firstday."' group by Profesional,Tratamiento_Nr) as Query group by Query.Pro;";
        return DB::select( DB::raw("select  Query.Pro as Profesional,count(Query.T) as Atenciones,count(CASE when C <> 'Sin Convenio' and C <> 'Embajador' and C <> 'Pro Bono' THEN 1 END) as Convenio, count(CASE when C = 'Sin Convenio' THEN 1 END) as Sin_Convenio, count(CASE when C = 'Embajador' or C = 'Pro Bono' THEN 1 END) as Embajador, sum(PP) as Prestación, sum(A) as Abono from (select Profesional as Pro,Tratamiento_Nr as T, sum(Precio_Prestacion) as PP, sum(Abonoo) as A, Convenio as C, concat(Nombre,' ',Apellido) as P, Estado as E from actions where Fecha_Realizacion <= '".$lastday."' and Fecha_Realizacion >= '".$firstday."' group by Profesional,Tratamiento_Nr) as Query group by Query.Pro;") );
    }

    public function occupation($firstday,$lastday)
    {
    	return DB::select( DB::raw("select  Query.Pro as Profesional,count(Query.T) as Atenciones,count(CASE when C <> 'Sin Convenio' and C <> 'Embajador' and C <> 'Pro Bono' THEN 1 END) as Convenio, count(CASE when C = 'Sin Convenio' THEN 1 END) as Sin_Convenio, count(CASE when C = 'Embajador' or C = 'Pro Bono' THEN 1 END) as Embajador, sum(PP) as Prestación, sum(A) as Abono from (select Profesional as Pro,Tratamiento_Nr as T, sum(Precio_Prestacion) as PP, sum(Abonoo) as A, Convenio as C, concat(Nombre,' ',Apellido) as P, Estado as E from actions where Fecha_Realizacion <= '".$lastday."' and Fecha_Realizacion >= '".$firstday."' group by Profesional,Tratamiento_Nr) as Query group by Query.Pro;") );
    }

    public static function close_month()
    {
    	$action = new Action;
        $firstday = Carbon::create(null, date('m') - 1, 21, 00, 00, 01);
        $lastday = Carbon::create(null, null, 20, 23, 55, 55);
        $diff = 4;
        return [
            'actions' => $action->occupation($firstday,$lastday),
            'weeks' => $diff
        ];

    }

    public static function last_week()
    {
    	$action = new Action;
    	$firstday = Carbon::create(null,null,null,0,0,1)->subWeek()->startOfWeek();
        $lastday = Carbon::create(null,null,null,23,55,55)->subWeek()->startOfWeek()->addDay(6);
        $diff = 1;
        return [
            'actions' => $action->occupation($firstday,$lastday),
            'weeks' => $diff
        ];

    }

    public static function month()
    {
    	$action = new Action;
    	$firstday = Carbon::now()->firstOfMonth();
        $lastday = Carbon::now()->lastOfMonth();
        $diff = 4;
        return [
            'actions' => $action->occupation($firstday,$lastday),
            'weeks' => $diff
        ];
    }

    public static function noRepeats()
    {
        return Action::groupBy('Sucursal','Nombre','Apellido','Categoria_Nr','Categoria_Nombre','Tratamiento_Nr','Profesional','Estado','Convenio','Prestacion_Nr','Prestacion_Nombre','Pieza_Tratada','Fecha_Realizacion','Precio_Prestacion','Abonoo','Total')->get();
    }

    public static function professionalsCloseMonth()
    {
        $action = new Action;
        $firstday = Carbon::create(null, date('m') - 1, 21, 00, 00, 01);
        $lastday = Carbon::create(null, null, 20, 23, 55, 55);
        return DB::select( DB::raw("select Fecha_Realizacion as Fecha,Profesional as Profesional,Tratamiento_Nr as Tratamiento, sum(Precio_Prestacion) Prestación,sum(Abonoo) as Abono, Convenio as Convenio_Nombre, concat(Nombre,' ',Apellido) as Paciente, Estado as Estado  from actions  where Fecha_Realizacion <= '".$lastday."' and Fecha_Realizacion >= '".$firstday."'  group by Profesional,Tratamiento_Nr  order by Fecha_Realizacion asc;") );
    }

    public static function professionalCloseMonth($name)
    {
        $action = new Action;
        $firstday = Carbon::create(null, date('m') - 1, 21, 00, 00, 01);
        $lastday = Carbon::create(null, null, 20, 23, 55, 55);
        return DB::select( DB::raw("select Fecha_Realizacion as Fecha,Profesional as Profesional,Tratamiento_Nr as Tratamiento, sum(Precio_Prestacion) Prestación,sum(Abonoo) as Abono, Convenio as Convenio_Nombre, concat(Nombre,' ',Apellido) as Paciente, Estado as Estado  from actions  where Fecha_Realizacion <= '".$lastday."' and Fecha_Realizacion >= '".$firstday."' and Profesional like '".$name."'  group by Profesional,Tratamiento_Nr  order by Fecha_Realizacion asc;") );
    }

    public static function agreementHistory()
    {
        return DB::select( DB::raw("select Convenio,count(Convenio) as Cantidad from actions where Fecha_Realizacion >= '2021-01-01' and Estado in ('Atendido','Atendiéndose') and Convenio not like 'Sin Convenio' group by Convenio order by 2 desc ;") );
    }

}
