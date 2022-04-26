<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Receipt extends Model
{
    public $guarded = [];

    use HasFactory, SoftDeletes;

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'received_by', 'id');
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
