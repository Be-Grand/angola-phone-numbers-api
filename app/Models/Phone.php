<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Operator;
use App\Models\Customer;

class Phone extends Model
{
    protected $fillable = ['number', 'status', 'customer_id', 'operator_id'];
  
    public function customers(){
        return $this->belongsTo('App\Models\Customer');
    }
    public function operators(){
        return $this->belongsTo('App\Models\Operator');
    }
    public function toArray(){
        return [
            'id' =>$this->id,
            'number'=>$this->number,
            'status'=>$this->status,
            'operator' => Operator::whereId($this->operator_id)->first(),
            'customer' => Customer::whereId($this->customer_id)->first(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
          
        ];
    }
}
