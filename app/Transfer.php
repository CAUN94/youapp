<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public static function last_register()
    {
        return Transfer::max('updated_at');
    }

    public static function last_transfer()
    {
        return Transfer::max('transaction_date');
    }

    public static function noRepeat()
    {
        return Transfer::groupBy('movemente_id')->get();
    }
}
