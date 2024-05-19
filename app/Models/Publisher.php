<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;
    protected $table = 'publishers';
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    protected $primaryKey = 'id';

    public $timestamps = true;

    public function books()
    {
        return $this->hasMany(Book::class, 'publisher_id'); // Specify foreign key
    }
}
