<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function shorturls()
    {
        return $this->hasMany(Shorturl::class);
    }

 


}
