<?php

namespace App\Http\Controllers;

use App\Transfer;
use App\transfers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();
        $since = Carbon::create(2018,8,1);
        $until = $since->copy()->addMonth();
        $diff = $now->diffInMonths($since);
        $transfers = [];
        for ($i=0; $i < $diff+1; $i++) {
            $response = Http::withHeaders([
            'Authorization' => 'sk_live_tGx736GM-Z98FuhoyLn8ngg9NK75V3sE',
            ])->get('https://api.fintoc.com/v1/accounts/b8XkZle9TdZlVQ6z/movements',[
                'link_token' => 'AMjplGZ1iZYX50Kq_token_yNiNCDE3xa3XaNxK2yGbMdZS',
                'since' => $since->format('Y-m-d'),
                'until' => $until->format('Y-m-d'),
                'per_page' => 300,
            ]);
            $transfers = array_merge($transfers, $response->json());
            $since->addMonth();
            $until->addMonth();
        }

        foreach ($transfers as $key => $value) {
            $transfer = new Transfer();
            $transfer->movemente_id = $value['id'];
            $transfer->amount = $value['amount'];
            $transfer->description = $value['description'];
            $transfer->currency = $value['currency'];
            $transfer->date = $value['post_date'];
            $transfer->transaction_date = $value['transaction_date'];
            $transfer->type = $value['type'];
            $transfer->recipient_account = $value['recipient_account'];
            if (!is_null($value['sender_account'])){
                $sender = $value['sender_account'];
                $transfer->rut = $this->rut($sender['holder_id']);
                $transfer->holder_name = $sender['holder_name'];
                $transfer->account_number = $sender['number'];
                if(!is_null($sender['institution'])){
                    $institution = $sender['institution'];
                    $transfer->bank_name = $institution['name'];
                }
                else {
                    $transfer->bank_name = Null;
                }
            }
            else {
                $transfer->rut = Null;
                $transfer->holder_name = Null;
                $transfer->account_number = Null;
            }
            $transfer->comment = $value['comment'];
            echo "....<br>";
            var_dump($transfer);
            $transfer->save();
        }

        return redirect('/');
    }

    public function rut($r)
    {
        $rut = substr($r, 0, -1)."-".substr($r,-1);
        return  $rut;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function show(transfers $transfers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function edit(transfers $transfers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transfers $transfers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function destroy(transfers $transfers)
    {
        //
    }
}
