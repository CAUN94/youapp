<?php

namespace App\Http\Controllers;

use App\Action;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function history()
    {
    	return Action::agreementHistory();
    }
}
