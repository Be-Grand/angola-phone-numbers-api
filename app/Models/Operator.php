<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = ['name', 'type'];

    public function phones(){
        return $this->hasMany('App\Models\Phone');
    }
   
}
