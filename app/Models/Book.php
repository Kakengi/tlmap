<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["title", "description", 'user_id', "book_category_id", "school_class_id", "subject_id", "num_students_per_book"];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function bookCategory()
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $school_type_id, $school_class_id, $subject_id, $book_category_id)
    {
        if ($school_class_id) {
            return $query->where('school_class_id', $school_class_id);
        }

        if ($book_category_id) {
            return $query->where('book_category_id', $book_category_id);
        }

        if ($subject_id) {
            return $query->where('subject_id', $subject_id);
        }

        if ($school_type_id) {
            $query->whereHas('schoolClass', function ($query) use ($school_type_id) {
                $query->where('school_type_id', $school_type_id);
            });
        }
        return $query;
    }
}
