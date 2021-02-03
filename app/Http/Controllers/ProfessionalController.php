<?php

namespace App\Http\Controllers;

use App\Action;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function index()
    {
    	$actions = Action::professionalsCloseMonth();
    	$summary = $this->summary($actions);
    	return view('professionals.index',compact('actions','summary'));
    }

    public function show($name)
    {
    	$actions = Action::professionalCloseMonth($name);
    	$summary = $this->summary($actions);
    	return view('professionals.show',compact('actions','summary','name'));
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
        return $summary;
    }
}
