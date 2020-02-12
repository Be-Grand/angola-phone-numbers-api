<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'birth_date', 'gender', 'email',  'address', 'nif','bi','residence_card','passport'];

    public function phones(){
        return $this->hasMany('App\Models\Phone');
    }
}
