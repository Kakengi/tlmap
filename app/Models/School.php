<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory,SoftDeletes;

   
    
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

}
