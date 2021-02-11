<?php

namespace App\Http\Controllers;

use App\Action;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function occupation($type,$fday = Null,$lday = Null)
    {
        if($fday != Null or $lday != Null){
            return redirect('/');
        }
        if($type == "close"){
            $array = Action::close_month();
            $title = "Mes Cerrado del 21/".(date('m')-1)." al 20/".date('m');
        }
        elseif ($type == "last-week") {
            $array = Action::last_week();
            $monday = date('d-m',strtotime("Monday last week"));
            $title = "Semana Vencida de Lunes a Domingo de la Semana del ".$monday;
        }
        elseif ($type == "month") {
            $array = Action::month();
            $firstday = date('d-m',strtotime("first day of this month"));
            $title = "Mes Actual desde el ".$firstday;
        }
        else {
            return redirect('/');
        }

        $actions = $array['actions'];
        $goal = $array['weeks']*75;
        $categories = $array['categories'];

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary($actions,$values);
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
