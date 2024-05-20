<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';
    protected $fillable = [
        'name',
        'description',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'bgs', 'genre_id', 'book_id');
    }
}
