<?php

namespace App\Http\Controllers;

use App\Benefit;
use App\Category;
use App\Patient;
use App\Professional;
use App\Status;
use App\Sucursal;
use App\Treatment;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Http\Request;

class YouScrapController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	public function appointment()
	{
		ini_set('max_execution_time',12000);
		$first = strval(Carbon::create(null, null, null)->subWeek()->format('Y-m-d'));
		// $first = '2019-01-01 00:00:00';
		$last = strval(Carbon::create(null, null, null)->addMonth()->format('Y-m-d'));
		$this->appointments($first,$last);

		return back()->with(
			['you-update' => 'Actualizado'],
		);

	}

	public function categories()
	{
		ini_set('max_execution_time',12000);

		$first = strval(Carbon::create(null, null, null)->subWeek()->format('Y-m-d'));
		// $first = '2019-01-01 00:00:00';
		$last = strval(Carbon::create(null, null, null)->addMonth()->format('Y-m-d'));
		$this->categories_benefits($first,$last);

		return back()->with(
			['you-update' => 'Actualizado'],
		);
	}

	public function treatment()
	{
		ini_set('max_execution_time',12000);

		$first = strval(Carbon::create(null, null, null)->subWeek()->format('Y-m-d'));
		// $first = '2019-01-01 00:00:00';
		$last = strval(Carbon::create(null, null, null)->addMonth()->format('Y-m-d'));
		$this->treatments($first,$last);

		return back()->with(
			['you-update' => 'Actualizado'],
		);
	}

	public function payment()
	{
		ini_set('max_execution_time',12000);

		$first = strval(Carbon::create(null, null, null)->subWeek()->format('Y-m-d'));
		// $first = '2019-01-01 00:00:00';
		$last = strval(Carbon::create(null, null, null)->addMonth()->format('Y-m-d'));
		$this->payments($first,$last);

		return back()->with(
			['you-update' => 'Actualizado'],
		);
	}

	public function appointments($first,$last)
	{
		$url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/citas?sort_by=Atencion%5Bfilters%5Bsucursal%5D%5Bstatus%5D=activated&filters%5Bsucursal%5D%5Bvalue%5D=1&filters%5Bfecha_inicio%5D%5Bstatus%5D=activated&filters%5Bfecha_inicio%5D%5Bvalue%5D=".$first."&filters%5Bfecha_fin%5D%5Bstatus%5D=activated&filters%5Bfecha_fin%5D%5Bvalue%5D=".$last."";
		// $url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/citas";

		$appointments = $this->scrap($url);

		$array = array();
		foreach ($appointments  as $key => $value) {
			$jsonobj = "{".$value."}";
			$jsonobj = json_decode($jsonobj,true);
			$array[] = $jsonobj;
		}

		usort($array, function($a, $b) {
		    return $a['#'] <=> $b['#'];
		});

		foreach ($array as $value)
		{
			$patient = Patient::updateOrCreate(
				['rut' =>  $value["Rut Paciente"]],
				[
					'name' => $value["Nombre paciente"],
					'lastnames' => $value["Apellidos paciente"],
					'genre' =>  'Not Specified',
					'prevision' =>  is_null($value["Convenio"]) ? 'Sin Convenio' : $value["Convenio"],
					'genre' =>  'Not Specified',
					'email' =>  $value["E-mail"],
					'phone' =>  substr((str_replace(' ', '', $value["Celular"])),-8),
					'type' =>  is_null($value["Tipo Paciente"]) ? 'Normal' : $value["Tipo Paciente"]
				]
			);

			$status = Status::updateOrCreate(
				[ 'name' => $value["Estado"] ],
				[
					'color' => '#ffffff'
				]
			);

			$sucursal = Sucursal::updateOrCreate(
				[ 'name' => $value["Sucursal"]],
				[
				'address' => "Av. Apoquindo 4900, Local 7 y 8, Las Condes, Región Metropolitana",
				'capacity' => 20,
				'type' => 'Santiago'
				]
			);

			$patient = Patient::rutSearch($value["Rut Paciente"]);
			$sucursal = Sucursal::searchName($value["Sucursal"]);
			$status = Status::searchState($value["Estado"]);
			$professional = Professional::getProfessionalMedilink($value["Profesional/Recurso"]);

			$treatments = Treatment::updateOrCreate(
				[ 'number' => $value["Atencion"]],
				[
					'status_id' => $status->id,
					'date' => $value["Fecha"],
					'hour' => $value["Hora inicio"],
					'minutes' => (strtotime($value["Hora termino"]) - strtotime($value["Hora inicio"]))/60,
					'health_record' => 'Not available',
					'patient_id' => $patient->id,
					'sucursal_id' => $sucursal->id,
				]
			);
		}
	}

	public function categories_benefits($first,$last)
	{
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
		}

		foreach ($actions as $string)
		{
			$jsonobj = "{".$string."}";
			$value = json_decode($jsonobj, true);

			$sucursal = Sucursal::searchName($value["Sucursal"]);
			$status = Status::searchState($value["Estado de la consulta"]);
			$category = Category::where('description',$value["Nombre Categoria"])->first();
			$professional = Professional::getProfessionalMedilink($value["Realizado por"]);

			$treatments = Treatment::where('number', $value["# Tratamiento"])->first();
			if ($treatments != null) {
				$update = array();
				if($value["Fecha Realizacion"] != null){
					$update['date'] = $value["Fecha Realizacion"];
				}
				if ($status != Null){
					$update['status_id'] = $status->id;
				}
				if ($sucursal != Null){
					$update['sucursal_id'] = $sucursal->id;
				}
				if ($category != Null){
					$update['category_id'] = $category->id;
				}
				if ($professional != Null){
					$update['professional_id'] = $professional->id;
				}
			    $treatments->update($update);
			} else {
				$treatments = new Treatment;
				$treatments->number = $value["# Tratamiento"];
				$treatments->date = $value["Fecha Realizacion"];
				$treatments->health_record = 'Not available';
				if ($status != Null){
					$treatments->status_id = $status->id;
				}
				else{
					$treatments->status_id = 5;
				}
				if ($sucursal != Null){
					$treatments->sucursal_id = $sucursal->id;
				}
				if ($category != Null){
					$treatments->category_id = $category->id;
				}
				if ($professional != Null){
					$treatments->professional_id = $professional->id;
				}
				$treatments->save();
			}

		}

	}

	public function treatments($first,$last)
	{
		$url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/resumen_tratamientos_saldos?filters%5Bsucursal%5D%5Bstatus%5D=activated&filters%5Bsucursal%5D%5Bvalue%5D=1&filters%5Bfecha_inicio%5D%5Bstatus%5D=activated&filters%5Bfecha_inicio%5D%5Bvalue%5D=".$first."&filters%5Bfecha_fin%5D%5Bstatus%5D=activated&filters%5Bfecha_fin%5D%5Bvalue%5D=".$last."";

		$treatments = $this->scrap($url);



		foreach ($treatments as $string){
			$jsonobj = "{".$string."}";
			$value = json_decode($jsonobj, true);
			$professional = Professional::getProfessionalMedilink($value["Profesional"]);
			$treatments = Treatment::where('number', $value["Atencion"])->first();
			if ($treatments !== null) {
				$update = array();
				if ($professional != Null){
					$update['professional_id'] = $professional->id;
				}
				$update['benefit'] = $value["Total Atencion"];
				$update['payment'] = $value["Total Abonado"];
			    $treatments->update($update);
			}
		}
	}

	public function payments($first,$last)
	{
		$url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/pagos_pacientes?filters%5Bsucursal%5D%5Bstatus%5D=activated&filters%5Bsucursal%5D%5Bvalue%5D=1&filters%5Bfecha_inicio%5D%5Bstatus%5D=activated&filters%5Bfecha_inicio%5D%5Bvalue%5D=".$first."&filters%5Bfecha_fin%5D%5Bstatus%5D=activated&filters%5Bfecha_fin%5D%5Bvalue%5D=".$last."";

		$payments = $this->scrap($url);

		foreach ($payments as $string){
			$jsonobj = "{".$string."}";
			$value = json_decode($jsonobj, true);

			$professional = Professional::getProfessionalMedilink($value["Profesional atencion"]);
			$patient = Patient::where('rut',$value["Rut paciente"])->first();
			$category = Category::where('description',$value["Especialidad Profesional atencion"])->first();
			$treatments = Treatment::where('number', $value["Atencion"])->first();
			if ($treatments != null) {
				$update = array();
				if ($professional != Null){
					$update['professional_id'] = $professional->id;
				}
				if ($category != Null){
					$update['category_id'] = $category->id;
				}
				if ($patient != Null){
					$update['patient_id'] = $patient->id;
				}
				$update['payment'] = $value["Total pago"];
				$update['bank'] = $value["Banco"];
				$update['method'] = $value["Medio de pago"];
				$update['boucher_nr'] = $value["# Boleta"];
				$update['reference'] = $value["# Ref Cheque"];

			    $treatments->update($update);
			}
		}
	}

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
}
