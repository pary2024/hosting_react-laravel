<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
    'user_id',
    'company_id',
    'description',
    'price',
    'date',
    'qty',
    'amount',
    'total',
    ];
    public function user(){
        return $this-> belongsTo(User::class,'user_id');
    }
    public function company(){
        return $this-> belongsTo(Company::class,'company_id');
    }
}