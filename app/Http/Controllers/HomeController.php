<?php

namespace App\Http\Controllers;

use App\Action;
use App\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $action_last = Action::last_register();
        $appointment_last = Appointment::last_register();
        return view('home',compact('action_last','appointment_last'));
    }

     public function action()
    {
        // $actions = Action::all()->sortByDesc('id');
        // return view('actions/index',compact('actions'));
    }

    public function appointment()
    {
        // $appointments = Appointment::all()->sortByDesc('id');
        // return view('appointments/index',compact('appointments'));
    }

    public function panel()
    {
        $pacientes = DB::table('appointments')->groupBy('Rut_Paciente')->orderBy('Fecha_Generación','desc')->get();
        return view('you-wsp/index',compact('pacientes'));
    }

    public function excel()
    {
        return view('you-wsp/excel');
    }

    public function tomorrow()
    {
        $pacientes = Appointment::tomorrow_appoiments();
        $appointment_last = Appointment::last_register();

        return view('you-wsp/tomorrow',compact('appointment_last','pacientes'));
    }

    public function training()
    {
        return view('you-wsp/training');
    }

    public function medilink()
    {
        $action_last = Action::last_register();
        $appointment_last = Appointment::last_register();
        return view('import',compact('action_last','appointment_last'));
    }

    public function occupation()
    {

    }
}
