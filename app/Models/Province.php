<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
     protected $fillable = [
        'user_id',
        'company_id',
        'name',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function company(){
        return $this -> belongsTo(Company::class,'company_id');
    }
}