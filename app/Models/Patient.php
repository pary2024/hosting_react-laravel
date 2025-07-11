<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $fillable = [
    'name',
    'user_id',
    'company_id',
    'province_id',
    'age',
    'gender',
    'phone',
    'career',
    'status',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function province(){
        return $this->belongsTo(Province::class,'province_id');
    }
    public function company(){
        return $this -> belongsTo(Company::class,'company_id');
    }

}