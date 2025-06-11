<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
    'user_id',
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

}