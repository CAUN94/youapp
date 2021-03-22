<?php

namespace App\Http\Controllers;

use App\Benefit;
use App\Category;
use App\Patient;
use App\Payment;
use App\Status;
use App\Sucursal;
use App\Transfer;
use App\Treatment;
use App\Professional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $now = Carbon::now();
        $last_benefit = $now->diffInHours(Benefit::max('updated_at'));
        $last_category = $now->diffInHours(Category::max('updated_at'));
        $last_patient = $now->diffInHours(Patient::max('updated_at'));
        $last_status = $now->diffInHours(Status::max('updated_at'));
        $last_sucursal = $now->diffInHours(Sucursal::max('updated_at'));
        $last_treament = $now->diffInHours(Treatment::max('updated_at'));
        return view('home',compact(
            'last_benefit',
            'last_category',
            'last_patient',
            'last_status',
            'last_sucursal',
            'last_treament',
        ));
    }

    public function panel()
    {
        auth::user()->authorizeRoles(['admin']);
        $pacientes = Patient::orderBy('updated_at','desc')->get();
        return view('you-wsp/index',compact('pacientes'));
    }

    public function excel()
    {
        auth::user()->authorizeRoles(['admin']);
        return view('you-wsp/excel');
    }

    public function canceled()
    {
        auth::user()->authorizeRoles(['admin']);
        $firsday = Carbon::create(null,null,null,null,null,null)->startOfWeek()->subDays(7)->format('Y-m-d');
        $lastday = Carbon::create(null,null,null,23,55,55)->subDays(1)->format('Y-m-d');
        $status = array(2,5);
        $date = array($firsday,$lastday);
        $canceled = Treatment::whereIn('status_id',$status)->whereBetween('date',$date)->get();
        // return $canceled;
        foreach ($canceled as $key => $cancel) {
            if(Patient::find($cancel->patient_id)->treatments()->max('number') != $cancel->number){
                $canceled->forget($key);
            }
            $profesional = Professional::find($cancel->professional_id)->getUser();
            $status = Status::find($cancel->status_id);
            $category = Category::find($cancel->category_id);
            $patient = Patient::find($cancel->patient_id);
            $cancel->professional = $profesional['name'];
            $cancel->status = $status['name'];
            $cancel->category = $category['name'];
            $cancel->patient_name = $patient['name'];
            $cancel->patient_lastnames = $patient['lastnames'];
            $cancel->phone = $patient['phone'];
            $cancel->email = $patient['email'];
        }
        $canceled = $canceled->values();

        return view('canceled/index',compact('canceled'));
    }

    public function tomorrow()
    {
        auth::user()->authorizeRoles(['admin']);
        $pacientes = Patient::tomorrow();
        foreach ($pacientes as $paciente) {
            $profesional = Professional::find($paciente->professional_id)->getUser();
            $paciente->professional = $profesional['name'];
        }
        // return $pacientes;
        return view('you-wsp/tomorrow',compact('pacientes'));
    }

    public function training()
    {
        auth::user()->authorizeRoles(['admin']);
        return view('you-wsp/training');
    }

    public function general()
    {
        auth::user()->authorizeRoles(['admin']);
        // $now = Carbon::now()->addMonth();
        $last = Carbon::now()->subYear();
        $endOfYear = $last->copy()->endOfYear();
        $startOfYear = $last->copy()->startOfYear();

        $lastyear = Treatment::finance($startOfYear,$endOfYear);
        // return $lastyear;
        $conveniosLast = Treatment::prevision_year($startOfYear,$endOfYear);

        $now = Carbon::now();
        $endOfYear = $now->copy()->endOfYear();
        $startOfYear = $now->copy()->startOfYear();

        $actualyear = Treatment::finance($startOfYear,$endOfYear);
        $conveniosActual = Treatment::prevision_year($startOfYear,$endOfYear);

        return view('reports.index',compact('lastyear','actualyear','conveniosLast','conveniosActual'));
    }


}
