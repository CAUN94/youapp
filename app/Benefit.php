<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
	protected $fillable = ['name','code','price','description','category_id'];

	public function treatments()
    {
        return $this->belongsToMany(Treatment::class,'benefits_treatments');
    }
}
