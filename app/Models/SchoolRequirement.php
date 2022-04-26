<?php

namespace App\Models;

use Hamcrest\Type\IsInteger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolRequirement extends Model
{
    use HasFactory;

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function scopeFilterByYear($query, $year)
    {

        if (is_integer((int)$year)) {
            $query->where('year_of_study', $year);
        } else {
            $query->where('year_of_study', date('Y'));
        }
        return $query;
    }

    public function scopeSearch($query, $school_name, $school_type_id, $school_class_id, $subject_id)
    {

        if (is_array($school_class_id) && count($school_class_id) > 0) {
            $query->whereIn('school_class_id', $school_class_id);
        }

        if (is_array($subject_id) && count($subject_id) > 0) {
            $query->whereIn('subject_id', $subject_id);
        }

        if ($school_name || $school_type_id) {
            $query->whereHas('school', function ($query) use ($school_name, $school_type_id) {
                if ($school_name) {
                    $query->whereRaw('name LIKE ?', ['%' . $school_name . '%']);
                }
                if ($school_type_id) {
                    $query->whereRaw('school_type_id = ?', [$school_type_id]);
                }
            });
        }

        return $query;
    }
}
