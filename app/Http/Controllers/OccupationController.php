<?php

namespace App\Http\Controllers;

use App\Action;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OccupationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function occupation($type)
    {
        $action = new Action();

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

        $actions = $action->occupation($firstday,$lastday);
        $goal = $diff*75;
        $categories = $action->category($firstday,$lastday);

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary($actions,$values);
        foreach ($actions as $key => $action) {
            $actions[$key]->Prestación = $this->moneda_chilena($actions[$key]->Prestación);
            $actions[$key]->Abono = $this->moneda_chilena($actions[$key]->Abono);
        }
        $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']);
        $summary['Abono'] = $this->moneda_chilena($summary['Abono']);

        $percentage = round($summary['Atenciones']*100/$goal,1);
        return view('occupations.show',compact('actions','title','summary','type','percentage','goal','categories'));
    }

    public function form(Request $request)
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

        $actions = $action->occupation($firstday,$lastday);
        $goal = $diff*75;
        $categories = $action->category($firstday,$lastday);

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary($actions,$values);
        foreach ($actions as $key => $action) {
            $actions[$key]->Prestación = $this->moneda_chilena($actions[$key]->Prestación);
            $actions[$key]->Abono = $this->moneda_chilena($actions[$key]->Abono);
        }
        $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']);
        $summary['Abono'] = $this->moneda_chilena($summary['Abono']);
        $percentage = round($summary['Atenciones']*100/$goal,1);
        return view('occupations.show',compact('actions','title','summary','type','percentage','goal','categories'));
    }

    public function occupationprofessional($type)
    {
        if(!auth::user()->hasRole('professional')){
                abort(401);
        }
        $action = new Action();

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

        $actions = $action->occupation($firstday,$lastday,auth::user()->medilinkname);
        $goal = $diff*75;
        $categories = $action->category($firstday,$lastday,auth::user()->medilinkname);

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary($actions,$values);
        $percentage = round($summary['Atenciones']*100/$goal,1);

        $coff = $this->coefficient();
        foreach ($actions as $key => $action) {
            $actions[$key]->Prestación = $this->moneda_chilena($actions[$key]->Prestación*$coff);
            $actions[$key]->Abono = $this->moneda_chilena($actions[$key]->Abono*$coff);
        }

        $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']*$coff);
        $summary['Abono'] = $this->moneda_chilena($summary['Abono']*$coff);


        return view('occupations.show',compact('actions','title','summary','type','percentage','goal','categories'));
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

    public function summary($actions,$values)
    {
        $summary = [];
        foreach ($values as $key => $value) {
            $value_new = array_sum(array_column($actions, $value));
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
            'Alonso Niklitschek Sanhueza' => 0.6,
            'César Moya Calderón' => 0.32,
            'Daniella Vivallo Vera' => 0.45,
            'Juan Manuel Guzmán Habinger' => 0.7,
            'Iver Cristi Sánchez' => 0.6,
            'Renata Barchiesi Vitali' => 0.6,
            'Sofía Vitali Magasich' => 0.45,
            'Carolina Avilés Espinoza' => 0.7,
            'Mariano Neira Palomo' => 0.45,
            'Sara Tarifeño Ramos' => 1,
            'María Jesús Martinez León' => 0.45,
            'Melissa Ross Guerra' => 0.55,
            'Cristina Valenzuela Rubilar' => 0.42,
            'Adolfo Lopez Macera' => 0.46,
            'Diego Ignacio Contreras Briceño' => 0.7,
            'You Entrenamiento' => 1,
        ];

        return $coff[auth::user()->medilinkname];
    }
}
