<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePatient extends Model
{
    //
    protected $fillable = [
    'user_id',
    'patient_id',
    'treat_id',
    'pay_id',
    'price',
    'deposit',
    'debt',
    'total',
    'status',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function treat(){
        return $this->belongsTo(Treat::class,'treat_id');
    }
    public function pay(){
        return $this->belongsTo(PerPay::class,'pay_id');
    }

  
    


}