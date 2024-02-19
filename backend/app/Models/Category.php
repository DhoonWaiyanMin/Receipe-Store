<?php

namespace App\Models;

use App\Models\Receip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function receipes(){
        return $this->hasMany(Receip::class);
    }
}
