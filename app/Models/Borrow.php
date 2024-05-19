<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $table = 'borrows';
    protected $fillable = [
        'user_id',
        'copy_id',
        'pickedup_at',
        'returned_at',
    ];

    protected $primaryKey = 'id';

    public $timestamps = true;

    /**
     * Relationship with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Copy model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function copy()
    {
        return $this->belongsTo(Copy::class);
    }
}
