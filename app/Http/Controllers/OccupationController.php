<?php

namespace App\Http\Controllers;

use App\Action;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationController extends Controller
{
    public function occupation($type,$fday = Null,$lday = Null)
    {
        if($fday != Null or $lday != Null){
            return redirect('/');
        }
        if($type == "close"){
            $actions = Action::close_month();
            $title = "Mes Cerrado";
        }
        elseif ($type == "last-week") {
            $actions = Action::last_week();
            $title = "Semana Vencida";
        }
        elseif ($type == "month") {
            $actions = Action::month();
            $title = "Mes Actual";
        }
        else {
            return redirect('/');
        }

        $values = ['Atenciones','Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = $this->summary($actions,$values);

        return view('occupations.show',compact('actions','title','summary'));
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
