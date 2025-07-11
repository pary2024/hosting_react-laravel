<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
    'user_id',
    'company_id',
    'patient_id',
    'phone',
    'note',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');    
    }
    public function company(){
        return $this -> belongsTo(Company::class,'company_id');
    }

}