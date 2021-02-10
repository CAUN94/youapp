<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FintocController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
        'Authorization' => 'sk_live_tGx736GM-Z98FuhoyLn8ngg9NK75V3sE',
        ])->get('https://api.fintoc.com/v1/links/',[
            'link_token' => 'AMjplGZ1iZYX50Kq_token_yNiNCDE3xa3XaNxK2yGbMdZS',
        ]);

        return $response->json();
    }

    public function movements()
    {
    	$now = Carbon::now();
    	$since = Carbon::create(2018, 8, 1);
    	$until = $since->copy()->addMonth();

		$response = Http::withHeaders([
	    'Authorization' => 'sk_live_tGx736GM-Z98FuhoyLn8ngg9NK75V3sE',
		])->get('https://api.fintoc.com/v1/accounts/b8XkZle9TdZlVQ6z/movements',[
			'link_token' => 'AMjplGZ1iZYX50Kq_token_yNiNCDE3xa3XaNxK2yGbMdZS',
			'since' => $since->format('Y-m-d'),
			'until' => $until->format('Y-m-d'),
			'per_page' => 300,
		]);

    	return $response->json();
    }
}
