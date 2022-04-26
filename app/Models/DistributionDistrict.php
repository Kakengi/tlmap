<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionDistrict extends Model
{
    use HasFactory;
    protected $fillable = [
        'publication_id',
        'contract_id',
        'district_id',
        'quantity_required',
        'number_of_boxes',
        'quantity_per_box',
        'loose',
        'year_of_study',
        'created_by',
        'received_by',
        'created_at',
        'updated_at',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function scopeFilter($query, $year, $district_id, $region_id)
    {
        if ($year) {
            $query->where('year_of_study', $year);
        }

        if ($district_id) {
            $query->where('district_id', $district_id);
        }
        if ($region_id) {
            $query->whereHas('district', function ($query) use ($region_id) {
                $query->where('region_id', $region_id);
            });
        }

        return $query;
    }
}
