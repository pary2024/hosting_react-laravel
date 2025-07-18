<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable=[
        'name',
        'email',
        'phone',
        'address',
        'image',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }

}