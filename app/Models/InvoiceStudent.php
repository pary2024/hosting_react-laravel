<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceStudent extends Model
{
    //
    protected $fillable = [
    'user_id',
    'student_id',
    'treat_id',
    'pay_id',
    'total',
    'status',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function student(){
        return $this->belongsTo(Student::class,'student_id');
    }
    public function treat(){
        return $this->belongsTo(Treat::class,'treat_id');
    }
    public function pay(){
        return $this->belongsTo(PerPay::class,'pay_id');
    }

}