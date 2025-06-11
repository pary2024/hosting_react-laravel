<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    //
    protected $fillable = [
    'name',
    'user_id',
    'province_id',
    'tabLine',
    'location',
    'image',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function province(){
        return $this->belongsTo(Province::class,'province_id');
        
    }

}