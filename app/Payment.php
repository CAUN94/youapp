<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public static function noRepeats()
    {
        return Payment::groupBy('Pago_Nr')->get();
    }

    public static function last_register()
    {
        return Payment::max('updated_at');
    }
}
