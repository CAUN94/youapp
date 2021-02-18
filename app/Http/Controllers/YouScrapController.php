<?php

namespace App\Http\Controllers;

use App\Action;
use App\Appointment;
use App\Benefit;
use App\Category;
use App\Patient;
use App\Payment;
use App\Professional;
use App\Status;
use App\Sucursal;
use App\Treatment;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Http\Request;

class YouScrapController extends Controller
{
	// public function __construct()
 //    {
 //        $this->middleware('auth');
 //    }

	public function scrap($url){
		$client = new Client();
		$crawler = $client->request('GET', 'https://youjustbetter.softwaremedilink.com/reportesdinamicos');
		$form = $crawler->selectButton('Ingresar')->form();
		$form->setValues(['rut' => 'admin', 'password' => 'Omnium123']);
		$crawler = $client->submit($form);
		$crawler = $client->request('GET', $url);
		$array = $crawler->text();
		$array = substr($array,2,-2);
		return explode('},{', $array);
	}

	public function actions()
	{
		ini_set('max_execution_time',12000);
		$first = strval(Carbon::create(null, null, null)->subYear()->subYear()->format('Y-m-d'));
		$last = strval(Carbon::create(null, null, null)->addMonth()->format('Y-m-d'));

		$url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/listado_acciones?filters%5Bsucursal%5D%5Bstatus%5D=activated&filters%5Bsucursal%5D%5Bvalue%5D=1&filters%5Bfecha_inicio%5D%5Bstatus%5D=activated&filters%5Bfecha_inicio%5D%5Bvalue%5D=".$first."&filters%5Bfecha_fin%5D%5Bstatus%5D=activated&filters%5Bfecha_fin%5D%5Bvalue%5D=".$last."";

		$actions = $this->scrap($url);

		foreach ($actions as $string)
		{
			$jsonobj = "{".$string."}";
			$value = json_decode($jsonobj, true);

			$category = Category::updateOrCreate(
			    ['name' => $value["Id. Categoria"]],
			    [
			    	'name' => $value["Id. Categoria"],
			    	'description' => $value["Nombre Categoria"]
			    ]
			);


			$professional = Professional::getProfessionalMedilink($value["Realizado por"]);
			if (! $category->professionals->contains($professional->id)) {
			    $category->professionals()->attach($professional->id,['percentage' => 1]);
			}


			if($value["Precio Prestación"] != 0 and $value["Nombre Convenio"] == "Sin Convenio"){
				$benefit = Benefit::updateOrCreate(
					[
						'code' => $value["Nombre Prestacion"],
				    ],
				    [
				    	'name' => $value["Id. Prestacion"],
						'price' => $value["Precio Prestación"],
						'description' => $value["# Tratamiento"],
						'category_id' => $category->id,
				    ]
				);
			}


			$sucursal = Sucursal::updateOrCreate(
				[ 'name' => $value["Sucursal"]],
				[
				'address' => "Av. Apoquindo 4900, Local 7 y 8, Las Condes, Región Metropolitana",
				'capacity' => 20,
				'type' => 'Santiago'
				]
			);
			if (is_null($value["Estado de la consulta"])){
				$value["Estado de la consulta"] = 'Vacio';
			}
			$status = Status::updateOrCreate(
				[ 'name' => $value["Estado de la consulta"] ],
				[
					'color' => $value["# Tratamiento"]
				]
			);

			$treatment = Treatment::updateOrCreate(
				['number' => $value["# Tratamiento"] ],
				[
					'number' => $value["# Tratamiento"],
					'date' => $value["Fecha Realizacion"],
					'benefit' => null, #update
					'payment' => null, #update
					'bank' => null, #update
					'method' => null, #update
					'boucher_nr' => null, #update
					'referenc' => null, #update
					'type' => null, #update
					'duration' => 6000,
					'health_record' => 'Not Yet',
					'patient_id' => Patient::where('rut','1-9')->first()->id, #update
					'status_id' => $status->id,
					'sucursal_id' => $sucursal->id,
					'professional_category_id' => $category->pivot($professional->id)->id,
				]
			);
			// if (! $treatment->benefits->contains($benefit->id)) {
			//     $treatment->benefits()->attach($benefit->id);
			// }
		}

		$url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/citas?filters%5Bsucursal%5D%5Bstatus%5D=activated&filters%5Bsucursal%5D%5Bvalue%5D=1&filters%5Bfecha_inicio%5D%5Bstatus%5D=activated&filters%5Bfecha_inicio%5D%5Bvalue%5D=".$first."&filters%5Bfecha_fin%5D%5Bstatus%5D=activated&filters%5Bfecha_fin%5D%5Bvalue%5D=".$last."";

		$appointments = $this->scrap($url);

		foreach ($appointments as $string)
		{
			$jsonobj = "{".$string."}";
			$value = json_decode($jsonobj, true);
			$patient = Patient::updateOrCreate(
				['rut' =>  $value["Rut Paciente"]],
				[
					'prevision' =>  is_null($value["Convenio"]) ? 'Sin Convenio' : $value["Convenio"],
					'genre' =>  'Not Specified',
					'email' =>  $value["E-mail"],
					'phone' =>  substr((str_replace(' ', '', $value["Celular"])),-8),
					'type' =>  is_null($value["Tipo Paciente"]) ? 'Normal' : $value["Tipo Paciente"]
				]
			);
		}

		// $url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/resumen_tratamientos_saldos?filters%5Bsucursal%5D%5Bstatus%5D=activated&filters%5Bsucursal%5D%5Bvalue%5D=1&filters%5Bfecha_inicio%5D%5Bstatus%5D=activated&filters%5Bfecha_inicio%5D%5Bvalue%5D=".$first."&filters%5Bfecha_fin%5D%5Bstatus%5D=activated&filters%5Bfecha_fin%5D%5Bvalue%5D=".$last."";

		// $treatments = $this->scrap($url);

		// foreach ($treatments as $string){
		// 	$jsonobj = "{".$string."}";
		// 	$value = json_decode($jsonobj, true);
		// 	$treatment = Treatment::updateOrCreate();

		// }

		return 'You did it';
	}
}
