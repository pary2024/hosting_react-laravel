<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DutyDoctor extends Model
{
    protected $fillable = [
    'doctor_id',
    'user_id',
    'company_id',
    'patient_id',
    'treat_id',
    'status',
    'note'
    ];
    public function doctor(){
        return $this -> belongsTo(Doctor::class,'doctor_id');
    }
    public function user(){
        return $this -> belongsTo(User::class,'user_id');
    }
    public function company(){
        return $this -> belongsTo(Company::class,'company_id');
    }
    public function patient(){
        return $this -> belongsTo(Patient::class,'patient_id');
    }
    public function treat(){
        return $this -> belongsTo(Treat::class,'treat_id');
    }
}