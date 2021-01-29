<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Action;
use App\Appointment;

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
        return view('home');
    }

     public function action()
    {
        $actions = Action::all()->sortByDesc('id');
        return view('actions/index',compact('actions'));
    }

    public function appointment()
    {
        $appointments = Appointment::all()->sortByDesc('id');
        return view('appointments/index',compact('appointments'));
    }

    public function panel()
    {
        return view('you-wsp/index');
    }

    public function excel()
    {
        return view('you-wsp/excel');
    }

    public function tomorrow()
    {
        return view('you-wsp/tomorrow');
    }

    public function training()
    {
        return view('you-wsp/training');
    }
}
