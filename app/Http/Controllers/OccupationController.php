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
        if(!auth::user()->hasRole('admin')){
                abort(401);
        }
        $action = new Action();

        if($type == "actual-month"){
            $firstday = Carbon::create(null, null, 21, 00, 00, 01)->subMonth();
            $lastday = Carbon::create(null, null, 20, 23, 55, 55);
            $diff = 4;
            $title = "Mes Actual del 21/".$firstday->month." al 20/".$lastday->month;
        }
        elseif($type == "last-month"){
            $firstday = Carbon::create(null, null, 21, 00, 00, 01)->subMonth()->subMonth();
            $lastday = Carbon::create(null, null, 20, 23, 55, 55)->subMonth();
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
            $firstday = Carbon::create(null, null, 21, 00, 00, 01)->subMonth();
            $lastday = Carbon::create(null, null, 20, 23, 55, 55);
            $diff = 4;
            $title = "Mes Actual del 21/".$firstday->month." al 20/".$lastday->month;
        }
        elseif($type == "last-month"){
            $firstday = Carbon::create(null, null, 21, 00, 00, 01)->subMonth()->subMonth();
            $lastday = Carbon::create(null, null, 20, 23, 55, 55)->subMonth();
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

        foreach ($actions as $key => $action) {
            $actions[$key]->Prestación = $this->moneda_chilena($actions[$key]->Prestación);
            $actions[$key]->Abono = $this->moneda_chilena($actions[$key]->Abono);
        }


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

        foreach ($actions as $key => $action) {
            $actions[$key]->Prestación = $this->moneda_chilena($actions[$key]->Prestación);
            $actions[$key]->Abono = $this->moneda_chilena($actions[$key]->Abono);
        }

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
        $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']);
        $summary['Abono'] = $this->moneda_chilena($summary['Abono']);
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
}
