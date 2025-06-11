<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentPatient extends Model
{
    //
    protected $fillable = [
    'user_id',
    'patient_id',
    'doctor_id',
    'date',
    'time_in',
    'time_out',
    'status',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
     public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

}