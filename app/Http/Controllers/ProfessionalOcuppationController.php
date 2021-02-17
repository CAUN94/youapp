<?php

namespace App\Http\Controllers;

use App\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalOcuppationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(!auth::user()->hasRole('admin')){
                abort(401);
        }
        if(auth::user()->hasRole('admin')){
            $actions = Action::professionalsCloseMonth();
            $summary = $this->summary($actions);
            foreach ($actions as $key => $action) {
                $actions[$key]->Prestación = $this->moneda_chilena($actions[$key]->Prestación);
                $actions[$key]->Abono = $this->moneda_chilena($actions[$key]->Abono);
            }
            $goal = 300;
            $percentage = round($summary['Total']*100/$goal,1);
            $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']);
            $summary['Abono'] = $this->moneda_chilena($summary['Abono']);
            return view('professionals.index',compact('actions','summary','goal','percentage'));
        }
    }

    public function show($name)
    {
        if(!auth::user()->hasRole('admin')){
                abort(401);
        }
        if(auth::user()->hasRole('admin')){
            $actions = Action::professionalCloseMonth($name);
            $summary = $this->summary($actions);
            foreach ($actions as $key => $action) {
                $actions[$key]->Prestación = $this->moneda_chilena($actions[$key]->Prestación);
                $actions[$key]->Abono = $this->moneda_chilena($actions[$key]->Abono);
            }
            $goal = 300;
            $percentage = round($summary['Total']*100/$goal,1);
            $remuneration = $this->moneda_chilena($summary['Prestación']*$this->coefficient($name));
            $summary['Prestación'] = $this->moneda_chilena($summary['Prestación']);
            $summary['Abono'] = $this->moneda_chilena($summary['Abono']);
            return view('professionals.show',compact('actions','summary','name','goal','percentage','remuneration'));
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

    public function coefficient($name)
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

        return $coff[$name];
    }
}
