<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;
    protected $table = 'authors';
    protected $fillable = [
        'fullname',
        'alias',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'writers', 'author_id', 'book_id');
    }
    protected $primaryKey = 'id';

    public $timestamps = true;
}
