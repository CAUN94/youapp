<?php

namespace App\Http\Controllers;

use App\Action;
use App\Appointment;
use App\Payment;
use App\Treatment;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Http\Request;

class ScrapingController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function carbon()
    {
    	$date = Carbon::create(null, null, null)->subMonth()->subMonth()->format('Y-m-d');;
    	return $date;
    }

	public function appointments()
	{
		$client = new Client();
		$crawler = $client->request('GET', 'https://youjustbetter.softwaremedilink.com/reportesdinamicos');
		$form = $crawler->selectButton('Ingresar')->form();
		$form->setValues(['rut' => 'admin', 'password' => 'Pascual4900']);
		$crawler = $client->submit($form);
		$crawler = $client->request('GET', 'https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/citas');
		$array = $crawler->text();

		$array = substr($array,2,-2);
		$split = explode('},{', $array);

		$date = Carbon::create(null, null, null)->subYear()->format('Y-m-d');

		foreach ($split as $string)
		{
			$jsonobj = "{".$string."}";
			$value = json_decode($jsonobj, true);
			if($value["Fecha"] >= $date){
				$appointment = new Appointment();
				$appointment->Estado = $value["Estado"];
	            $appointment->Fecha = $value["Fecha"];
	            $appointment->Hora_inicio = $value["Hora inicio"];
	            $appointment->Hora_termino = $value["Hora termino"];
	            $appointment->Fecha_Generación = $value["Fecha Generación"];
	            $appointment->Tratamiento_Nr = $value["Atencion"];
	            $appointment->Profesional = $value["Profesional/Recurso"];
	            $appointment->Rut_Paciente = $value['Rut Paciente'];
	            $appointment->Nombre_paciente = $value['Nombre paciente'];
	            $appointment->Apellidos_paciente = $value['Apellidos paciente'];
	            $appointment->Mail = $value['E-mail'];
	            $appointment->Telefono = $value["Telefono"];
	            $appointment->Celular = $value["Celular"];
	            $appointment->Convenio = $value["Convenio"];
	            $appointment->Convenio_Secundario = $value["Convenio Secundario"];
	            $appointment->Generación_Presupuesto = $value["Generación Presupuesto"];
	            $appointment->Sucursal = $value["Sucursal"];
	            $appointment->save();
			}
		}
	    $Appointment = Appointment::noRepeat();
        $AppointmentId = array_column($Appointment ->toArray(), 'id');
        Appointment::whereNotIn('id', $AppointmentId)->delete();
        $update = Appointment::orderBy('id', 'desc')->first();
        $update->updated_at = Carbon::now();
        $update->save();

		return back()->with('message-appointments', 'Actualizado');
	}

	public function actions()
	{
		$client = new Client();
		$crawler = $client->request('GET', 'https://youjustbetter.softwaremedilink.com/reportesdinamicos');
		$form = $crawler->selectButton('Ingresar')->form();
		$form->setValues(['rut' => 'admin', 'password' => 'Omnium123']);
		$crawler = $client->submit($form);

		$first = strval(Carbon::create(null, null, null)->subMonth()->subMonth()->format('Y-m-d'));
		$last = strval(Carbon::create(null, null, null)->addMonth()->format('Y-m-d'));
		$url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/listado_acciones?filters%5Bsucursal%5D%5Bstatus%5D=activated&filters%5Bsucursal%5D%5Bvalue%5D=1&filters%5Bfecha_inicio%5D%5Bstatus%5D=activated&filters%5Bfecha_inicio%5D%5Bvalue%5D=".$first."&filters%5Bfecha_fin%5D%5Bstatus%5D=activated&filters%5Bfecha_fin%5D%5Bvalue%5D=".$last."";
		$crawler = $client->request('GET', $url);
		$array = $crawler->text();

		$date = Carbon::create(null, null, null)->subMonth()->subMonth()->format('Y-m-d');

		$array = substr($array,2,-2);

		$split = explode('},{', $array);
		foreach ($split as $string)
		{
			$jsonobj = "{".$string."}";

			$value = json_decode($jsonobj, true);
			if($value["Fecha Realizacion"] >= $date){
				$action = new Action();
	            $action->Sucursal = $value['Sucursal'];
	            $action->Nombre = $value['Nombre paciente'];
	            $action->Apellido = $value['Apellidos paciente'];
	            $action->Categoria_Nr = $value['Id. Categoria'];
	            $action->Categoria_Nombre = $value['Nombre Categoria'];
	            $action->Tratamiento_Nr = $value['# Tratamiento'];
	            $action->Profesional = $value['Realizado por'];
	            $action->Estado = $value['Estado de la consulta'];
	            $action->Convenio = $value['Nombre Convenio'];
	            $action->Prestacion_Nr = $value['Id. Prestacion'];
	            $action->Prestacion_Nombre = $value['Nombre Prestacion'];
	            $action->Pieza_Tratada = $value['Pieza Tratada'];
	            $action->Fecha_Realizacion = $value['Fecha Realizacion'];
	            $action->Precio_Prestacion = $value['Precio Prestación'];
	            $action->Abonoo = $value['Abonado'];
	            $action->Total = $value['Total a pagar Profesional'];
	            $action->save();
			}
		}
		$Action = Action::noRepeats();
        $ActionId = array_column($Action ->toArray(), 'id');
        Action::whereNotIn('id', $ActionId)->delete();
        $update = Action::orderBy('id', 'desc')->first();
        $update->updated_at = Carbon::now();
        $update->save();

		return back()->with('message-actions', 'Actualizado');
	}

	public function treatments()
	{
		$client = new Client();
		$crawler = $client->request('GET', 'https://youjustbetter.softwaremedilink.com/reportesdinamicos');
		$form = $crawler->selectButton('Ingresar')->form();
		$form->setValues(['rut' => 'admin', 'password' => 'Omnium123']);
		$crawler = $client->submit($form);

		$url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/resumen_tratamientos_saldos";
		$crawler = $client->request('GET', $url);
		$array = $crawler->text();
		$array = substr($array,2,-2);
		$split = explode('},{', $array);
		foreach ($split as $string)
		{
			$jsonobj = "{".$string."}";
			$value = json_decode($jsonobj,true);
			if($value["Atencion"]>6000){
				$treatment = new Treatment();
				$treatment->Ficha = $value["# Ficha"];
				$treatment->Nombre = $value["Nombre paciente"];
				$treatment->Apellidos = $value["Apellidos paciente"];
				$treatment->Atencion = $value["Atencion"];
				$treatment->Profesional = $value["Profesional"];
				$treatment->TotalAtencion = $value["Total Atencion"];
				$treatment->TotalLaboratorios = $value["Total Laboratorios"];
				$treatment->TotalRealizado = $value["Total Realizado"];
				$treatment->TotalAbonado = $value["Total Abonado"];
				$treatment->Avance = $value["Saldo por avance"];
				$treatment->Global = $value["Saldo Global"];
				$treatment->Proxima_cita = $value["Proxima cita"];
				$treatment->save();
			}
		}
		$Treatment = Treatment::noRepeats();
        $TreatmentId = array_column($Treatment->toArray(), 'id');
        Treatment::whereNotIn('id', $TreatmentId)->delete();
        $update = Treatment::orderBy('id', 'desc')->first();
        $update->updated_at = Carbon::now();
        $update->save();
		return back()->with('message-treatments', 'Actualizado');
	}

	public function payments()
	{
		$client = new Client();
		$crawler = $client->request('GET', 'https://youjustbetter.softwaremedilink.com/reportesdinamicos');
		$form = $crawler->selectButton('Ingresar')->form();
		$form->setValues(['rut' => 'admin', 'password' => 'Omnium123']);
		$crawler = $client->submit($form);

		$url = "https://youjustbetter.softwaremedilink.com/reportesdinamicos/reporte/pagos_pacientes";
		$crawler = $client->request('GET', $url);
		$array = $crawler->text();
		$array = substr($array,2,-2);
		$split = explode('},{', $array);

		$date = Carbon::create(null, null, null)->subMonth()->subMonth()->format('Y-m-d');

		foreach ($split as $string)
		{
			$jsonobj = "{".$string."}";
			$value = json_decode($jsonobj,true);
			$payment = New Payment;
			if($value['Fecha de recepción'] >= $date){
				$payment->Atencion = $value['Atencion'];
				$payment->Profesional = $value['Profesional atencion'];
				$payment->Especialidad = $value['Especialidad Profesional atencion'];
				$payment->Pago_Nr = $value['# Pago'];
				$payment->Fecha = $value['Fecha de recepción'];
				$payment->Rut = $value['Rut paciente'];
				$payment->Nombre = $value['Nombre'];
				$payment->Apellidos = $value['Apellidos'];
				$payment->Tipo_Paciente = $value['Tipo Paciente'];
				$payment->Convenio = $value['Convenio'];
				$payment->Convenio_Secundario = $value['Convenio Secundario'];
				$payment->Boleta_Nr = $value['# Boleta'];
				$payment->Total = $value['Total pago'];
				$payment->Asociado = $value['Total asociado a atencion'];
				$payment->Medio = $value['Medio de pago'];
				$payment->Banco = $value['Banco'];
				$payment->RutBanco = $value['Rut'];
				$payment->Cheque = $value['# Ref Cheque'];
				$payment->Vencimiento = $value['Vencimiento'];
				$payment->Generado = $value['Generado'];
				$payment->save();
			}

		}
		$payment = payment::noRepeats();
        $paymentId = array_column($payment->toArray(), 'id');
        payment::whereNotIn('id', $paymentId)->delete();
        $update = payment::orderBy('id', 'desc')->first();
        $update->updated_at = Carbon::now();
        $update->save();
		return back()->with('message-payments', 'Actualizado');
	}
}
