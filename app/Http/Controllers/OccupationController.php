<?php

namespace App\Http\Controllers;

use App\Category;
use App\Patient;
use App\Professional;
use App\Treatment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OccupationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function occupation($type)
    {
        if(!auth::user()->hasRole('admin')){
                abort(401);
        }

        if($type == "actual-month"){
            $firstday = Carbon::create(null, null, 21, 00, 00, 01);
            $lastday = Carbon::create(null, null, 20, 23, 55, 55);
            if(date('d') < 22){
                $firstday->subMonth();
            } else {
                $lastday->addMonth();
            }
            $diff = 4;
            $title = "Mes Actual del 21/".$firstday->month." al 20/".$lastday->month;
        }
        elseif($type == "last-month"){
            $firstday = Carbon::create(null, null, 21, 00, 00, 01);
            $lastday = Carbon::create(null, null, 20, 23, 55, 55);
            if(date('d') < 22){
                $firstday->subMonth()->subMonth();
                $lastday->subMonth();
            } else {
                $firstday->subMonth();
            }
            $diff = 4;
            $title = "Mes Vencido del 21/".$firstday->month." al 20/".$lastday->month;
        }
        elseif ($type == "last-week") {
            $firstday = Carbon::create(null,null,null,0,0,1)->subWeek()->startOfWeek();
            $lastday = Carbon::create(null,null,null,23,55,55)->subWeek()->startOfWeek()->addDay(6);
            $diff = 1;
            $title = "Semana Vencida de Lunes a Domingo de la Semana del ".$firstday->day."/".$firstday->month."/".$firstday->year ;
        }
        elseif ($type == "month") {
            $firstday = Carbon::create(null,null,null,0,0,1)->startOfMonth()->startOfWeek();
            $lastday = Carbon::create(null,null,null);
            $diff = 1;
            $title = "Mes Actual desde el ".$firstday->format('d-m-y');
        }
        else
        {
            return redirect('/');
        }


        $treatments = Treatment::ocuppation($firstday,$lastday);

        foreach ($treatments as $key => $treatment) {
            $professional = Professional::find($treatment->professional_id)->getUser();
            $treatment->professional = $professional['name']." ".$professional['lastnames'];
        }
        $goal = $diff*75;
        $categories = Category::countCategory($firstday,$lastday);

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary((array) $treatments,$values);
        foreach ($treatments as $key => $treatment) {
            $treatments[$key]->Prestación = $this->moneda_chilena($treatment->Prestación);
            $treatments[$key]->Abono = $this->moneda_chilena($treatment->Abono);
        }
        $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']);
        $summary['Abono'] = $this->moneda_chilena($summary['Abono']);

        $percentage = round($summary['Atenciones']*100/$goal,1);
        return view('occupations.show',compact('treatments','title','summary','type','percentage','goal','categories'));
    }

    public function form(Request $request)
    {
        if(!auth::user()->hasRole('admin')){
                abort(401);
        }
        if($request->firstday > $request->lastday){
            return redirect('/');
        }
        $type = Null;
        $firstday = Carbon::create($request->firstday);
        $lastday = Carbon::create($request->lastday);
        $diff = $firstday ->diffInWeeks($lastday);
        if($diff == 0){
            $diff = 0.75;
        }
        $title = "Ocupaciones del ".$request->firstday." al ".$request->lastday;

        $treatments = Treatment::ocuppation($firstday,$lastday);
        $goal = $diff*75;
        $categories = Category::countCategory($firstday,$lastday);
        foreach ($treatments as $key => $treatment) {
            $professional = Professional::find($treatment->professional_id)->getUser();
            $treatment->professional = $professional['name']." ".$professional['lastnames'];
        }

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary((array) $treatments,$values);
        foreach ($treatments as  $treatment) {
            $treatment = (array) $treatment;
            $treatment['Prestación'] = $this->moneda_chilena($treatment['Prestación']);
            $treatment['Abono'] = $this->moneda_chilena($treatment['Abono']);
        }
        $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']);
        $summary['Abono'] = $this->moneda_chilena($summary['Abono']);
        $percentage = round($summary['Atenciones']*100/$goal,1);
        return view('occupations.show',compact('treatments','title','summary','type','percentage','goal','categories'));
    }

    public function occupationprofessional($type)
    {
        if(!auth::user()->hasRole('professional')){
                abort(401);
        }

        if($type == "actual-month"){
            $firstday = Carbon::create(null, null, 21, 00, 00, 01);
            $lastday = Carbon::create(null, null, 20, 23, 55, 55);
            if(date('d') < 22){
                $firstday->subMonth();
            } else {
                $lastday->addMonth();
            }
            $diff = 4;
            $title = "Mes Actual del 21/".$firstday->month." al 20/".$lastday->month;
        }
        elseif($type == "last-month"){
            $firstday = Carbon::create(null, null, 21, 00, 00, 01);
            $lastday = Carbon::create(null, null, 20, 23, 55, 55);
            if(date('d') < 22){
                $firstday->subMonth()->subMonth();
                $lastday->subMonth();
            } else {
                $firstday->subMonth();
            }
            $diff = 4;
            $title = "Mes Vencido del 21/".$firstday->month." al 20/".$lastday->month;
        }
        elseif ($type == "last-week") {
            $firstday = Carbon::create(null,null,null,0,0,1)->subWeek()->startOfWeek();
            $lastday = Carbon::create(null,null,null,23,55,55)->subWeek()->startOfWeek()->addDay(6);
            $diff = 1;
            $title = "Semana Vencida de Lunes a Domingo de la Semana del ".$firstday->day."/".$firstday->month."/".$firstday->year ;
        }
        elseif ($type == "month") {
            $firstday = Carbon::create(null,null,null,0,0,1)->startOfMonth()->startOfWeek();
            $lastday = Carbon::create(null,null,null);
            $diff = 1;
            $title = "Mes Actual desde el ".$firstday->format('d-m-y');
        }
        else {
            return redirect('/');
        }
        $treatments = Treatment::ocuppation($firstday,$lastday,auth::user()->getProfessional()->id);
        foreach ($treatments as $key => $treatment) {
            $professional = Professional::find($treatment->professional_id)->getUser();
            $patient = Patient::find($treatment->patient_id);
            $treatment->professional = $professional['name']." ".$professional['lastnames'];
            $treatment->paciente = $patient['name']." ".$patient['lastnames'];
        }
        $goal = $diff*75;
        $categories = Category::countCategory($firstday,$lastday,auth::user()->getProfessional()->id);
        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary((array) $treatments,$values);

        $coff = $this->coefficient();
        foreach ($treatments as $key => $treatment) {
            $treatments[$key]->Prestación = $this->moneda_chilena($treatment->Prestación*$coff);
            $treatments[$key]->Abono = $this->moneda_chilena($treatment->Abono*$coff);
        }
        $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']*$coff);
        $summary['Abono'] = $this->moneda_chilena($summary['Abono']*$coff);
        $summary['Atenciones'] = count($treatments);
        $percentage = round($summary['Atenciones']*100/$goal,1);
        return view('occupations.show',compact('treatments','title','summary','type','percentage','goal','categories'));
    }

    public function formprofessional(Request $request)
    {
        $action = new Action();
        if($request->firstday > $request->lastday){
            return redirect('/');
        }
        $type = Null;
        $firstday = Carbon::create($request->firstday);
        $lastday = Carbon::create($request->lastday);
        $diff = $firstday ->diffInWeeks($lastday);
        if($diff == 0){
            $diff = 0.75;
        }
        $title = "Ocupaciones del ".$request->firstday." al ".$request->lastday;

        $actions = $action->occupation($firstday,$lastday,auth::user()->medilinkname);
        $goal = $diff*75;
        $categories = $action->category($firstday,$lastday,auth::user()->medilinkname);

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary($actions,$values);
        $coff = $this->coefficient();
        foreach ($actions as $key => $action) {
            $actions[$key]->Prestación = $this->moneda_chilena($actions[$key]->Prestación*$coff);
            $actions[$key]->Abono = $this->moneda_chilena($actions[$key]->Abono*$coff);
        }
        $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']*$coff);
        $summary['Abono'] = $this->moneda_chilena($summary['Abono']*$coff);

        $percentage = round($summary['Atenciones']*100/$goal,1);
        return view('occupations.show',compact('actions','title','summary','type','percentage','goal','categories'));
    }

    public function summary($treatment,$values)
    {
        $summary = [];
        foreach ($values as $key => $value) {
            $value_new = array_sum(array_column($treatment, $value));
            $summary[$value] = $value_new;
        }

        return $summary;
    }

    public function moneda_chilena($numero){
        $numero = (string)$numero;
        $puntos = floor((strlen($numero)-1)/3);
        $tmp = "";
        $pos = 1;
        for($i=strlen($numero)-1; $i>=0; $i--){
        $tmp = $tmp.substr($numero, $i, 1);
        if($pos%3==0 && $pos!=strlen($numero))
        $tmp = $tmp.".";
        $pos = $pos + 1;
        }
        $formateado = "$ ".strrev($tmp);
        return $formateado;
    }

    public function coefficient()
    {
        $coff = [
            'Klgo. Alonso Niklitschek Sanhueza' => 0.6,
            'Klgo. César Moya Calderón' => 0.32,
            'Klga. Daniella Vivallo Vera' => 0.45,
            'Renata Barchiesi Vitali' => 0.6,
            'Klgo. Iver Cristi' => 0.6,
            'Sofía Vitali Magasich' => 0.45,
            'Carolina Avilés Espinoza' => 0.7,
            'Mariano Neira Palomo' => 0.45,
            'Dr. Juan Manuel Guzmán Habinger' => 0.7,
            'Sara Tarifeño Ramos' => 1,
        ];

        return $coff[auth::user()->getProfessional()->medilink];
    }
}
