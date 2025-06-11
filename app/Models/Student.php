<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = [
    'name',
    'user_id',
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
    

}