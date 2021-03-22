<?php

namespace App\Http\Controllers;

use App\Action;
use App\Patient;
use App\Treatment;
use Carbon\Carbon;
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
        if(auth::user()->hasRole('admin')){
            $professionalsOcuppation = Treatment::professionalsCloseMonth();
            $summary = $this->summary($professionalsOcuppation->toArray());
            foreach ($professionalsOcuppation as $key => $professionalOcuppation){
                $professionalsOcuppation[$key]->benefit = $this->moneda_chilena($professionalsOcuppation[$key]->benefit);
                $professionalsOcuppation[$key]->payment = $this->moneda_chilena($professionalsOcuppation[$key]->payment);
            }
            $goal = 300;
            $percentage = round(count($professionalsOcuppation->toArray())*100/$goal,1);
            $summary['benefit'] = $this->moneda_chilena($summary['benefit']);
            $summary['payment'] = $this->moneda_chilena($summary['payment']);
            $summary['Convenio'] = 0;
            $summary['Sin_Convenio'] = 0;
            $summary['Embajador'] = 0;
            foreach ($professionalsOcuppation->toArray() as $key => $occupation) {
                $prevision_value = $occupation['patient']->prevision;
                if($prevision_value != 'Sin Convenio' and $prevision_value != 'Embajador' and $prevision_value != 'Pro Bono'){
                    $summary['Convenio']++;
                }
                elseif ($prevision_value == 'Embajador' or $prevision_value == 'Pro Bono') {
                    $summary['Embajador']++;
                }
                else {
                    $summary['Sin_Convenio']++;
                }
            }
            // return $summary;
            return view('professionals.index',compact('professionalsOcuppation','summary','goal','percentage'));
        }
    }

    public function show($name)
    {
        if(!auth::user()->hasRole('admin')){
                abort(401);
        }
        if(auth::user()->hasRole('admin')){
            $professionalOcuppation = Treatment::professionalCloseMonth($name);
            $summary = $this->summary($professionalOcuppation->toArray());
            foreach ($professionalOcuppation as $key => $occupation){
                $professionalOcuppation[$key]->benefit = $this->moneda_chilena($professionalOcuppation[$key]->benefit);
                $professionalOcuppation[$key]->payment = $this->moneda_chilena($professionalOcuppation[$key]->payment);
            }
            $goal = 300;
            $percentage = round(count($professionalOcuppation->toArray())*100/$goal,1);
            $remuneration = $this->moneda_chilena($summary['benefit']*$this->coefficient($name));
            $summary['benefit'] = $this->moneda_chilena($summary['benefit']);
            $summary['payment'] = $this->moneda_chilena($summary['payment']);
            $summary['Convenio'] = 0;
            $summary['Sin_Convenio'] = 0;
            $summary['Embajador'] = 0;
            foreach ($professionalOcuppation->toArray() as $key => $occupation) {
                $prevision_value = $occupation['patient']->prevision;
                if($prevision_value != 'Sin Convenio' and $prevision_value != 'Embajador' and $prevision_value != 'Pro Bono'){
                    $summary['Convenio']++;
                }
                elseif ($prevision_value == 'Embajador' or $prevision_value == 'Pro Bono') {
                    $summary['Embajador']++;
                }
                else {
                    $summary['Sin_Convenio']++;
                }
            }
            return view('professionals.show',compact('professionalOcuppation','summary','name','goal','percentage','remuneration'));
        }
    }

    public function summary($array)
    {
        $summary = [];
        foreach (array_keys($array[0]) as $key => $value) {
            $value_new = array_sum(array_column($array, $value));
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
