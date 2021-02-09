<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    public static function noRepeats()
    {
        return Treatment::groupBy('Ficha','Atencion','Nombre','Apellidos')->get();
    }

    public static function last_register()
    {
        return Treatment::max('updated_at');
    }
}
