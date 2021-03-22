<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $fillable = ['name','color'];

    public static function searchState($state)
    {
    	return Status::where('name',$state)->first();
    }
}
