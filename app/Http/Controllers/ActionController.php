<?php

namespace App\Http\Controllers;

use App\Action;
use App\Http\Controllers\Controller;
use App\Imports\ActionImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ActionController extends Controller
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
        $data = Excel::toArray(new ActionImport(), $request->file('excel'));
        foreach ($data[0] as $key => $value) {
            $action = new Action([$value]);
            $action->Sucursal = $value['sucursal'];
            $action->Nombre = $value['nombre_paciente'];
            $action->Apellido = $value['apellidos_paciente'];
            $action->Categoria_Nr = $value['id_categoria'];
            $action->Categoria_Nombre = $value['nombre_categoria'];
            $action->Tratamiento_Nr = $value['tratamiento'];
            $action->Profesional = $value['realizado_por'];
            $action->Estado = $value['estado_de_la_consulta'];
            $action->Convenio = $value['nombre_convenio'];
            $action->Prestacion_Nr = $value['id_prestacion'];
            $action->Prestacion_Nombre = $value['nombre_prestacion'];
            $action->Pieza_Tratada = $value['pieza_tratada'];
            $action->Fecha_Realizacion = $value['fecha_realizacion'];
            $action->Precio_Prestacion = $value['precio_prestacion'];
            $action->Abonoo = $value['abonado'];
            $action->Total = $value['total_a_pagar_profesional'];
            $action->save();
        }
        $Action = Action::groupBy('Sucursal','Nombre','Apellido','Categoria_Nr','Categoria_Nombre','Tratamiento_Nr','Profesional','Estado','Convenio','Prestacion_Nr','Prestacion_Nombre','Pieza_Tratada','Fecha_Realizacion','Precio_Prestacion','Abonoo','Total')->get();
        $ActionId = array_column($Action ->toArray(), 'id');
        Action::whereNotIn('id', $ActionId)->delete();
        $update = Action::orderBy('id', 'desc')->first();
        $update->updated_at = Carbon::now();
        $update->save();


        return back()->with('message-actions', 'Actualizado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function show(Action $action)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function edit(Action $action)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Action $action)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Action $action)
    {
        //
    }
}
