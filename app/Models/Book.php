<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = [
        'ISBN',
        'title',
        'year_of_publication',
        'edition',
        'type',
        'description',
        'cover_addr',
        'number_of_copies',
        'publisher_id',
    ];

    protected $primaryKey = 'id';

    public $timestamps = true;

    public function copies()
    {
        return $this->hasMany(Copy::class);
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'writers', 'book_id', 'author_id');
    }
    public function borrows(): HasManyThrough
    {
        return $this->hasManyThrough(Borrow::class, Copy::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'bgs', 'book_id', 'genre_id');
    }
}
