<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Region;




class District extends Model
{
    use HasFactory, SoftDeletes;


    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
