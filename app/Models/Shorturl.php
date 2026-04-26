<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Shorturl extends Model
{
    protected $table = 'shorturl';
    protected $fillable = ['company_id','user_id','original_url','short_url'];

    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}