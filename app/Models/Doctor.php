<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
    'name',
    'user_id',
    'speciatly',
    'email',
    'image',
    'status',
   ];
   public function user(){
    return $this->belongsTo(User::class,'user_id');
   }
   
}