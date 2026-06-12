<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['author', 'rating', 'body', 'source', 'is_published', 'published_at'];

    protected $casts = [
        'rating'       => 'integer',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Uniquement les avis publiés par l'admin
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
