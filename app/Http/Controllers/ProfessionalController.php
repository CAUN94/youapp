<?php

namespace App\Http\Controllers;

use App\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(auth::user()->hasRole('admin')){
            $actions = Action::professionalsCloseMonth();
            $summary = $this->summary($actions);
            $goal = 300;
            $percentage = round($summary['Total']*100/$goal,1);
            return view('professionals.index',compact('actions','summary','goal','percentage'));
        }
    }

    public function show($name)
    {
        if(auth::user()->hasRole('admin')){
            $actions = Action::professionalCloseMonth($name);
            $summary = $this->summary($actions);
            $goal = 300;
            $percentage = round($summary['Total']*100/$goal,1);
            return view('professionals.show',compact('actions','summary','name','goal','percentage'));
        }
        if(auth::user()->hasRole('professional')){
            if(auth::user()->medilinkname != $name){
                abort(401);
            }
            $actions = Action::professionalCloseMonth($name);
            $summary = $this->summary($actions);
            $goal = 300;
            $percentage = round($summary['Total']*100/$goal,1);
            return view('professionals.show',compact('actions','summary','name','goal','percentage'));
        }

    }

    public function summary($actions)
    {
    	$values = ['Convenio','Sin_Convenio','Embajador','Prestación','Abono'];
        $summary = [];
        $summary['Total'] = 0;
        $summary['Convenio'] = 0;
        $summary['Sin_Convenio'] = 0;
        $summary['Embajador'] = 0;
        $summary['Prestación'] = 0;
        $summary['Abono'] = 0;

        foreach ($actions as $key => $action) {
        	$summary['Total'] += 1;
        	if($action->Convenio_Nombre != 'Sin Convenio' and $action->Convenio_Nombre != 'Embajador' and $action->Convenio_Nombre != 'Pro Bono'){
        		$summary['Convenio'] +=1;
        	}
        	elseif ($action->Convenio_Nombre == 'Sin Convenio') {
        		$summary['Sin_Convenio'] +=1;
        	}
        	elseif ($action->Convenio_Nombre = 'Embajador' or $action->Convenio_Nombre = 'Pro Bono') {
        		$summary['Embajador'] +=1;
        	}
	        $summary['Prestación'] += $action->Prestación;
	        $summary['Abono'] += $action->Abono;
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
