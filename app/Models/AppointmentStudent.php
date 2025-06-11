<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentStudent extends Model
{
    //
    protected $fillable = [
    'user_id',
    'student_id',
    'doctor_id',
    'date',
    'time_in',
    'time_out',
    'status',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function student(){
        return $this->belongsTo(Student::class,'student_id');
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    

}