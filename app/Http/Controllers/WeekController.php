<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class WeekController extends Controller
{
    public function index()
    {
        auth::user()->authorizeRoles(['admin']);
        $last = Carbon::now()->setTimezone('GMT-4');
        $endOfWeek1 = $last->copy()->endOfWeek();
        $startOfWeek1 = $last->copy()->startOfWeek();

        $sql = "select Medio,count(Medio) as count
        from payments
        where Fecha >= '".$startOfWeek1."'
        and Fecha <= '".$endOfWeek1."'
        group by Medio;";

        $pay_methods_week_1 = DB::select( DB::raw($sql));

        $last = Carbon::now()->subweek()->setTimezone('GMT-4');
        $endOfWeek2 = $last->copy()->endOfWeek();
        $startOfWeek2 = $last->copy()->startOfWeek();

        $sql = "select Medio,count(Medio) as count
        from payments
        where Fecha >= '".$startOfWeek2."'
        and Fecha <= '".$endOfWeek2."'
        group by Medio;";

        $pay_methods_week_2 = DB::select( DB::raw($sql));

        return view('week.index',compact(
            'pay_methods_week_1','pay_methods_week_2',
            'startOfWeek1','endOfWeek1',
            'startOfWeek2','endOfWeek2',
        ));
    }

    public function show(Request $request)
    {
        auth::user()->authorizeRoles(['admin']);
        if($request->firstday > $request->lastday){
            return redirect('/');
        }
        $startOfWeek = Carbon::create($request->firstday);
        $endOfWeek = Carbon::create($request->lastday);

       $sql = "select Medio,count(Medio) as count
        from payments
        where Fecha >= '".$startOfWeek."'
        and Fecha <= '".$endOfWeek."'
        group by Medio;";

        $pay_methods_week = DB::select( DB::raw($sql));

        return view('week.show',compact(
            'pay_methods_week','startOfWeek','endOfWeek',
        ));
    }
}
