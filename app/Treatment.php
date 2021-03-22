<?php

namespace App;

use App\Patient;
use App\Professional;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \DB;

class Treatment extends Model
{
	protected $fillable = [
		'number',
		'date',
		'hour',
		'benefit',
		'payment',
		'bank',
		'method',
		'boucher_nr',
		'reference',
		'type',
		'duration',
		'health_record',
		'patient_id',
		'status_id',
		'sucursal_id',
		'category_id',
		'professional_id'
	];


    public static function noRepeats()
    {
        return Treatment::groupBy('Ficha','Atencion','Nombre','Apellidos')->get();
    }

    public static function last_register()
    {
        return Treatment::max('updated_at');
    }

    public static function finance($startOfYear,$endOfYear)
    {
    	$sql = "select month(date) Fecha,sum(benefit) Prestacion, sum(payment) Abono ";
        $sql .= "from treatments ";
        $sql .= "where date >= '".$startOfYear."' and date <= '".$endOfYear."' and status_id in (3,4) ";
        $sql .= "group by month(date) ";
        $sql .=  "order by 1 asc ;";

        return DB::select( DB::raw($sql) );
    }

    public static function prevision_year($startOfYear,$endOfYear)
    {
    	$sql = "select year(date) Año,month(date) Mes,count(number) as Atenciones, ";
        $sql .= "count(CASE when prevision <> 'Sin Convenio' and prevision <> 'Embajador' and prevision <> 'Pro Bono' THEN 1 END) as Convenio, ";
        $sql .= "count(CASE when prevision = 'Sin Convenio' THEN 1 END) as Sin_Convenio, ";
        $sql .= "count(CASE when prevision = 'Embajador' or prevision = 'Pro Bono' THEN 1 END) as Embajador ";
        $sql .= "from treatments join patients p ";
        $sql .= "on treatments.patient_id = p.id ";
        $sql .= "where date >= '".$startOfYear."' and date <= '".$endOfYear."' and status_id in (3) ";
        $sql .= "group by month(date); ";

        return DB::select( DB::raw($sql) );
    }

    public static function ocuppation($firstday,$lastday,$professional = Null)
    {
        if(is_null($professional)){
            return DB::select( DB::raw(
            "select professional_id,date,patient_id,count(number) as Atenciones, count(CASE when prevision <> 'Sin Convenio' and prevision <> 'Embajador' and prevision <> 'Pro Bono' THEN 1 END) as Convenio, count(CASE when prevision = 'Sin Convenio' THEN 1 END) as Sin_Convenio, count(CASE when prevision = 'Embajador' or prevision = 'Pro Bono' THEN 1 END) as Embajador, sum(benefit) as Prestación, sum(payment) as Abono from treatments join patients p on treatments.patient_id = p.id where date between '".$firstday."' and '".$lastday."' and status_id in (3,4) group by professional_id;") );
        }
        return DB::select( DB::raw(
            "select professional_id,date,patient_id,number as Atenciones,
           CASE when prevision <> 'Sin Convenio' and prevision <> 'Embajador' and prevision <> 'Pro Bono' THEN 1 END as Convenio,
           CASE when prevision = 'Sin Convenio' THEN 1 END as Sin_Convenio,
           CASE when prevision = 'Embajador' or prevision = 'Pro Bono' THEN 1 END as Embajador,
           benefit as Prestación,
           payment as Abono
            from treatments join patients p on treatments.patient_id = p.id
            where date between '".$firstday."' and '".$lastday."' and status_id in (3) and professional_id = '".$professional."';") );

    }

    public static function category($firstday,$lastday,$professional = Null)
    {
        if(is_null($professional)){
            return DB::select( DB::raw("select Query.Categoria_Nombre as Categoria,count(Query.Tratamiento_Nr) as Cantidad from
                (select Categoria_Nombre,Tratamiento_nr from actions
                where Fecha_Realizacion <= '".$lastday."' and Fecha_Realizacion >= '".$firstday."'
                group by 2) as Query group by 1 order by Cantidad desc;") );
        }
        return DB::select( DB::raw("select Query.Categoria_Nombre as Categoria,count(Query.Tratamiento_Nr) as Cantidad from
                (select Categoria_Nombre,Tratamiento_nr,Profesional from actions
                where Fecha_Realizacion <= '".$lastday."' and Fecha_Realizacion >= '".$firstday."'
                group by 2) as Query where Query.Profesional like '".$professional."' group by 1 order by Cantidad desc;") );

    }

    public function benefits()
    {
        return $this->belongsToMany(Benefit::class,'benefits_treatments');
    }

    public static function professionalsCloseMonth(){
        $firstday = Carbon::create(null, null, 21, 00, 00, 01);
        $lastday = Carbon::create(null, null, 20, 23, 55, 55);
        if(date('d') < 22){
            $firstday->subMonth()->subMonth();
            $lastday->subMonth();
        } else {
            $firstday->subMonth();
        }

        $treatments = Treatment::whereBetween('date', [$firstday, $lastday])
            ->whereIn('status_id', [3]) // 3 is 'Atendido'
            ->get();

        foreach ($treatments as $key => $treatment){
            $treatments[$key]->patient = Patient::findorfail($treatment->patient_id);
            $treatments[$key]->category = Category::findorfail($treatment->category_id);
            $treatments[$key]->status = Status::findorfail($treatment->status_id);
        }

        return $treatments;

    }

    public static function professionalCloseMonth($name){
        $firstday = Carbon::create(null, null, 21, 00, 00, 01);
        $lastday = Carbon::create(null, null, 20, 23, 55, 55);
        if(date('d') < 22){
            $firstday->subMonth()->subMonth();
            $lastday->subMonth();
        } else {
            $firstday->subMonth();
        }
        $professional = Professional::where('medilink','=',$name)->first();
        $treatments = Treatment::whereBetween('date', [$firstday, $lastday])
            ->whereIn('status_id', [3]) // 3 is 'Atendido'
            ->where('professional_id',$professional->id)
            ->get();

        foreach ($treatments as $key => $treatment){
            $treatments[$key]->patient = Patient::findorfail($treatment->patient_id);
            $treatments[$key]->category = Category::findorfail($treatment->category_id);
            $treatments[$key]->status = Status::findorfail($treatment->status_id);
        }

        return $treatments;

    }


}
