<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = [
    'name',
    'user_id',
    'company_id',
    'school_id',
    'age',
    'birth_day',
    'gender',
    'grade',
    'parents',
    'status',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function school(){
        return $this->belongsTo(School::class,'school_id');
        
    }
    public function company(){
        return $this -> belongsTo(Company::class,'company_id');
    }
    

}