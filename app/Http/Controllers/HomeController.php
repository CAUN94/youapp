<?php

namespace App\Http\Controllers;

use App\Action;
use App\Appointment;
use App\Payment;
use App\Treatment;
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
        $treatment_last = Treatment::last_register();
        $payment_last = Payment::last_register();
        return view('home',compact('action_last','appointment_last','treatment_last','payment_last'));
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

    public function canceled()
    {
        $canceled = Appointment::canceled();
        return view('canceled/index',compact('canceled'));
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

    // Falta hacer refactoring
    public function general()
    {
        // $now = Carbon::now()->addMonth();
        $last = Carbon::now()->subYear();
        $endOfYear = $last->copy()->endOfYear();
        $startOfYear = $last->copy()->startOfYear();

        // return Action::occupation_summary($startOfYear,$endOfYear);
        $lastyear = DB::select( DB::raw("select month(Fecha_Realizacion) as Fecha,
               sum(Precio_Prestacion) Prestacion,sum(Abonoo) as Abono
        from actions
        where Fecha_Realizacion <= '".$endOfYear."' and Fecha_Realizacion >= '".$startOfYear."'
        group by month(Fecha_Realizacion)  order by Fecha_Realizacion asc;") );

        $conveniosLast =

        $now = Carbon::now();
        $endOfYear = $now->copy()->endOfYear();
        $startOfYear = $now->copy()->startOfYear();

        $actualyear = DB::select( DB::raw("select month(Fecha_Realizacion) as Fecha,
               sum(Precio_Prestacion) Prestacion,sum(Abonoo) as Abono
        from actions
        where Fecha_Realizacion <= '".$endOfYear."' and Fecha_Realizacion >= '".$startOfYear."'
        group by month(Fecha_Realizacion)  order by Fecha_Realizacion asc;") );

        return view('reports.index',compact('lastyear','actualyear'));
    }


}
