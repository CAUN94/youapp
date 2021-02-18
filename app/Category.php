<?php

namespace App;

use App\Professional;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','description'];
    public function professionals()
    {
        return $this->belongsToMany(Professional::class,'professional_categories');
    }

    public function professional($id)
    {
        return $this->professionals()->withPivot('id','percentage')->find($id);
    }

    public function pivot($id)
    {
        return $this->professional($id)->pivot;
    }



}
