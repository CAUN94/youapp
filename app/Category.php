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

    public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public static function countCategory($firstday,$lastday,$professional = Null){

        $categories = Category::all();
        $categories_count = [];
        foreach ($categories as $category) {
            if(is_null($professional)){
                $categoryCount = $category->countTreatmentsBetween($firstday,$lastday);
            } else {
                $categoryCount = $category->countTreatmentsBetween($firstday,$lastday,$professional);
            }
            if($categoryCount != 0){
                $categories_count[] = array('Categoria' => $category->description, 'Cantidad' => $categoryCount);
            }

        }
        return $categories_count;
    }

    public function countTreatmentsBetween($firstday,$lastday,$professional = Null){
        if(is_null($professional)){
            return $this->treatments()->whereBetween('date',[$firstday,$lastday])->whereIn('status_id', array(3,4))->count();
        }
        return $this->treatments()
        ->whereBetween('date',[$firstday,$lastday])
        ->whereIn('status_id', array(3,4))
        ->where('professional_id',$professional)
        ->count();
    }



}
