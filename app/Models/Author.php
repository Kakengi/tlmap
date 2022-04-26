<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'short_name', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $name)
    {
        if ($name) {
            $query->whereRaw('name LIKE ?', ['%' . $name . '%'])
                ->orWhereRaw('short_name LIKE ?', ['%' . $name . '%']);
        }
        return $query;
    }
}
