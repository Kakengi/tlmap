<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['publication_title', 'book_id', 'author_id', 'user_id', "publication_year", "number_of_pages", 'filename', 'is_large_print'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function publication()
    {
        return $this->belongsToMany(
            Contract::class,
            'publication_contract',
            'publication_id',
            'contract_id'
        )->withPivot('id', 'created_at', 'updated_at', 'quantity', 'is_for_sale');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'publication_id', 'id');
    }
    public function scopeFilter($query, $school_type_id, $school_class_id, $subject_id, $book_category_id, $publication_year, $large_print)
    {
        if ($school_class_id || $book_category_id || $subject_id) {
            $query->whereHas('book', function ($query) use ($school_class_id, $book_category_id, $subject_id) {
                if ($school_class_id) {
                    $query->where('school_class_id', $school_class_id);
                }

                if ($book_category_id) {
                    $query->where('book_category_id', $book_category_id);
                }

                if ($subject_id) {
                    return $query->where('subject_id', $subject_id);
                }
            });
        }

        if ($school_type_id) {
            $query->whereHas('book', function ($query) use ($school_type_id) {
                $query->whereHas('schoolClass', function ($query) use ($school_type_id) {
                    $query->where('school_type_id', $school_type_id);
                });
            });
        }

        if ($large_print) {
            $query->where('is_large_print', 1);
        }

        if ($publication_year) {
            $query->where('publication_year', $publication_year);
        }

        return $query;
    }
}
