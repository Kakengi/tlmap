<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'contract_title',
        'supplier_id',
        'quantity',
        'delivery_date',
        'contract_year',
        'year_of_study',
        'contract_number',
        'user_id'
    ];

    public function publication()
    {
        return $this->belongsToMany(
            Publication::class,
            'publication_contract',
            'contract_id',
            'publication_id'
        )->withPivot('id', 'created_at', 'updated_at', 'quantity', 'is_for_sale');
    }
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function scopeFilter($query, $contract_year)
    {
        if ($contract_year) {
            $query->whereContractYear($contract_year);
        }
        return $query;
    }
}
