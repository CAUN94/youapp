<?php

namespace App\Console\Commands;

use App\Transfer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class fintocHourly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fintoc:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fintoc every hoyr';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $since = Carbon::create(Transfer::last_transfer())->subMonth();
        $until = $since->copy()->addMonth();
        $diff = $now->diffInMonths($since);
        $transfers = [];
        for ($i=0; $i < $diff+1; $i++) {
            $response = Http::withHeaders([
            'Authorization' => 'sk_live_MHJx2wuSA2gpzv-wBSxrhpJHZtGnCM_3',
            ])->get('https://api.fintoc.com/v1/accounts/b8XkZle9TdZlVQ6z/movements',[
                'link_token' => 'link_V2byLzvivAVL0Wnw_token_wys-rVko1A1UNaxvrJFUm3NW',
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
            if (!is_null($value['recipient_account'])){
                $transfer->recipient_rut = $this->rut($value['recipient_account']['holder_id']);
                $transfer->recipient_holder_name = $value['recipient_account']['holder_name'];
                $transfer->recipient_account_number = $value['recipient_account']['number'];
                if(!is_null($value['recipient_account']['institution'])){
                    $transfer->recipient_bank_name = $value['recipient_account']['institution']['name'];
                }
                else {
                    $transfer->recipient_bank_name = Null;
                }
            }
            else {
                $transfer->recipient_rut = Null;
                $transfer->recipient_holder_name = Null;
                $transfer->recipient_account_number = Null;
            }
            if (!is_null($value['sender_account'])){
                $transfer->sender_rut = $this->rut($value['sender_account']['holder_id']);
                $transfer->sender_holder_name = $value['sender_account']['holder_name'];
                $transfer->sender_account_number = $value['sender_account']['number'];
                if(!is_null($value['sender_account']['institution'])){
                    $transfer->sender_bank_name = $value['sender_account']['institution']['name'];
                }
                else {
                    $transfer->sender_bank_name = Null;
                }
            }
            else {
                $transfer->sender_rut = Null;
                $transfer->sender_holder_name = Null;
                $transfer->sender_account_number = Null;
            }
            $transfer->comment = $value['comment'];
            // echo "....<br>";
            // var_dump($transfer);
            $transfer->save();
        }

        $Transfer = Transfer::noRepeat();
        $TransferId = array_column($Transfer ->toArray(), 'id');
        Transfer::whereNotIn('id', $TransferId)->delete();
        $update = Transfer::orderBy('id', 'desc')->first();
        $update->updated_at = Carbon::now();
        $update->save();

        // return back()->with('message-transfers', 'Actualizado');
    }

    public function rut($r)
    {
        $rut = substr($r, 0, -1)."-".substr($r,-1);
        return  $rut;
    }
}
