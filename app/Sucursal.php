<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $fillable = ['name','addresss','capacity','type'];

    public static function searchName($name)
    {
    	return Sucursal::where('name',$name)->first();
    }
}
