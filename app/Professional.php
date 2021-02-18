<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    public function categories()
    {
        return $this->belongsToMany(Category::class,'professional_categories');
    }

    public static function getProfessionalMedilink($name)
    {
    	return (Professional::where('medilink',$name)->first() != null) ?
    	Professional::where('medilink',$name)->first() : Professional::where('medilink','Antiguo')->first();
    }
}
