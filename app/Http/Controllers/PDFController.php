<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function download($nr)
	{
		$now = Carbon::now()->format('d-m-Y');;
		$patient = Appointment::tomorrow_appoiment($nr);
		$patient = $patient[0];

		if ($patient ->Profesional == 'Internos You'){
			$professional = User::where('medilinkname','Klgo. Alonso Niklitschek Sanhueza')->first();
		}
		else {
			$professional = User::where('medilinkname',$patient->Profesional)->first();
		}

		$pdf = PDF::loadView('layouts.pdf',compact('patient','professional','now'));
	    return $pdf->stream('mi-archivo.pdf');
	}
}
