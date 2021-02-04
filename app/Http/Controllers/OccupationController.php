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
            $actions = Action::close_month();

            $title = "Mes Cerrado del 21/".(date('m')-1)." al 20/".date('m');
        }
        elseif ($type == "last-week") {
            $actions = Action::last_week();
            $monday = date('d-m',strtotime("Monday last week"));
            $title = "Semana Vencida de Lunes a Domingo de la Semana del ".$monday;
        }
        elseif ($type == "month") {
            $actions = Action::month();
            $firstday = date('d-m',strtotime("first day of this month"));
            $title = "Mes Actual desde el ".$firstday;
        }
        else {
            return redirect('/');
        }

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary($actions,$values);

        return view('occupations.show',compact('actions','title','summary','type'));
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
}
