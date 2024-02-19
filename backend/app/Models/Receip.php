<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receip extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    // protected function photo() : Attribute
    // {
    //     return Attribute::make(
    //         get : fn (string $value) => env("APP_URL") . $value
    //     );
    // }

    public function scopeFilter($query,$filters){
        if(isset($filters["category"])){
            $query->whereHas('category',function($q) use($filters) {
                $q->where("name",$filters['category']);
            });
        }
    }
}
