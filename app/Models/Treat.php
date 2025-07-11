<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treat extends Model
{
    //
    protected $fillable = [
    'name',
    'user_id',
    'company_id'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function company(){
        return $this ->belongsTo(Company::class,'company_id');
    }

}