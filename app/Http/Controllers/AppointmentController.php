<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Imports\AppointmentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Excel::toArray(new AppointmentImport(), $request->file('excel'));

        foreach ($data[0] as $key => $value) {
            // return var_dump($value);
            $appointment = new Appointment();
            $appointment->Estado = $value['estado'];
            $appointment->Fecha = $value['fecha'];
            $appointment->Hora_inicio = $value['hora_inicio'];
            $appointment->Hora_termino = $value['hora_termino'];
            $appointment->Fecha_Generación = $value['fecha_generacion'];
            $appointment->Tratamiento_Nr = $value['atencion'];
            $appointment->Profesional = $value['profesionalrecurso'];
            $appointment->Rut_Paciente = $value['rut_paciente'];
            $appointment->Nombre_paciente = $value['nombre_paciente'];
            $appointment->Apellidos_paciente = $value['apellidos_paciente'];
            $appointment->Mail = $value['e_mail'];
            $appointment->Telefono = $value['telefono'];
            $appointment->Celular = $value['celular'];
            $appointment->Convenio = $value['convenio'];
            $appointment->Convenio_Secundario = $value['convenio_secundario'];
            $appointment->Generación_Presupuesto = $value['generacion_presupuesto'];
            $appointment->Sucursal = $value['sucursal'];
            $appointment->save();;
        }
        $Action = Appointment::groupBy('Estado','Fecha','Hora_inicio','Hora_termino','Fecha_Generación','Tratamiento_Nr','Profesional','Rut_Paciente','Nombre_paciente','Apellidos_paciente','Mail','Telefono','Celular','Convenio','Convenio_Secundario','Generación_Presupuesto','Sucursal')->get();
        $ActionId = array_column($Action ->toArray(), 'id');
        Appointment::whereNotIn('id', $ActionId)->delete();
        return back()->with('message-appointments', 'Actualizado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
