<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copy extends Model
{
    use HasFactory;
    protected $table = 'copies';

    protected $fillable = [
        'book_id',
    ];

    protected $primaryKey = 'id';

    public $timestamps = true;

    /**
     * Relationship with Book model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
